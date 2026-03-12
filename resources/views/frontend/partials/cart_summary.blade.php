<div class="cart-summary" id="cart-summary" data-free-ship-threshold="{{ (int) ($summary['free_ship_threshold'] ?? 0) }}"
    data-shipping-fee-default="30000" data-vat-rate="0.1" data-discount-type="{{ $coupon?->discount_type ?? '' }}"
    data-discount-value="{{ (int) ($coupon?->discount_value ?? 0) }}"
    data-discount-max="{{ (int) ($coupon?->max_discount_amount_cents ?? 0) }}"
    data-discount-min="{{ (int) ($coupon?->min_order_total_amount_cents ?? 0) }}">
    <div class="summary-header">
        <i class="fas fa-receipt"></i>
        <h3>Tổng thanh toán</h3>
    </div>

    <div class="summary-rows">
        <div class="summary-row">
            <span class="label">Tạm tính</span>
            <span class="value" id="summary-subtotal">{{ number_format($summary['subtotal']) }}d</span>
        </div>

        <div class="summary-row">
            <span class="label">Phí vận chuyển</span>
            <span class="value free-shipping" id="summary-shipping">
                @if ($summary['is_free_ship'])
                    <i class="fas fa-check-circle"></i> Miễn phí
                @else
                    {{ number_format($summary['shipping_fee']) }}d
                @endif
            </span>
        </div>

        <div class="summary-row text-success" id="discount-row"
            @if ($summary['discount'] <= 0) style="display: none;" @endif>
            <span class="label">Giảm giá
                @if ($coupon)
                    ({{ strtoupper($coupon->code) }})
                @endif
            </span>
            <span class="value" id="summary-discount">- {{ number_format($summary['discount']) }}d</span>
        </div>

        <div class="summary-row">
            <span class="label">Thuế VAT (10%)</span>
            <span class="value" id="summary-vat">{{ number_format($summary['vat']) }}d</span>
        </div>

        <div class="summary-row total">
            <span class="label">Tổng cộng</span>
            <span class="value" id="summary-total">{{ number_format($summary['total']) }}d</span>
        </div>
    </div>

    <div class="shipping-progress-container">
        <div class="progress-text">
            <span id="free-ship-message">
                @if ($summary['is_free_ship'])
                    <strong class="text-success">Bạn đã đủ điều kiện miễn phí ship!</strong>
                @else
                    Thêm {{ number_format($summary['remaining_for_free_ship']) }}d để được miễn phí ship
                @endif
            </span>
            <span id="free-ship-percent">{{ round($summary['progress_percent']) }}%</span>
        </div>
        <div class="progress-bar">
            <div class="progress-fill" id="free-ship-progress" style="width: {{ $summary['progress_percent'] }}%">
            </div>
        </div>
    </div>

    <div class="promo-section">
        <div class="promo-header">
            <i class="fas fa-tag"></i>
            <h4>Mã giảm giá</h4>
        </div>

        @if ($coupon)
            <div class="alert alert-success mt-3 d-flex justify-content-between align-items-center p-2">
                <div>
                    <strong>{{ strtoupper($coupon->code) }}</strong>
                    <small class="d-block">
                        Giảm
                        {{ $coupon->discount_type == 'percent'
                            ? $coupon->discount_value . '%'
                            : number_format($coupon->discount_value) . 'd' }}
                    </small>
                </div>
                <form action="{{ route('cart.removeCoupon') }}" method="POST" style="margin: 0;" class="js-cart-form">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger py-1 px-2">Xóa</button>
                </form>
            </div>
        @else
            <form action="{{ route('cart.applyCoupon') }}" method="POST" class="promo-input-group mt-3 js-cart-form">
                @csrf
                <input type="text" name="coupon_code" class="promo-input" placeholder="Nhập mã..."
                    value="{{ old('coupon_code') }}" required>
                <button type="submit" class="apply-btn px-3">Áp dụng</button>
            </form>
        @endif
    </div>

    <a href="{{ route('checkout') }}" id="btn-checkout" class="checkout-btn"> <i class="fas fa-lock"></i>
        Thanh toán an toàn
    </a>

    <div class="payment-methods">
        <div class="payment-method"><i class="fab fa-cc-visa"></i></div>
        <div class="payment-method"><i class="fab fa-cc-mastercard"></i></div>
        <div class="payment-method"><i class="fab fa-cc-paypal"></i></div>
        <div class="payment-method"><i class="fas fa-qrcode"></i></div>
    </div>
</div>
