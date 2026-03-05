@extends('layouts.sincay')

@section('title', $product->name . ' - Chi tiáº¿t sáº£n pháº©m')

@section('content')
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 320px;">
        <div class="container">
            <h2 class="tit">Chi tiáº¿t sáº£n pháº©m</h2>
        </div>
    </section>

    <section class="section-mainmenu p-t-110 p-b-70  ">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif

            <div class="mb-4">
                <a href="{{ route('menu') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay láº¡i menu
                </a>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm">
                </div>

                <div class="col-md-6 mb-4">
                    <h2 class="mb-3">{{ $product->name }}</h2>
                    <p class="text-muted mb-2">Danh má»¥c: {{ $product->category?->name ?? 'ChÆ°a phÃ¢n loáº¡i' }}</p>
                    <h4 class="text-danger fw-bold mb-3">{{ number_format($product->base_price_cents) }}Ä‘</h4>
                    <p class="mb-3">{{ $product->description ?: 'ChÆ°a cÃ³ mÃ´ táº£.' }}</p>

                    <div class="mb-3">
                        @if (($product->stock ?? 0) > 0)
                            <span class="badge bg-success">CÃ²n hÃ ng ({{ $product->stock }})</span>
                        @else
                            <span class="badge bg-danger">Háº¿t hÃ ng</span>
                        @endif

                        @if ($product->is_spicy)
                            <span class="badge bg-warning text-dark">CÃ³ cay</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        @auth
                            @if ($isWishlisted ?? false)
                                <form action="{{ route('wishlist.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="fas fa-heart"></i> ÄÃ£ yÃªu thÃ­ch
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('wishlist.store', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="far fa-heart"></i> ThÃªm vÃ o yÃªu thÃ­ch
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-danger">
                                <i class="far fa-heart"></i> ÄÄƒng nháº­p Ä‘á»ƒ yÃªu thÃ­ch
                            </a>
                        @endauth
                    </div>

                    @if (($product->stock ?? 0) > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-3">
                            @csrf

                            @if ($product->is_spicy)
                                <div class="mb-3">
                                    <label for="spicy_level" class="form-label">Chá»n cáº¥p Ä‘á»™ cay</label>
                                    <select name="spicy_level" id="spicy_level" class="form-control">
                                        @for ($i = 0; $i <= 7; $i++)
                                            <option value="{{ $i }}" {{ $i === 3 ? 'selected' : '' }}>Cáº¥p {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-cart-plus"></i> ThÃªm vÃ o giá» hÃ ng
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
