<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Coupon;
use Carbon\Carbon;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $totals = $this->getTotals();
        return view('frontend.cart', compact('cart'));
    }

    // Thêm
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session('cart', []);
        $spicyLevel = $request->input('spicy_level', 0);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'base_price_cents' => $product->base_price_cents,
                'quantity' => 1,
                'image_url' => $product->image_url,
                'spicy_level' => $spicyLevel
            ];
        }
        session(['cart' => $cart]);
        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    // Xóa
    public function clear()
    {
        session()->forget('cart');
        return redirect('/cart')->with('success', 'Đã làm trống giỏ hàng để test mới!');
    }

    //cập nhật

    public function update(Request $request, $id)
    {
        $action = $request->input('action');
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            if ($action == 'increase') {
                $cart[$id]['quantity']++;
            } elseif ($action == 'decrease') {
                $cart[$id]['quantity']--;
                if ($cart[$id]['quantity'] <= 0) {
                    unset($cart[$id]);
                }
            }
            session(['cart' => $cart]);
        }

        return redirect()->back();
    }

    //remove
    public function remove($id)
    {
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
            return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }
    }


    // Áp dụng mã giảm giá
    public function applyCoupon(Request $request)
    {
        // 1. Kiểm tra người dùng có nhập mã không
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $code = strtoupper(trim($request->coupon_code)); // Chuẩn hóa: GIAM10, giam10, " giam10 " đều hợp lệ

        // 2. Tìm mã trong database
        $coupon = Coupon::where('code', $code)
            ->where('is_active', true) // nếu bạn có trường này
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', Carbon::now());
            })
            ->first();

        // 3. Nếu không tìm thấy hoặc hết hạn
        if (!$coupon) {
            return back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn!');
        }

        // 4. Kiểm tra đơn hàng tối thiểu (nếu có)
        $subtotal = $this->calculateSubtotal(); // cents
        if ($coupon->min_order_total_amount_cents && $subtotal < $coupon->min_order_total_amount_cents) {
            return back()->with('error', 'Đơn hàng phải từ ' . number_format($coupon->min_order_total_amount_cents / 100) . 'đ trở lên!');
        }

        // 5. Lưu mã giảm vào session để dùng sau
        session(['coupon' => $coupon]);

        return back()->with('success', 'Áp dụng mã giảm giá thành công!');
    }

    // Xóa mã giảm giá
    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Đã xóa mã giảm giá!');
    }

    // Helper tính tạm tính (subtotal)
    private function calculateSubtotal()
    {
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['base_price_cents'] * $item['quantity'];
        }
        return $total; // trả về cents
    }

    // Helper tính tất cả tiền (dùng để hiển thị ở giỏ hàng)
    public function getTotals()
    {
        $subtotalCents = $this->calculateSubtotal();
        $discountCents = 0;

        if ($coupon = session('coupon')) {
            if ($coupon->discount_type === 'percent') {
                $discountCents = ($subtotalCents * $coupon->discount_value) / 100;
            } else { // fixed
                $discountCents = $coupon->discount_value;
            }
            // Không giảm quá tổng tiền
            if ($discountCents > $subtotalCents) {
                $discountCents = $subtotalCents;
            }
        }

        $afterDiscount = $subtotalCents - $discountCents;
        $vatCents = $afterDiscount * 10 / 100; // VAT 10%
        $totalCents = $afterDiscount + $vatCents;

        return [
            'subtotal'  => $subtotalCents / 100,
            'discount'  => $discountCents / 100,
            'vat'       => $vatCents / 100,
            'total'     => $totalCents / 100,
        ];
    }
}