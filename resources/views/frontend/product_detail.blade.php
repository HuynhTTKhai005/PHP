@extends('layouts.sincay')

@section('title', $product->name . ' - Chi tiết sản phẩm')

@section('content')
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 320px;">
        <div class="container">
            <h2 class="tit">Chi tiết sản phẩm</h2>
        </div>
    </section>

    <section class="section-mainmenu p-t-110 p-b-70  ">
        <div class="container">
            {{-- @if (session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif --}}

            <div class="mb-4">
                <a href="{{ route('menu') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại menu
                </a>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}"
                        class="img-fluid rounded shadow-sm">
                </div>

                <div class="col-md-6 mb-4">
                    <h2 class="mb-3">{{ $product->name }}</h2>
                    <p class="text-muted mb-2">Danh mục: {{ $product->category?->name ?? 'Chưa phân loại' }}</p>
                    <h4 class="text-danger fw-bold mb-3">{{ number_format($product->base_price_cents) }}d</h4>
                    <p class="mb-3">{{ $product->description ?: 'Chưa có mô tả.' }}</p>

                    <div class="mb-3">
                        @if (($product->stock ?? 0) > 0)
                            <span class="badge bg-success">Còn hàng ({{ $product->stock }})</span>
                        @else
                            <span class="badge bg-danger">Hết hàng</span>
                        @endif

                        @if ($product->is_spicy)
                            <span class="badge bg-warning text-dark">Có cay</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        @auth
                            @if ($isWishlisted ?? false)
                                <form action="{{ route('wishlist.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="fas fa-heart"></i> Đã yêu thích
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('wishlist.store', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="far fa-heart"></i> Thêm vào yêu thích
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-danger">
                                <i class="far fa-heart"></i> Đăng nhập để yêu thích
                            </a>
                        @endauth
                    </div>

                    @if (($product->stock ?? 0) > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-3">
                            @csrf

                            @if ($product->is_spicy)
                                <div class="mb-3">
                                    <label for="spicy_level" class="form-label">Chọn cấp độ cay</label>
                                    <select name="spicy_level" id="spicy_level" class="form-control">
                                        @for ($i = 0; $i <= 7; $i++)
                                            <option value="{{ $i }}" {{ $i === 3 ? 'selected' : '' }}>Cấp
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
