@extends('layouts.sincay')

@section('content')
    <!-- Main Container -->
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 320px;  ">
        <div class="container">
            <h2 class="tit">Giá» hÃ ng</h2>
        </div>
    </section>
    <div class="container">
        <!-- Cart Header -->


        <!-- Main Layout -->
        <div class="cart-layout">
            {{-- Cá»™t trÃ¡i --}}
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

                                    {{-- Chá»‰nh sá»‘ lÆ°á»£ng sáº£n pháº©m --}}
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
                                                        <i class="fas fa-heart"></i> YÃªu thÃ­ch
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('wishlist.store', $id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="action-btn save">
                                                        <i class="far fa-heart"></i> YÃªu thÃ­ch
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="action-btn save">
                                                <i class="far fa-heart"></i> YÃªu thÃ­ch
                                            </a>
                                        @endauth
                                        <div class="p-2">Cáº¥p Ä‘á»™ cay: {{ $item['spicy_level'] ?? 'KhÃ´ng' }}</div>
                                    </div>
                                </div>

                                {{-- GiÃ¡ --}}
                                <div class="price-section">
                                    <div class="price-container">
                                        <span class="current-price">
                                            {{ number_format($item['base_price_cents'] ?? 0) }}Ä‘
                                        </span>

                                        {{-- Dáº¥u X xÃ³a --}}
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
                        <h3>Giá» hÃ ng cá»§a báº¡n Ä‘ang trá»‘ng</h3> <br>
                        <a href="{{ route('menu') }}" class="btn3 size13 txt11">
                            Tiáº¿p tá»¥c mua sáº¯m
                        </a>
                    </div>
                @endif
            </div>

            <!-- Right Column: Cart Summary -->
            <div class="cart-summary">
                <div class="summary-header">
                    <i class="fas fa-receipt"></i>
                    <h3>Tá»•ng thanh toÃ¡n</h3>
                </div>

                <div class="summary-rows">
                    <!-- Táº¡m tÃ­nh -->
                    <div class="summary-row">
                        <span class="label">Táº¡m tÃ­nh</span>
                        <span class="value">{{ number_format($summary['subtotal']) }}Ä‘</span>
                    </div>

                    <!-- PhÃ­ váº­n chuyá»ƒn -->
                    <div class="summary-row">
                        <span class="label">PhÃ­ váº­n chuyá»ƒn</span>
                        <span class="value free-shipping">
                            @if ($summary['is_free_ship'])
                                <i class="fas fa-check-circle"></i> Miá»…n phÃ­
                            @else
                                {{ number_format($summary['shipping_fee']) }}Ä‘
                            @endif
                        </span>
                    </div>

                    <!-- Giáº£m giÃ¡ (náº¿u cÃ³) -->
                    @if ($summary['discount'] > 0)
                        <div class="summary-row text-success">
                            <span class="label">Giáº£m giÃ¡
                                @if ($coupon)
                                    ({{ strtoupper($coupon->code) }})
                                @endif
                            </span>
                            <span class="value">- {{ number_format($summary['discount']) }}Ä‘</span>
                        </div>
                    @endif

                    <!-- Thuáº¿ VAT -->
                    <div class="summary-row">
                        <span class="label">Thuáº¿ VAT (10%)</span>
                        <span class="value">{{ number_format($summary['vat']) }}Ä‘</span>
                    </div>

                    <!-- Tá»•ng cá»™ng -->
                    <div class="summary-row total">
                        <span class="label">Tá»•ng cá»™ng</span>
                        <span class="value">{{ number_format($summary['total']) }}Ä‘</span>
                    </div>
                </div>

                <!-- Shipping Progress -->
                <div class="shipping-progress-container">
                    <div class="progress-text">
                        <span>
                            @if ($summary['is_free_ship'])
                                <strong>Báº¡n Ä‘Ã£ Ä‘á»§ Ä‘iá»u kiá»‡n miá»…n phÃ­ ship!</strong>
                            @else
                                ThÃªm {{ number_format($summary['remaining_for_free_ship']) }}Ä‘ Ä‘á»ƒ Ä‘Æ°á»£c miá»…n
                                phÃ­ ship
                            @endif
                        </span>
                        <span>{{ round($summary['progress_percent']) }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $summary['progress_percent'] }}%"></div>
                    </div>
                </div>

                <!-- Promo Code (giá»¯ nguyÃªn pháº§n báº¡n Ä‘Ã£ lÃ m ráº¥t tá»‘t) -->
                <div class="promo-section">
                    <div class="promo-header">
                        <i class="fas fa-tag"></i>
                        <h4>MÃ£ giáº£m giÃ¡</h4>
                    </div>

                    @if ($coupon)
                        <div class="alert alert-success mt-3 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ strtoupper($coupon->code) }}</strong>
                                <small class="d-block">
                                    Giáº£m
                                    {{ $coupon->discount_type == 'percent'
                                        ? $coupon->discount_value . '%'
                                        : number_format($coupon->discount_value) . 'Ä‘' }}
                                </small>
                            </div>
                            <form action="{{ route('cart.removeCoupon') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">XÃ³a</button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('cart.applyCoupon') }}" method="POST" class="promo-input-group mt-3">
                            @csrf
                            <input type="text" name="coupon_code" class="promo-input"
                                placeholder="Nháº­p mÃ£ giáº£m giÃ¡..." value="{{ old('coupon_code') }}" required>
                            <button type="submit" class="apply-btn">Ãp dá»¥ng</button>
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
                    Thanh toÃ¡n an toÃ n
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
        <span id="toast-message">ÄÃ£ cáº­p nháº­t giá» hÃ ng</span>
        <button class="close-toast" onclick="hideToast()">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loading">
        <div class="loader"></div>
    </div>
@endsection

