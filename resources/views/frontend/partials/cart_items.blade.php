<div class="cart-items">
    @if (count($cart) > 0)
        <div class="cart-actions-header d-flex justify-content-between align-items-center mb-3 p-3 bg-white rounded shadow-sm border"
            style="border-color: var(--gray-200) !important;">
            <div class="form-check d-flex align-items-center gap-2 m-0">
                <input class="form-check-input" type="checkbox" id="selectAll"
                    style="width: 1.2rem; height: 1.2rem; cursor: pointer;">
                <label class="form-check-label fw-bold mb-0" for="selectAll" style="cursor: pointer; padding-top: 3px;">
                    Chọn tất cả ({{ count($cart) }} sản phẩm)
                </label>
            </div>
        </div>

        <div class="cart-items-scrollable">
            @foreach ($cart as $id => $item)
                <div class="cart-item" data-cart-item="{{ $id }}">
                    <div class="product-grid">
                        <div class="item-checkbox d-flex align-items-center">
                            <input class="form-check-input item-check" type="checkbox"
                                value="{{ $id }}"
                                data-price="{{ (int) ($item['base_price_cents'] ?? 0) }}"
                                data-qty="{{ (int) ($item['quantity'] ?? 0) }}"
                                style="width: 1.2rem; height: 1.2rem; cursor: pointer;">
                        </div>

                        <div class="product-image">
                            <img src="{{ asset($item['image_url'] ?? 'default.jpg') }}" alt="{{ $item['name'] }}">
                        </div>

                        <div class="product-details">
                            <a href="#" class="product-title">{{ $item['name'] }}</a>
                            <div class="product-variants"></div>

                            <div class="quantity-controls">
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="js-cart-form">
                                    @csrf
                                    <input type="hidden" name="action" value="decrease">
                                    <button type="submit" class="qty-btn minus-btn"><i class="fas fa-minus"></i></button>
                                </form>

                                <input type="number" class="quantity-input" value="{{ $item['quantity'] }}" readonly>

                                <form action="{{ route('cart.update', $id) }}" method="POST" class="js-cart-form">
                                    @csrf
                                    <input type="hidden" name="action" value="increase">
                                    <button type="submit" class="qty-btn plus btn"><i class="fas fa-plus"></i></button>
                                </form>
                            </div>

                            <div class="product-actions">
                                @auth
                                    @if (in_array((int) $id, $wishlistProductIds ?? [], true))
                                        <form action="{{ route('wishlist.destroy', $id) }}" method="POST"
                                            class="d-inline js-wishlist-form" data-product-id="{{ $id }}" data-action="remove">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn save">
                                                <i class="fas fa-heart"></i> Yêu thích
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('wishlist.store', $id) }}" method="POST"
                                            class="d-inline js-wishlist-form" data-product-id="{{ $id }}" data-action="add">
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

                        <div class="price-section">
                            <div class="price-container">
                                <span class="current-price">
                                    {{ number_format($item['base_price_cents'] ?? 0) }}đ
                                </span>
                            </div>
                            <a href="{{ route('cart.remove', $id) }}" class="remove-btn js-cart-remove" data-id="{{ $id }}">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <form id="remove-selected-form" action="{{ route('cart.removeSelected') }}" method="POST"
            class="cart-bulk-actions mt-3 js-cart-form">
            @csrf
            @method('DELETE')
            <input type="hidden" name="items" id="remove-selected-items">
            <button type="submit" class="btn btn-sm btn-outline-danger" id="btn-remove-selected" disabled>
                <i class="fas fa-trash-alt me-1"></i> Xóa
            </button>
        </form>
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
