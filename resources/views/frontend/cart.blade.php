@extends('layouts.sincay')

@section('content')
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 320px;">
        <div class="container">
            <h2 class="tit">Giỏ hàng</h2>
        </div>
    </section>

    <div class="container">
        <div class="cart-layout">
            {{-- Cột trái --}}
            <div class="cart-items">
                @if (count($cart) > 0)
                    <div class="cart-actions-header d-flex justify-content-between align-items-center mb-3 p-3 bg-white rounded shadow-sm border" style="border-color: var(--gray-200) !important;">
                        <div class="form-check d-flex align-items-center gap-2 m-0">
                            <input class="form-check-input" type="checkbox" id="selectAll" style="width: 1.2rem; height: 1.2rem; cursor: pointer;">
                            <label class="form-check-label fw-bold mb-0" for="selectAll" style="cursor: pointer; padding-top: 3px;">
                                Chọn tất cả ({{ count($cart) }} sản phẩm)
                            </label>
                        </div>
                        <a href="{{ route('cart.clear') }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa toàn bộ sản phẩm trong giỏ hàng?');">
                            <i class="fas fa-trash-alt me-1"></i> Xóa tất cả
                        </a>
                    </div>

                    <div class="cart-items-scrollable">
                        @foreach ($cart as $id => $item)
                            <div class="cart-item">
                                <div class="product-grid">
                                    <div class="item-checkbox d-flex align-items-center">
                                        <input class="form-check-input item-check" type="checkbox" value="{{ $id }}" style="width: 1.2rem; height: 1.2rem; cursor: pointer;">
                                    </div>

                                    <div class="product-image">
                                        <img src="{{ asset($item['image_url'] ?? 'default.jpg') }}" alt="{{ $item['name'] }}">
                                    </div>

                                    <div class="product-details">
                                        <a href="#" class="product-title">{{ $item['name'] }}</a>
                                        <div class="product-variants"></div>

                                        {{-- Chỉnh số lượng sản phẩm --}}
                                        <div class="quantity-controls">
                                            <form action="{{ route('cart.update', $id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="action" value="decrease">
                                                <button type="submit" class="qty-btn minus-btn"><i class="fas fa-minus"></i></button>
                                            </form>

                                            <input type="number" class="quantity-input" value="{{ $item['quantity'] }}" readonly>
                                            
                                            <form action="{{ route('cart.update', $id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="action" value="increase">
                                                <button type="submit" class="qty-btn plus btn"><i class="fas fa-plus"></i></button>
                                            </form>
                                        </div>

                                        <div class="product-actions">
                                            @auth
                                                @if (in_array((int) $id, $wishlistProductIds ?? [], true))
                                                    <form action="{{ route('wishlist.destroy', $id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="action-btn save">
                                                            <i class="fas fa-heart"></i> Yêu thích
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('wishlist.store', $id) }}" method="POST" class="d-inline">
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
                                        </div>
                                        <a href="{{ route('cart.remove', $id) }}" class="remove-btn">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center mt-5 bg-white p-5 rounded shadow-sm border">
                        <i class="fas fa-shopping-cart fa-4x text-muted mb-3 opacity-50"></i>
                        <h3>Giỏ hàng của bạn đang trống</h3> <br>
                        <a href="{{ route('menu') }}" class="btn btn-danger btn-lg px-5 rounded-pill">
                            Tiếp tục mua sắm
                        </a>
                    </div>
                @endif
            </div>

            <div class="cart-summary">
                <div class="summary-header">
                    <i class="fas fa-receipt"></i>
                    <h3>Tổng thanh toán</h3>
                </div>

                <div class="summary-rows">
                    <div class="summary-row">
                        <span class="label">Tạm tính</span>
                        <span class="value">{{ number_format($summary['subtotal']) }}đ</span>
                    </div>

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

                    <div class="summary-row">
                        <span class="label">Thuế VAT (10%)</span>
                        <span class="value">{{ number_format($summary['vat']) }}đ</span>
                    </div>

                    <div class="summary-row total">
                        <span class="label">Tổng cộng</span>
                        <span class="value">{{ number_format($summary['total']) }}đ</span>
                    </div>
                </div>

                <div class="shipping-progress-container">
                    <div class="progress-text">
                        <span>
                            @if ($summary['is_free_ship'])
                                <strong class="text-success">Bạn đã đủ điều kiện miễn phí ship!</strong>
                            @else
                                Thêm {{ number_format($summary['remaining_for_free_ship']) }}đ để được miễn phí ship
                            @endif
                        </span>
                        <span>{{ round($summary['progress_percent']) }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $summary['progress_percent'] }}%"></div>
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
                                        : number_format($coupon->discount_value) . 'đ' }}
                                </small>
                            </div>
                            <form action="{{ route('cart.removeCoupon') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger py-1 px-2">Xóa</button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('cart.applyCoupon') }}" method="POST" class="promo-input-group mt-3">
                            @csrf
                            <input type="text" name="coupon_code" class="promo-input" placeholder="Nhập mã..." value="{{ old('coupon_code') }}" required>
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
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectAll = document.getElementById('selectAll');
        const itemChecks = document.querySelectorAll('.item-check');

        if (selectAll) {
            // Khi bấm Chọn tất cả
            selectAll.addEventListener('change', function() {
                itemChecks.forEach(check => {
                    check.checked = this.checked;
                });
            });

            // Khi bấm từng item
            itemChecks.forEach(check => {
                check.addEventListener('change', function() {
                    const allChecked = Array.from(itemChecks).every(c => c.checked);
                    selectAll.checked = allChecked;
                });
            });
        }
    });

    // Thêm vào cuối script hiện tại
document.getElementById('btn-checkout').addEventListener('click', function(e) {
    e.preventDefault();
    let selectedItems = [];
    
    // Gom tất cả các ID của món ăn đang được tích chọn
    document.querySelectorAll('.item-check:checked').forEach(function(checkbox) {
        selectedItems.push(checkbox.value);
    });

    // Nếu khách không chọn món nào mà đòi thanh toán
    if (selectedItems.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Chưa chọn món',
            text: 'Vui lòng tích chọn ít nhất một món ăn để thanh toán nhé!'
        });
        return;
    }

    // Nối các ID vào đuôi URL và chuyển trang
    window.location.href = this.href + '?items=' + selectedItems.join(',');
});
</script>
@endpush