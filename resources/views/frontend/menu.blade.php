    @extends('layouts.pato')

    @section('title', 'Menu - Pato Restaurant')

    @section('content')
        <!-- Title Page -->
        <section class="titles text-center text-white"
            style="background:   url({{ asset('assets/images/bg-title-page-01.jpg') }}) center/cover no-repeat; min-height: 400px;">
            <div class="container">
                <h2 class="tit">Sincay Menu</h2>
            </div>
        </section>


        <section class="food_section layout_padding ">
            <div class="container ">


                <ul class="filters_menu">
                    <li class="{{ !request('category') ? 'active' : '' }}">
                        <a href="{{ route('menu') }}">Tất cả</a>
                    </li>
                    @foreach ($categories as $category)
                        <li class="{{ request('category') == $category->slug ? 'active' : '' }}">
                            <a href="{{ route('menu', ['category' => $category->slug]) }}">
                                @if ($category->icon)
                                    <i class="{{ $category->icon }}"></i>
                                @endif
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="filters-content">
                    <div class="row grid">
                        @foreach ($products as $product)
                            <div class="col-sm-6 col-lg-4 py-3 all {{ $product->category->slug ?? '' }}">
                                <div class="box">
                                    <div class="img-box">
                                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
                                    </div>
                                    <div class="detail-box">
                                        <h5>{{ $product->name }}</h5>
                                        <p>{{ $product->description }}</p>
                                        <div class="options">
                                            <h6>
                                                {{ number_format($product->base_price_cents) }} đ
                                            </h6>
                                            {{-- Nút thêm sp --}}
                                            @if ($product->is_spicy)
                                                <!-- Nút mở modal chọn cấp độ cay -->
                                                <button type="button" class="btn-add-cart" data-toggle="modal"
                                                    data-target="#spicyModal{{ $product->id }}">
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            @else
                                                <!-- Món thường – thêm thẳng -->
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
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
                                <!-- Modal chọn cấp độ cay -->
                                <div class="modal fade" id="spicyModal{{ $product->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content overflow-hidden border-0 shadow-lg">
                                            <!-- Header đỏ nổi bật -->
                                            <div class="modal-header bg-gradient-danger text-orange-500 py-4">
                                                <h4 class="modal-title fw-bold m-0">
                                                    <i class="fas fa-pepper-hot me-2"></i> Chọn cấp độ cay
                                                </h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body py-5 bg-light">
                                                <div class="row g-4">
                                                    <!-- Cột trái: Ảnh + thông tin món -->
                                                    <div class="col-md-5 text-center">
                                                        <img src="{{ asset($product->image_url) }}"
                                                            class="img-fluid rounded-4 shadow-sm"
                                                            style="max-height: 280px; object-fit: cover;">
                                                        <h3 class="mt-4 mb-2 fw-bold">{{ $product->name }}</h3>
                                                        <p class="text-muted mb-3">{{ $product->description }}</p>
                                                        <h4 class="text-danger fw-bold">
                                                            {{ number_format($product->base_price_cents) }}đ
                                                        </h4>
                                                    </div>

                                                    <!-- Cột phải: Chọn cấp độ cay -->
                                                    <div class="col-md-7">
                                                        <h5 class="fw-bold text-center mb-4 text-danger">Một cấp/5 trái ớt
                                                        </h5>

                                                        <form action="{{ route('cart.add', $product->id) }}"
                                                            method="POST">
                                                            @csrf

                                                            <div
                                                                class="spicy-levels d-flex flex-column justify-content-start   ">
                                                                @for ($i = 0; $i <= 7; $i++)
                                                                    <div class="text-start   ">
                                                                        <input class="btn-check " type="radio"
                                                                            name="spicy_level"
                                                                            id="level{{ $product->id }}_{{ $i }}"
                                                                            value="{{ $i }}"
                                                                            {{ $i == 3 ? 'checked' : '' }}>

                                                                        <label class="btn spicy-btn "
                                                                            for="level{{ $product->id }}_{{ $i }}">
                                                                            <div class="fw-bold fs-20">Cấp
                                                                                {{ $i }}
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                    <hr>
                                                                @endfor
                                                            </div>

                                                            <div class="text-center">
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-lg px-5 py-3 rounded-pill shadow">
                                                                    <i class="fas fa-cart-plus me-2"></i>
                                                                    Thêm vào giỏ hàng
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
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $products->appends(['category' => request('category')])->links() }}
            </div>
        </section>


    @endsection
