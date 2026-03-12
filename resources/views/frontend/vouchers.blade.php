@extends('layouts.sincay')

@section('title', 'Ưu đãi & Voucher')

@section('content')
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 320px;">
        <div class="container">
            <h2 class="tit">Ưu đãi & Voucher</h2>
        </div>
    </section>

    <section class="section-mainmenu p-t-110 p-b-70">
        <div class="container">
            @if ($coupons->isEmpty())
                <div class="text-center py-5 bg-white rounded shadow-sm border">
                    <i class="fas fa-ticket-alt fa-4x text-muted mb-3 opacity-50"></i>
                    <h4>Chưa có voucher khả dụng</h4>
                    <p class="text-muted">Hãy quay lại sau để nhận thêm ưu đãi mới nhất.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($coupons as $coupon)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="badge bg-danger">Voucher</span>
                                        <span class="text-muted small">
                                            {{ $coupon->expires_at ? 'Hết hạn: ' . $coupon->expires_at->format('d/m/Y') : 'Không giới hạn' }}
                                        </span>
                                    </div>
                                    <h5 class="fw-bold">{{ strtoupper($coupon->code) }}</h5>
                                    <p class="text-muted mb-2">
                                        @if ($coupon->discount_type === 'percent')
                                            Giảm {{ $coupon->discount_value }}%
                                        @else
                                            Giảm {{ number_format($coupon->discount_value) }}d
                                        @endif
                                    </p>
                                    @if ($coupon->min_order_total_amount_cents)
                                        <p class="text-muted small mb-0">Đơn tối thiểu:
                                            {{ number_format($coupon->min_order_total_amount_cents) }}d</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $coupons->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
