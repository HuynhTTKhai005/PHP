@extends('layouts.pato')


@section('content')
    <!-- Main Container -->
    <div class="container">
        <!-- Cart Header -->
        <div class="cart-header">
        </div>

        <!-- Main Layout -->
        <div class="cart-layout">
            {{-- Cột trái --}}
            <div class="cart-items">
                @php
                    $cart = session('cart', []);
                @endphp

                @if (count($cart) > 0)
                    @foreach ($cart as $id => $item)
                        <div class="cart-item">
                            <div class="product-grid">
                                <div class="product-image">
                                    <img src="{{ asset($item['image_url'] ?? 'default.jpg') }}" alt="{{ $item['name'] }}">
                                    <span class="stock-badge in-stock">Còn hàng</span>
                                </div>

                                <div class="product-details">
                                    <a href="#" class="product-title">{{ $item['name'] }}</a>

                                    <div class="product-variants">
                                    </div>

                                    {{-- Chỉnh số lượng sản phẩm --}}
                                    <div class="quantity-controls">
                                        <form action="{{ route('cart.update', $id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="decrease">
                                            <button type="submit" class="qty-btn minus-btn"><i
                                                    class="fas fa-minus"></i></button>
                                        </form>

                                        <input type="number" class="quantity-input" value="{{ $item['quantity'] }}"
                                            readonly>
                                        <form action="{{ route('cart.update', $id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="increase">
                                            <button type="submit" class="qty-btn plus btn"><i class="fas fa-plus"></i>
                                            </button>
                                        </form>

                                    </div>

                                    <div class="product-actions">
                                        <button class="action-btn save">
                                            <i class="far fa-bookmark"></i> Lưu sau
                                        </button>
                                        <div class="p-2">Cấp độ cay: {{ $item['spicy_level'] ?? 'Không' }}</div>
                                    </div>
                                </div>

                                {{-- Giá --}}
                                <div class="price-section">
                                    <div class="price-container">
                                        <span class="current-price">
                                            {{ number_format($item['base_price_cents'] ?? 0) }}đ
                                        </span>

                                        {{-- Dấu X xóa --}}
                                    </div>
                                    <a href="{{ route('cart.remove', $id) }}" class="remove-btn">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center p-t-100 p-b-100">
                        <h3>Giỏ hàng của bạn đang trống</h3>
                        <a href="{{ route('menu') }}" class="btn3 flex-c-m size13 txt11 trans-0-4 m-t-30">
                            Tiếp tục mua sắm
                        </a>
                    </div>
                @endif
            </div>

            <!-- Right Column: Cart Summary -->
            <div class="cart-summary">
                <div class="summary-header">
                    <i class="fas fa-receipt"></i>
                    <h3>Tổng thanh toán</h3>
                </div>

                @php
                    // Lấy giỏ hàng từ session
                    $cart = session('cart', []);

                    // Tính subtotal (tạm tính)
                    $subtotalCents = 0;
                    foreach ($cart as $item) {
                        $subtotalCents += $item['base_price_cents'] * $item['quantity'];
                    }
                    $subtotal = $subtotalCents;

                    // Tính giảm giá từ coupon
                    $discount = 0;
                    $coupon = session('coupon');
                    if ($coupon) {
                        if ($coupon->discount_type === 'percent') {
                            $discount = $subtotalCents * $coupon->discount_value;
                        } elseif ($coupon->discount_type === 'fixed') {
                            $discount = $coupon->discount_value;
                        }
                        // Không giảm quá subtotal
                        $discount = min($discount, $subtotalCents);
                    }
                    $discount = $discount;

                    // Tiền sau giảm
                    $afterDiscount = $subtotal - $discount;

                    // VAT 10% tính trên tiền sau giảm
                    $vat = $afterDiscount * 0.1;

                    // Tổng cộng cuối cùng
                    $total = $afterDiscount + $vat;

                    // Logic miễn phí ship (ví dụ: miễn phí từ 200.000đ trở lên)
                    $freeShipThreshold = 200000; // 200k
                    $isFreeShip = $subtotalCents >= $freeShipThreshold;
                    $progressPercent = min(100, $subtotalCents / $freeShipThreshold);
                @endphp

                <div class="summary-rows">
                    <!-- Tạm tính -->
                    <div class="summary-row">
                        <span class="label">Tạm tính</span>
                        <span class="value">{{ number_format($subtotal) }}đ</span>
                    </div>

                    <!-- Phí vận chuyển -->
                    <div class="summary-row">
                        <span class="label">Phí vận chuyển</span>
                        <span class="value free-shipping">
                            @if ($isFreeShip)
                                <i class="fas fa-check-circle"></i> Miễn phí
                            @else
                                30.000đ
                            @endif
                        </span>
                    </div>

                    <!-- Giảm giá (nếu có) -->
                    @if ($discount > 0)
                        <div class="summary-row text-success">
                            <span class="label">Giảm giá
                                @if ($coupon)
                                    ({{ strtoupper($coupon->code) }})
                                @endif
                            </span>
                            <span class="value">- {{ number_format($discount) }}đ</span>
                        </div>
                    @endif

                    <!-- Thuế VAT -->
                    <div class="summary-row">
                        <span class="label">Thuế VAT (10%)</span>
                        <span class="value">{{ number_format($vat) }}đ</span>
                    </div>

                    <!-- Tổng cộng -->
                    <div class="summary-row total">
                        <span class="label">Tổng cộng</span>
                        <span class="value">{{ number_format($total) }}đ</span>
                    </div>
                </div>

                <!-- Shipping Progress -->
                <div class="shipping-progress-container">
                    <div class="progress-text">
                        <span>
                            @if ($isFreeShip)
                                <strong>Bạn đã đủ điều kiện miễn phí ship!</strong>
                            @else
                                Thêm {{ number_format($freeShipThreshold - $subtotalCents) }}đ để được miễn
                                phí ship
                            @endif
                        </span>
                        <span>{{ round($progressPercent) }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $progressPercent }}%"></div>
                    </div>
                </div>

                <!-- Promo Code (giữ nguyên phần bạn đã làm rất tốt) -->
                <div class="promo-section">
                    <div class="promo-header">
                        <i class="fas fa-tag"></i>
                        <h4>Mã giảm giá</h4>
                    </div>

                    @if (session('coupon'))
                        <div class="alert alert-success mt-3 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ strtoupper(session('coupon.code')) }}</strong>
                                <small class="d-block">
                                    Giảm
                                    {{ session('coupon.discount_type') == 'percent'
                                        ? session('coupon.discount_value') . '%'
                                        : number_format(session('coupon.discount_value')) . 'đ' }}
                                </small>
                            </div>
                            <form action="{{ route('cart.removeCoupon') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('cart.applyCoupon') }}" method="POST" class="promo-input-group mt-3">
                            @csrf
                            <input type="text" name="coupon_code" class="promo-input" placeholder="Nhập mã giảm giá..."
                                value="{{ old('coupon_code') }}" required>
                            <button type="submit" class="apply-btn">Áp dụng</button>
                        </form>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success mt-3">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                    @endif
                </div>

                <!-- Checkout Button -->
                <a href="{{ route('checkout') }}" class="checkout-btn"> <i class="fas fa-lock"></i>
                    Thanh toán an toàn
                </a>

                <!-- Payment Methods -->
                <div class="payment-methods">
                    <div class="payment-method"><i class="fab fa-cc-visa"></i></div>
                    <div class="payment-method"><i class="fab fa-cc-mastercard"></i></div>
                    <div class="payment-method"><i class="fab fa-cc-paypal"></i></div>
                    <div class="payment-method"><i class="fas fa-qrcode"></i></div>
                </div>
            </div>
        </div>


    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle" id="toast-icon"></i>
        <span id="toast-message">Đã cập nhật giỏ hàng</span>
        <button class="close-toast" onclick="hideToast()">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loading">
        <div class="loader"></div>
    </div>
@endsection
