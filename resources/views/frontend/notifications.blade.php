@extends('layouts.sincay')

@section('title', 'Thông báo của tôi')

@section('content')
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 320px;">
        <div class="container">
            <h2 class="tit">Thông báo của tôi</h2>
        </div>
    </section>

    <section class="section-mainmenu p-t-110 p-b-70">
        <div class="container">
            @if ($notifications->isEmpty())
                <div class="text-center py-5 bg-white rounded shadow-sm border">
                    <i class="fas fa-bell-slash fa-4x text-muted mb-3 opacity-50"></i>
                    <h4>Chưa có thông báo</h4>
                    <p class="text-muted">Khi đơn hàng hoặc trạng thái đặt bàn thay đổi, thông báo sẽ hiển thị tại đây.</p>
                </div>
            @else
                <div class="list-group shadow-sm">
                    @foreach ($notifications as $item)
                        <div
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                            <div class="me-3">
                                <div class="fw-bold">
                                    Đơn hàng #{{ $item->order?->order_number ?? $item->order_id }}
                                </div>
                                <div class="text-muted">
                                    Trạng thái: {{ $item->order?->status_text ?? $item->status }}
                                </div>
                                @if ($item->note)
                                    <div class="small text-muted">Ghi chú: {{ $item->note }}</div>
                                @endif
                            </div>
                            <span class="text-muted small">
                                {{ $item->timestamp?->diffForHumans() ?? '-' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
