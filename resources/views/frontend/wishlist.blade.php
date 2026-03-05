@extends('layouts.sincay')

@section('title', 'Danh sÃ¡ch yÃªu thÃ­ch')

@section('content')
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 320px;">
        <div class="container">
            <h2 class="tit">Danh sÃ¡ch yÃªu thÃ­ch</h2>
        </div>
    </section>

    <section class="wishlist-page p-t-80 p-b-80">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif

            <div class="wishlist-header">
                <div>
                    <h3 class="wishlist-title">Sáº£n pháº©m báº¡n Ä‘Ã£ lÆ°u</h3>
                    <p class="wishlist-subtitle">Theo dÃµi mÃ³n báº¡n thÃ­ch vÃ  thÃªm nhanh vÃ o giá» hÃ ng.</p>
                </div>
                <div class="wishlist-count">{{ $wishlists->total() }} sáº£n pháº©m</div>
            </div>

            @if ($wishlists->isEmpty())
                <div class="wishlist-empty">
                    <i class="fas fa-heart-broken"></i>
                    <h4>ChÆ°a cÃ³ sáº£n pháº©m yÃªu thÃ­ch nÃ o</h4>
                    <p>HÃ£y khÃ¡m phÃ¡ thá»±c Ä‘Æ¡n vÃ  lÆ°u láº¡i mÃ³n báº¡n muá»‘n gá»i sau.</p>
                    <a href="{{ route('menu') }}" class="btn btn-danger">Äi Ä‘áº¿n thá»±c Ä‘Æ¡n</a>
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
                                            Ä‘</span>
                                        <span class="wishlist-stock {{ ($item->product->stock ?? 0) > 0 ? 'in' : 'out' }}">
                                            {{ ($item->product->stock ?? 0) > 0 ? 'CÃ²n hÃ ng' : 'Háº¿t hÃ ng' }}
                                        </span>
                                    </div>

                                    <div class="wishlist-actions">
                                        <form action="{{ route('wishlist.destroy', $item->product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i> Bá» yÃªu thÃ­ch
                                            </button>
                                        </form>

                                        @if (($item->product->stock ?? 0) > 0)
                                            <form action="{{ route('cart.add', $item->product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-cart-plus"></i> ThÃªm giá» hÃ ng
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

