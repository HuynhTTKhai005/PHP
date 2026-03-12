<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private readonly Cart $cart) {}

    public function index(Request $request)
    {
        $cart = $this->cart->items();
        $coupon = $this->cart->coupon();
        $summary = $this->cart->summary();
        $wishlistProductIds = [];

        if ($request->user()) {
            $wishlistProductIds = Wishlist::query()
                ->where('user_id', $request->user()->id)
                ->pluck('product_id')
                ->all();
        }

        return view('frontend.cart', compact('cart', 'wishlistProductIds', 'coupon', 'summary'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $spicyLevel = (int) $request->input('spicy_level', 0);
        $this->cart->addProduct($product, $spicyLevel);

        return $this->respondCart($request, 'Đã thêm vào giỏ hàng!');
    }

    public function clear(Request $request)
    {
        $this->cart->clear();

        return $this->respondCart($request, 'Đã làm trống giỏ hàng.', redirect('/cart'));
    }

    public function update(Request $request, $id)
    {
        $action = (string) $request->input('action');
        $this->cart->updateQuantity($id, $action);

        return $this->respondCart($request, 'Cập nhật giỏ hàng thành công.');
    }

    public function remove(Request $request, $id)
    {
        if ($this->cart->remove($id)) {
            return $this->respondCart($request, 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }

        return $this->respondCart($request, 'Sản phẩm không tồn tại trong giỏ hàng.', null, 'error', 404);
    }

    public function removeSelected(Request $request): RedirectResponse|JsonResponse
    {
        $items = array_filter(explode(',', (string) $request->input('items', '')));

        if (empty($items)) {
            return $this->respondCart($request, 'Vui lòng chọn sản phẩm cần xóa.', null, 'error', 422);
        }

        foreach ($items as $id) {
            $this->cart->remove($id);
        }

        return $this->respondCart($request, 'Đã xóa sản phẩm đã chọn.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = $this->cart->applyCouponByCode((string) $request->coupon_code);
        if (! $coupon) {
            return $this->respondCart($request, 'Mã giảm giá không hợp lệ hoặc đã hết hạn!', null, 'error', 422);
        }

        $subtotal = $this->cart->subtotal();
        if ($coupon->min_order_total_amount_cents && $subtotal < (int) $coupon->min_order_total_amount_cents) {
            return $this->respondCart(
                $request,
                'Đơn hàng phải từ ' . number_format($coupon->min_order_total_amount_cents / 100) . 'd trở lên!',
                null,
                'error',
                422
            );
        }

        return $this->respondCart($request, 'Áp dụng mã giảm giá thành công!');
    }

    public function removeCoupon(Request $request)
    {
        $this->cart->removeCoupon();

        return $this->respondCart($request, 'Đã xóa mã giảm giá!');
    }

    public function getTotals(): array
    {
        $summary = $this->cart->summary();

        return [
            'subtotal' => $summary['subtotal'],
            'discount' => $summary['discount'],
            'vat' => $summary['vat'],
            'total' => $summary['total'],
        ];
    }

    private function respondCart(
        Request $request,
        string $message,
        ?RedirectResponse $fallback = null,
        string $status = 'success',
        int $code = 200
    ): RedirectResponse|JsonResponse {
        if ($request->expectsJson()) {
            $cart = $this->cart->items();
            $coupon = $this->cart->coupon();
            $summary = $this->cart->summary();
            $wishlistProductIds = [];

            if ($request->user()) {
                $wishlistProductIds = Wishlist::query()
                    ->where('user_id', $request->user()->id)
                    ->pluck('product_id')
                    ->all();
            }

            $itemsHtml = view('frontend.partials.cart_items', [
                'cart' => $cart,
                'wishlistProductIds' => $wishlistProductIds,
            ])->render();

            $summaryHtml = view('frontend.partials.cart_summary', [
                'summary' => $summary,
                'coupon' => $coupon,
            ])->render();

            return response()->json([
                'status' => $status,
                'message' => $message,
                'cart_count' => $this->cartCount($cart),
                'items_html' => $itemsHtml,
                'summary_html' => $summaryHtml,
            ], $code);
        }

        $redirect = $fallback ?? redirect()->back();

        return $redirect->with($status, $message);
    }

    private function cartCount(array $cart): int
    {
        $count = 0;
        foreach ($cart as $item) {
            $count += (int) ($item['quantity'] ?? 0);
        }

        return $count;
    }
}
