@extends('layouts.sincay')

@section('title', 'Menu - Sincay Restaurant')

@section('content')
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 400px;">
        <div class="container">
            <h2 class="tit">Sincay Menu</h2>
        </div>
    </section>

    <section class="food_section layout_padding" data-menu-page="1">
        <div class="container">
            {{-- @if (session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif --}}

            <div class="row justify-content-center mb-5">
                <div class="col-md-6">
                    <form action="{{ route('menu') }}" method="GET" class="d-flex" id="menu-search-form">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control rounded-pill px-4"
                                placeholder="Bạn muốn ăn gì hôm nay? (Ví dụ: Mì cay)" value="{{ request('search') }}"
                                style="border: 1px solid #ced4da; height: 50px;">
                            <button class="btn btn-warning rounded-pill ms-2 text-white px-4" type="submit"
                                style="background-color: #d63031; border: none;">
                                <i class="fas fa-search"></i> Tìm
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <ul class="filters_menu" id="menu-filters">
                <li class="{{ !request('category') ? 'active' : '' }}" data-category="">
                    <a href="{{ route('menu') }}" class="js-menu-filter">Tất cả</a>
                </li>
                @foreach ($categories as $category)
                    <li class="{{ request('category') == $category->slug ? 'active' : '' }}"
                        data-category="{{ $category->slug }}">
                        <a href="{{ route('menu', ['category' => $category->slug]) }}" class="js-menu-filter">
                            @if ($category->icon)
                                <i class="{{ $category->icon }}"></i>
                            @endif
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div id="menu-content">
                @include('frontend.partials.menu_content', ['products' => $products])
            </div>
        </div>
    </section>
@endsection
