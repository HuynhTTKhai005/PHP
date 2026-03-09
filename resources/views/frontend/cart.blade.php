@extends('layouts.sincay')

@section('content')
    <!-- Main Container -->
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 320px;  ">
        <div class="container">
            <h2 class="tit">Giỏ hàng</h2>
        </div>
    </section>
    <div class="container">
        <!-- Cart Header -->


        <!-- Main Layout -->
        <div class="cart-layout">
            {{-- Cột trái --}}
            <div class="cart-items">
                @if (count($cart) > 0)
                    @foreach ($cart as $id => $item)
                        <div class="cart-item">
                            <div class="product-grid">
                                <div class="product-image">
                                    <img src="{{ asset($item['image_url'] ?? 'default.jpg') }}" alt="{{ $item['name'] }}">
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
                                        @auth
                                            @if (in_array((int) $id, $wishlistProductIds ?? [], true))
                                                <form action="{{ route('wishlist.destroy', $id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn save">
                                                        <i class="fas fa-heart"></i> Yêu thích
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('wishlist.store', $id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="action-btn save">
                                                        <i class="far fa-heart"></i> Yêu thích
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="action-btn save">
                                                <i class="far fa-heart"></i> Yêu thích
                                            </a>
                                        @endauth
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
                    <div class="text-center mt-5">
                        <h3>Giỏ hàng của bạn đang trống</h3> <br>
                        <a href="{{ route('menu') }}" class="btn3 size13 txt11">
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

                <div class="summary-rows">
                    <!-- Tạm tính -->
                    <div class="summary-row">
                        <span class="label">Tạm tính</span>
                        <span class="value">{{ number_format($summary['subtotal']) }}đ</span>
                    </div>

                    <!-- Phí vận chuyển -->
                    <div class="summary-row">
                        <span class="label">Phí vận chuyển</span>
                        <span class="value free-shipping">
                            @if ($summary['is_free_ship'])
                                <i class="fas fa-check-circle"></i> Miễn phí
                            @else
                                {{ number_format($summary['shipping_fee']) }}đ
                            @endif
                        </span>
                    </div>

                    <!-- Giảm giá (nếu có) -->
                    @if ($summary['discount'] > 0)
                        <div class="summary-row text-success">
                            <span class="label">Giảm giá
                                @if ($coupon)
                                    ({{ strtoupper($coupon->code) }})
                                @endif
                            </span>
                            <span class="value">- {{ number_format($summary['discount']) }}đ</span>
                        </div>
                    @endif

                    <!-- Thuế VAT -->
                    <div class="summary-row">
                        <span class="label">Thuế VAT (10%)</span>
                        <span class="value">{{ number_format($summary['vat']) }}đ</span>
                    </div>

                    <!-- Tổng cộng -->
                    <div class="summary-row total">
                        <span class="label">Tổng cộng</span>
                        <span class="value">{{ number_format($summary['total']) }}đ</span>
                    </div>
                </div>

                <!-- Shipping Progress -->
                <div class="shipping-progress-container">
                    <div class="progress-text">
                        <span>
                            @if ($summary['is_free_ship'])
                                <strong>Bạn đã đủ điều kiện miễn phí ship!</strong>
                            @else
                                Thêm {{ number_format($summary['remaining_for_free_ship']) }}đ để được miễn
                                phí ship
                            @endif
                        </span>
                        <span>{{ round($summary['progress_percent']) }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $summary['progress_percent'] }}%"></div>
                    </div>
                </div>

                <!-- Promo Code (giữ nguyên phần bạn đã làm rất tốt) -->
                <div class="promo-section">
                    <div class="promo-header">
                        <i class="fas fa-tag"></i>
                        <h4>Mã giảm giá</h4>
                    </div>

                    @if ($coupon)
                        <div class="alert alert-success mt-3 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ strtoupper($coupon->code) }}</strong>
                                <small class="d-block">
                                    Giảm
                                    {{ $coupon->discount_type == 'percent'
                                        ? $coupon->discount_value . '%'
                                        : number_format($coupon->discount_value) . 'đ' }}
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
                            <input type="text" name="coupon_code" class="promo-input"
                                placeholder="Nhập mã giảm giá..." value="{{ old('coupon_code') }}" required>
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

