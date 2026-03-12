<div class="filters-content">
    @if ($products->isEmpty())
        <div class="row">
            <div class="col-12 text-center"
                style="min-height: 60vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <div class="mb-4">
                    <i class="fas fa-search fa-4x text-muted" style="opacity: 0.3;"></i>
                </div>

                <h3 class="text-muted mb-4" style="font-weight: 300;">
                    Không tìm thấy món nào phù hợp với từ khóa <br>
                    <span class="text-danger fw-bold" style="font-size: 1.5rem;">"{{ request('search') }}"</span>
                </h3>

                <p class="text-muted mb-5">
                    Thử tìm kiếm với từ khóa khác hoặc quay lại xem toàn bộ thực đơn hấp dẫn của chúng tôi.
                </p>

                <a href="{{ route('menu') }}" class="btn btn-danger rounded-pill px-5 py-3 shadow-lg"
                    style="background-color: #d63031; border: none; min-width: 250px;">
                    <i class="fas fa-undo-alt me-2"></i> Quay lại thực đơn
                </a>
            </div>
        </div>
    @else
        <div class="row grid">
            @foreach ($products as $product)
                <div class="col-sm-6 col-lg-4 py-3 all {{ $product->category->slug ?? '' }}">
                    <div class="box">
                        <a href="{{ route('menu.show', $product) }}" class="img-box position-relative d-block">
                            <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
                            @if (($product->stock ?? 0) <= 0)
                                <span class="badge bg-danger position-absolute m-2">Hết hàng</span>
                            @endif
                        </a>
                        <div class="detail-box">
                            <h5>
                                <a href="{{ route('menu.show', $product) }}"
                                    class="text-decoration-none text-reset">{{ $product->name }}</a>
                            </h5>
                            <p>{{ $product->description }}</p>
                            <div class="options">
                                <h6>{{ number_format($product->base_price_cents) }} d</h6>
                                @if (($product->stock ?? 0) <= 0)
                                    <button type="button" class="btn-add-cart" disabled title="Sản phẩm đã hết hàng">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                @elseif ($product->is_spicy)
                                    <button type="button" class="btn-add-cart" data-bs-toggle="modal"
                                        data-bs-target="#spicyModal{{ $product->id }}">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                @else
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                        class="js-add-to-cart">
                                        @csrf
                                        <button type="submit" class="btn-add-cart">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if ($product->is_spicy)
                    <div class="modal fade" id="spicyModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content overflow-hidden border-0 shadow-lg">
                                <div class="modal-header bg-gradient-danger text-orange-500 py-4">
                                    <h4 class="modal-title fw-bold m-0">
                                        <i class="fas fa-pepper-hot me-2"></i> Chọn cấp độ cay
                                    </h4>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body py-5 bg-light">
                                    <div class="row g-4">
                                        <div class="col-md-5 text-center">
                                            <img src="{{ asset($product->image_url) }}"
                                                class="img-fluid rounded-4 shadow-sm"
                                                style="max-height: 280px; object-fit: cover;">
                                            <h3 class="mt-4 mb-2 fw-bold">{{ $product->name }}</h3>
                                            <p class="text-muted mb-3">{{ $product->description }}</p>
                                            <h4 class="text-danger fw-bold">
                                                {{ number_format($product->base_price_cents) }}d</h4>
                                        </div>
                                        <div class="col-md-7">
                                            <h5 class="fw-bold text-center mb-4 text-danger">Một cấp / 5 trái ớt</h5>
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                                class="js-add-to-cart">
                                                @csrf
                                                <div class="spicy-levels d-flex flex-column justify-content-start">
                                                    @for ($i = 0; $i <= 7; $i++)
                                                        <div class="text-start">
                                                            <input class="btn-check" type="radio" name="spicy_level"
                                                                id="level{{ $product->id }}_{{ $i }}"
                                                                value="{{ $i }}"
                                                                {{ $i == 3 ? 'checked' : '' }}>
                                                            <label class="btn spicy-btn"
                                                                for="level{{ $product->id }}_{{ $i }}">
                                                                <div class="fw-bold fs-20">Cấp {{ $i }}
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <hr>
                                                    @endfor
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit"
                                                        class="btn btn-danger btn-lg px-5 py-3 rounded-pill shadow">
                                                        <i class="fas fa-cart-plus me-2"></i> Thêm vào giỏ hàng
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>

<div class="d-flex justify-content-center mt-4 menu-pagination">
    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>
