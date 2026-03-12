@extends('layouts.sincay')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 320px;">
        <div class="container">
            <h2 class="tit">Chi tiết đơn hàng</h2>
        </div>
    </section>

    <section class="section-mainmenu p-t-110 p-b-70">
        <div class="container">
            <div class="mb-4 d-flex gap-2" id="order-actions" data-order-id="{{ $order->id }}">
                <a href="{{ route('my-orders') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Quay lại đơn hàng của tôi
                </a>
                @if (in_array($order->status, ['pending', 'confirmed'], true))
                    <form action="{{ route('my-orders.cancel', $order) }}" method="POST" class="js-cancel-order-form"
                        data-order-id="{{ $order->id }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-danger">Yêu cầu hủy</button>
                    </form>
                @endif
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4"><strong>Mã đơn:</strong>
                    {{ $order->order_number ?? '#' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="col-md-4"><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</div>
                <div class="col-md-4"><strong>Trạng thái:</strong> <span data-order-status>{{ $order->status_text }}</span>
                </div>
                <div class="col-md-4"><strong>Phương thức thanh toán:</strong>
                    {{ $order->payment_method_text ?? 'Tiền mặt' }}</div>
                <div class="col-md-4"><strong>Người nhận:</strong> {{ $order->shipping_name }}</div>
                <div class="col-md-4"><strong>SĐT:</strong> {{ $order->shipping_phone }}</div>
                <div class="col-12"><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</div>
                @if ($order->note)
                    <div class="col-12"><strong>Ghi chú:</strong> {{ $order->note }}</div>
                @endif
            </div>

            <div class="table-responsive bg-white rounded shadow-sm p-3">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->product?->name ?? 'Sản phẩm đã xóa' }}</td>
                                <td>{{ number_format($item->unit_price_cents, 0, ',', '.') }}đ</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->total_cents, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <p><strong>Tạm tính:</strong> {{ number_format($order->subtotal_cents, 0, ',', '.') }}đ</p>
                <p><strong>Giảm giá:</strong> -{{ number_format($order->total_discount_cents, 0, ',', '.') }}đ</p>
                <p><strong>VAT:</strong> {{ number_format($order->vat_cents, 0, ',', '.') }}đ</p>
                <p><strong>Phí giao hàng:</strong> {{ number_format($order->shipping_fee_cents, 0, ',', '.') }}đ</p>
                <h5><strong>Tổng cộng:</strong> {{ number_format($order->total_amount_cents, 0, ',', '.') }}đ</h5>
            </div>
        </div>
    </section>
@endsection