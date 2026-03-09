@extends('layouts.sincay')

@section('title', 'Danh sách yêu thích')

@section('content')
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 320px;">
        <div class="container">
            <h2 class="tit">Danh sách yêu thích</h2>
        </div>
    </section>

    <section class="wishlist-page p-t-80 p-b-80">
        <div class="container">
            {{-- @if (session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif --}}

            <div class="wishlist-header">
                <div>
                    <h3 class="wishlist-title">Sản phẩm bạn đã lưu</h3>
                    <p class="wishlist-subtitle">Theo dõi món bạn thích và thêm nhanh vào giỏ hàng.</p>
                </div>
                <div class="wishlist-count">{{ $wishlists->total() }} sản phẩm</div>
            </div>

            @if ($wishlists->isEmpty())
                <div class="wishlist-empty">
                    <i class="fas fa-heart-broken"></i>
                    <h4>Chưa có sản phẩm yêu thích nào</h4>
                    <p>Hãy khám phá thực đơn và lưu lại món bạn muốn gọi sau.</p>
                    <a href="{{ route('menu') }}" class="btn btn-danger">Đi đến thực đơn</a>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($wishlists as $item)
                        @if (!$item->product)
                            @continue
                        @endif
                        <div class="col-md-6 col-lg-4">
                            <div class="wishlist-card">
                                <a href="{{ route('menu.show', $item->product) }}" class="wishlist-image">
                                    <img src="{{ asset($item->product->image_url) }}" alt="{{ $item->product->name }}">
                                </a>

                                <div class="wishlist-body">
                                    <h5 class="wishlist-name">
                                        <a href="{{ route('menu.show', $item->product) }}">{{ $item->product->name }}</a>
                                    </h5>
                                    <p class="wishlist-desc">
                                        {{ \Illuminate\Support\Str::limit($item->product->description, 90) }}</p>

                                    <div class="wishlist-meta">
                                        <span class="wishlist-price">{{ number_format($item->product->base_price_cents) }}
                                            đ</span>
                                        <span class="wishlist-stock {{ ($item->product->stock ?? 0) > 0 ? 'in' : 'out' }}">
                                            {{ ($item->product->stock ?? 0) > 0 ? 'Còn hàng' : 'Hết hàng' }}
                                        </span>
                                    </div>

                                    <div class="wishlist-actions">
                                        <form action="{{ route('wishlist.destroy', $item->product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i> Bỏ yêu thích
                                            </button>
                                        </form>

                                        @if (($item->product->stock ?? 0) > 0)
                                            <form action="{{ route('cart.add', $item->product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-cart-plus"></i> Thêm giỏ hàng
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4 wishlist-pagination">
                    {{ $wishlists->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>
@endsection

