@extends('layouts.sincay')

@section('content')
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 320px;">
        <div class="container">
            <h2 class="tit">Giỏ hàng</h2>
        </div>
    </section>

    <div class="container" id="cart-page">
        <div class="cart-layout">
            <div id="cart-items-wrapper">
                @include('frontend.partials.cart_items', [
                    'cart' => $cart,
                    'wishlistProductIds' => $wishlistProductIds,
                ])
            </div>

            <div id="cart-summary-wrapper">
                @include('frontend.partials.cart_summary', [
                    'summary' => $summary,
                    'coupon' => $coupon,
                ])
            </div>
        </div>
    </div>
@endsection
