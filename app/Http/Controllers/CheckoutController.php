<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderCoupon;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Services\InventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly InventoryService $inventoryService,
        private readonly Cart $cart
    ) {}

    public function index(Request $request): View|RedirectResponse
    {
        // 1. Lấy danh sách ID sản phẩm từ URL và lưu vào session
        if ($request->has('items')) {
            session(['checkout_items' => explode(',', $request->items)]);
        }

        $selectedIds = session('checkout_items', []);
        $allCartItems = $this->cart->items();

        // 2. Lọc giỏ hàng: chỉ lấy sản phẩm có ID nằm trong danh sách đã chọn
        $cart = array_intersect_key($allCartItems, array_flip($selectedIds));

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Vui lòng chọn ít nhất một sản phẩm để thanh toán!');
        }

        // 3. Tính tiền theo các món đã chọn
        $summary = $this->cart->summary($cart);
        $coupon = $this->cart->coupon();

        $subtotalCents = $summary['subtotal'];
        $discountCents = $summary['discount'];
        $shippingFeeCents = $summary['shipping_fee'];
        $vatCents = $summary['vat'];
        $totalCents = $summary['total'];

        $defaultAddressText = '';
        $user = Auth::user();
        if ($user instanceof User) {
            $defaultAddress = $user
                ->addresses()
                ->where('is_default', true)
                ->first();

            if ($defaultAddress) {
                $parts = array_filter([
                    $defaultAddress->address_detail,
                    $defaultAddress->ward,
                    $defaultAddress->district,
                    $defaultAddress->city,
                ]);
                $defaultAddressText = implode(', ', $parts);
            }
        }

        return view('frontend.checkout', compact(
            'cart',
            'defaultAddressText',
            'subtotalCents',
            'discountCents',
            'shippingFeeCents',
            'vatCents',
            'totalCents',
            'coupon'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        // Lấy lại danh sách món đã chọn từ session
        $selectedIds = session('checkout_items', []);
        $allCartItems = $this->cart->items();
        $cart = array_intersect_key($allCartItems, array_flip($selectedIds));

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Vui lòng chọn sản phẩm để thanh toán!');
        }

        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|regex:/^0[0-9]{9}$/',
            'shipping_address' => 'required|string|max:500',
            'note' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cash,bank_transfer,online',
        ]);

        $summary = $this->cart->summary($cart);
        $coupon = $this->cart->coupon();

        $subtotalCents = (int) $summary['subtotal'];
        $discountCents = (int) $summary['discount'];
        $shippingFeeCents = (int) $summary['shipping_fee'];
        $vatCents = (int) $summary['vat'];
        $totalCents = (int) $summary['total'];

        try {
            $order = DB::transaction(function () use (
                $request,
                $cart,
                $subtotalCents,
                $discountCents,
                $shippingFeeCents,
                $vatCents,
                $totalCents,
                $coupon
            ) {
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'order_number' => 'DH' . strtoupper(Str::random(8)),
                    'status' => 'pending',
                    'subtotal_cents' => $subtotalCents,
                    'total_discount_cents' => $discountCents,
                    'shipping_fee_cents' => $shippingFeeCents,
                    'vat_cents' => $vatCents,
                    'total_amount_cents' => $totalCents,
                    'shipping_name' => $request->shipping_name,
                    'shipping_phone' => $request->shipping_phone,
                    'shipping_address' => $request->shipping_address,
                    'note' => $request->note ?? null,
                ]);

                foreach ($cart as $productId => $item) {
                    $product = Product::lockForUpdate()->findOrFail((int) $productId);
                    $quantity = (int) $item['quantity'];

                    $this->inventoryService->stockOutForOrder(
                        $product,
                        $quantity,
                        'order',
                        'Xuất kho cho đơn hàng ' . $order->order_number
                    );

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => (int) $productId,
                        'quantity' => $quantity,
                        'unit_price_cents' => (int) $item['base_price_cents'],
                        'total_cents' => (int) $item['base_price_cents'] * $quantity,
                    ]);
                }

                Payment::create([
                    'order_id' => $order->id,
                    'payment_method' => $request->payment_method,
                    'amount_cents' => $totalCents,
                    'transaction_code' => null,
                    'status' => 'pending',
                    'payment_date' => null,
                ]);

                if ($coupon) {
                    OrderCoupon::create([
                        'order_id' => $order->id,
                        'coupon_id' => $coupon->id,
                        'discount_amount_cents' => $discountCents,
                    ]);
                    $coupon->increment('used_count');
                }

                return $order;
            });
        } catch (ValidationException $e) {
            return redirect()->route('cart')->withErrors($e->errors());
        }

        // Chỉ xóa các món đã mua khỏi giỏ
        foreach ($selectedIds as $id) {
            $this->cart->remove($id);
        }

        session()->forget('checkout_items');
        $this->cart->removeCoupon();

        return redirect()->route('my-orders')
            ->with('success', 'Đặt hàng thành công! Mã đơn hàng của bạn là ' . $order->order_number);
    }
}