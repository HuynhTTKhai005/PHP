@extends('layouts.sincay')

@section('title', 'Chi tiáº¿t Ä‘Æ¡n hÃ ng')

@section('content')
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 320px;">
        <div class="container">
            <h2 class="tit">Chi tiáº¿t Ä‘Æ¡n hÃ ng</h2>
        </div>
    </section>

    <section class="section-mainmenu p-t-110 p-b-70  ">
        <div class="container">
            <div class="mb-4 d-flex gap-2">
                <a href="{{ route('my-orders') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Quay láº¡i Ä‘Æ¡n hÃ ng cá»§a tÃ´i
                </a>
                @if (in_array($order->status, ['pending', 'confirmed'], true))
                    <form action="{{ route('my-orders.cancel', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-danger">Há»§y Ä‘Æ¡n hÃ ng</button>
                    </form>
                @endif
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4"><strong>MÃ£ Ä‘Æ¡n:</strong> {{ $order->order_number ?? '#' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="col-md-4"><strong>NgÃ y Ä‘áº·t:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</div>
                <div class="col-md-4"><strong>Tráº¡ng thÃ¡i:</strong> {{ $order->status_text }}</div>
                <div class="col-md-4"><strong>Thanh toÃ¡n:</strong> {{ $order->payment_status_text }}</div>
                <div class="col-md-4"><strong>NgÆ°á»i nháº­n:</strong> {{ $order->shipping_name }}</div>
                <div class="col-md-4"><strong>SÄT:</strong> {{ $order->shipping_phone }}</div>
                <div class="col-12"><strong>Äá»‹a chá»‰:</strong> {{ $order->shipping_address }}</div>
                @if ($order->note)
                    <div class="col-12"><strong>Ghi chÃº:</strong> {{ $order->note }}</div>
                @endif
            </div>

            <div class="table-responsive bg-white rounded shadow-sm p-3">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Sáº£n pháº©m</th>
                            <th>ÄÆ¡n giÃ¡</th>
                            <th>Sá»‘ lÆ°á»£ng</th>
                            <th>ThÃ nh tiá»n</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->product?->name ?? 'Sáº£n pháº©m Ä‘Ã£ xÃ³a' }}</td>
                                <td>{{ number_format($item->unit_price_cents, 0, ',', '.') }}Ä‘</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->total_cents, 0, ',', '.') }}Ä‘</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <p><strong>Táº¡m tÃ­nh:</strong> {{ number_format($order->subtotal_cents, 0, ',', '.') }}Ä‘</p>
                <p><strong>Giáº£m giÃ¡:</strong> -{{ number_format($order->total_discount_cents, 0, ',', '.') }}Ä‘</p>
                <p><strong>VAT:</strong> {{ number_format($order->vat_cents, 0, ',', '.') }}Ä‘</p>
                <p><strong>PhÃ­ giao hÃ ng:</strong> {{ number_format($order->shipping_fee_cents, 0, ',', '.') }}Ä‘</p>
                <h5><strong>Tá»•ng cá»™ng:</strong> {{ number_format($order->total_amount_cents, 0, ',', '.') }}Ä‘</h5>
            </div>
        </div>
    </section>
@endsection


