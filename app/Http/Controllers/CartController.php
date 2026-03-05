<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
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

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function clear()
    {
        $this->cart->clear();

        return redirect('/cart')->with('success', 'Đã làm trống giỏ hàng.');
    }

    public function update(Request $request, $id)
    {
        $action = (string) $request->input('action');
        $this->cart->updateQuantity($id, $action);

        return redirect()->back();
    }

    public function remove($id)
    {
        if ($this->cart->remove($id)) {
            return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }

        return redirect()->back();
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = $this->cart->applyCouponByCode((string) $request->coupon_code);
        if (! $coupon) {
            return back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn!');
        }

        $subtotal = $this->cart->subtotal();
        if ($coupon->min_order_total_amount_cents && $subtotal < (int) $coupon->min_order_total_amount_cents) {
            return back()->with('error', 'Đơn hàng phải từ '.number_format($coupon->min_order_total_amount_cents / 100).'đ trở lên!');
        }

        return back()->with('success', 'Áp dụng mã giảm giá thành công!');
    }

    public function removeCoupon()
    {
        $this->cart->removeCoupon();

        return back()->with('success', 'Đã xóa mã giảm giá!');
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
}
