<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderCoupon;
use App\Models\Coupon;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Hiển thị form checkout
     */
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Tính toán tiền
        $subtotalCents = 0;
        foreach ($cart as $item) {
            $subtotalCents += $item['base_price_cents'] * $item['quantity'];
        }

        $discountCents = 0;
        $coupon = session('coupon');
        if ($coupon) {
            if ($coupon->discount_type === 'percent') {
                $discountCents = ($subtotalCents * $coupon->discount_value) / 100;
                if ($coupon->max_discount_amount_cents) {
                    $discountCents = min($discountCents, $coupon->max_discount_amount_cents);
                }
            } elseif ($coupon->discount_type === 'fixed') {
                $discountCents = $coupon->discount_value;
            }
            $discountCents = min($discountCents, $subtotalCents);
        }

        // Phí ship: miễn phí từ 200k
        $shippingFeeCents = ($subtotalCents >= 200000) ? 0 : 30000;

        // VAT 10% tính trên tiền sau giảm
        $afterDiscountCents = $subtotalCents - $discountCents;
        $vatCents = $afterDiscountCents * 0.1;

        $totalCents = $afterDiscountCents + $vatCents + $shippingFeeCents;

        return view('frontend.checkout', compact(
            'cart',
            'subtotalCents',
            'discountCents',
            'shippingFeeCents',
            'vatCents',
            'totalCents',
            'coupon'
        ));
    }

    /**
     * Xử lý đặt hàng
     */
    public function store(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart');
        }

        // Validate thông tin khách hàng
        $request->validate([
            'shipping_name'     => 'required|string|max:255',
            'shipping_phone'    => 'required|string|regex:/^0[0-9]{9}$/',
            'shipping_address'  => 'required|string|max:500',
            'note'              => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cash,bank_transfer,online',
        ]);

        // Tính lại tiền (tránh khách sửa frontend)
        $subtotalCents = 0;
        foreach ($cart as $item) {
            $subtotalCents += $item['base_price_cents'] * $item['quantity'];
        }

        $discountCents = 0;
        $coupon = session('coupon');
        if ($coupon) {
            if ($coupon->discount_type === 'percent') {
                $discountCents = ($subtotalCents * $coupon->discount_value);
                if ($coupon->max_discount_amount_cents) {
                    $discountCents = min($discountCents, $coupon->max_discount_amount_cents);
                }
            } elseif ($coupon->discount_type === 'fixed') {
                $discountCents = $coupon->discount_value;
            }
            $discountCents = min($discountCents, $subtotalCents);
        }

        $shippingFeeCents = ($subtotalCents >= 200000) ? 0 : 30000;
        $afterDiscountCents = $subtotalCents - $discountCents;
        $vatCents = $afterDiscountCents * 0.1;
        $totalCents = $afterDiscountCents + $vatCents + $shippingFeeCents;

        // Tạo đơn hàng
        $order = Order::create([
            'user_id'               => auth()->id() ?? null,
            'order_number'          => 'DH' . strtoupper(Str::random(8)), // Ví dụ: DHABCD1234
            'status'                => 'pending',
            'subtotal_cents'        => $subtotalCents,
            'total_discount_cents'  => $discountCents,
            'shipping_fee_cents'    => $shippingFeeCents,
            'total_amount_cents'    => $totalCents,
            'shipping_name'         => $request->shipping_name,
            'shipping_phone'        => $request->shipping_phone,
            'shipping_address'      => $request->shipping_address,
            'note'                  => $request->note ?? null,
        ]);

        // Lưu chi tiết món ăn
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id'         => $order->id,
                'product_id'       => $productId,
                'quantity'         => $item['quantity'],
                'unit_price_cents' => $item['base_price_cents'],
                'total_cents'      => $item['base_price_cents'] * $item['quantity'],
            ]);
        }
        Payment::create([
            'order_id'          => $order->id,
            'payment_method'    => $request->payment_method,
            'amount_cents'      => $totalCents, // tổng tiền đơn
            'transaction_code'  => null, // để trống nếu COD/chuyển khoản
            'status'            => 'pending', // chờ thanh toán
            'payment_date'      => null,
        ]);

        // Lưu coupon đã dùng (nếu có)
        if ($coupon) {
            OrderCoupon::create([
                'order_id'              => $order->id,
                'coupon_id'             => $coupon->id,
                'discount_amount_cents' => $discountCents,
            ]);

            // Tăng số lần sử dụng coupon
            $coupon->increment('used_count');
        }

        // Xóa giỏ hàng và coupon khỏi session
        session()->forget(['cart', 'coupon']);

        return redirect()->route('cart')->with('success', 'Đặt hàng thành công! Mã đơn hàng của bạn là ' . $order->order_number);
    }
}
