<?php

namespace App\Models;

use Carbon\Carbon;

class Cart
{
    private const CART_SESSION_KEY = 'cart';

    private const COUPON_ID_SESSION_KEY = 'coupon_id';

    private const COUPON_LEGACY_SESSION_KEY = 'coupon';

    private const FREE_SHIP_THRESHOLD = 200000;

    private const SHIPPING_FEE = 30000;

    private const VAT_RATE = 0.1;

    public function items(): array
    {
        return session(self::CART_SESSION_KEY, []);
    }

    public function hasItems(): bool
    {
        return ! empty($this->items());
    }

    public function addProduct(Product $product, int $spicyLevel = 0): void
    {
        $cart = $this->items();
        $key = (string) $product->id;

        if (isset($cart[$key])) {
            $cart[$key]['quantity']++;
        } else {
            $cart[$key] = [
                'name' => $product->name,
                'base_price_cents' => (int) $product->base_price_cents,
                'quantity' => 1,
                'image_url' => $product->image_url,
                'spicy_level' => $spicyLevel,
            ];
        }

        session([self::CART_SESSION_KEY => $cart]);
    }

    public function updateQuantity(int|string $productId, string $action): void
    {
        $cart = $this->items();
        $key = (string) $productId;

        if (! isset($cart[$key])) {
            return;
        }

        if ($action === 'increase') {
            $cart[$key]['quantity']++;
        } elseif ($action === 'decrease') {
            $cart[$key]['quantity']--;
            if ((int) $cart[$key]['quantity'] <= 0) {
                unset($cart[$key]);
            }
        }

        session([self::CART_SESSION_KEY => $cart]);
    }

    public function remove(int|string $productId): bool
    {
        $cart = $this->items();
        $key = (string) $productId;

        if (! isset($cart[$key])) {
            return false;
        }

        unset($cart[$key]);
        session([self::CART_SESSION_KEY => $cart]);

        return true;
    }

    public function clear(): void
    {
        session()->forget(self::CART_SESSION_KEY);
    }

    public function subtotal(array $customItems = null): int
    {
        $subtotal = 0;
        // Nếu có truyền mảng custom thì dùng mảng đó, không thì dùng toàn bộ giỏ hàng
        $items = $customItems !== null ? $customItems : $this->items();

        foreach ($items as $item) {
            $subtotal += ((int) ($item['base_price_cents'] ?? 0)) * ((int) ($item['quantity'] ?? 0));
        }

        return $subtotal;
    }

    public function coupon(): ?Coupon
    {
        $couponId = (int) session(self::COUPON_ID_SESSION_KEY, 0);
        if ($couponId > 0) {
            return Coupon::find($couponId);
        }

        $legacyCoupon = session(self::COUPON_LEGACY_SESSION_KEY);
        if ($legacyCoupon instanceof Coupon) {
            session([self::COUPON_ID_SESSION_KEY => $legacyCoupon->id]);
            session()->forget(self::COUPON_LEGACY_SESSION_KEY);

            return Coupon::find($legacyCoupon->id);
        }

        return null;
    }

    public function applyCouponByCode(string $code): ?Coupon
    {
        $coupon = Coupon::where('code', strtoupper(trim($code)))
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', Carbon::now());
            })
            ->first();

        if (! $coupon) {
            return null;
        }

        $subtotal = $this->subtotal();
        if ($coupon->min_order_total_amount_cents && $subtotal < (int) $coupon->min_order_total_amount_cents) {
            return null;
        }

        session([self::COUPON_ID_SESSION_KEY => $coupon->id]);
        session()->forget(self::COUPON_LEGACY_SESSION_KEY);

        return $coupon;
    }

    public function removeCoupon(): void
    {
        session()->forget([self::COUPON_ID_SESSION_KEY, self::COUPON_LEGACY_SESSION_KEY]);
    }

    public function summary(array $customItems = null): array
    {
        // Truyền $customItems vào subtotal để tính giá tạm tính
        $subtotalCents = $this->subtotal($customItems);
        $coupon = $this->coupon();
        $discountCents = 0;

        if ($coupon) {
            if ($coupon->discount_type === 'percent') {
                $discountCents = (int) round($subtotalCents * ((float) $coupon->discount_value) / 100);
                if ($coupon->max_discount_amount_cents) {
                    $discountCents = min($discountCents, (int) $coupon->max_discount_amount_cents);
                }
            } else {
                $discountCents = (int) $coupon->discount_value;
            }
            $discountCents = min($discountCents, $subtotalCents);
        }

        $afterDiscountCents = $subtotalCents - $discountCents;
        $vatCents = (int) round($afterDiscountCents * self::VAT_RATE);
        $isFreeShip = $subtotalCents >= self::FREE_SHIP_THRESHOLD;
        $shippingFeeCents = $isFreeShip ? 0 : self::SHIPPING_FEE;
        $totalCents = $afterDiscountCents + $vatCents + $shippingFeeCents;
        $progressPercent = self::FREE_SHIP_THRESHOLD > 0
            ? min(100, ($subtotalCents / self::FREE_SHIP_THRESHOLD) * 100)
            : 100;

        return [
            'subtotal' => $subtotalCents,
            'discount' => $discountCents,
            'after_discount' => $afterDiscountCents,
            'vat' => $vatCents,
            'shipping_fee' => $shippingFeeCents,
            'total' => $totalCents,
            'free_ship_threshold' => self::FREE_SHIP_THRESHOLD,
            'is_free_ship' => $isFreeShip,
            'progress_percent' => $progressPercent,
            'remaining_for_free_ship' => max(0, self::FREE_SHIP_THRESHOLD - $subtotalCents),
        ];
    }
}
