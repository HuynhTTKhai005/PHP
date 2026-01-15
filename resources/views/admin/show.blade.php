@extends('admin.app')

@section('content')
    <div class="content-area">
        <div class="section-header">
            <h2>Chi tiết đơn hàng #{{ $order->order_number ?? $order->id }}</h2>
            <a href="{{ route('admin.orders') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="order-details-grid">
            <div class="detail-group">
                <label>Khách hàng</label>
                <p>{{ $order->user?->full_name ?? $order->shipping_name }}</p>
            </div>
            <div class="detail-group">
                <label>Số điện thoại</label>
                <p>{{ $order->shipping_phone }}</p>
            </div>
            <div class="detail-group">
                <label>Địa chỉ giao</label>
                <p>{{ $order->shipping_address }}</p>
            </div>
            <div class="detail-group">
                <label>Ngày đặt</label>
                <p>{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="detail-group">
                <label>Tổng tiền</label>
                <p style="font-weight: bold; color: var(--primary);">
                    {{ number_format($order->total_amount_cents / 100, 0, ',', '.') }}đ
                </p>
            </div>
            <div class="detail-group">
                <label>Trạng thái</label>
                <form action="{{ route('orders.updateStatus', $order) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đang giao</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </form>
            </div>
        </div>

        <h4 style="margin: 30px 0 15px;">Sản phẩm trong đơn</h4>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product?->name ?? 'Sản phẩm đã xóa' }}</td>
                            <td>{{ number_format($item->price_cents / 100, 0, ',', '.') }}đ</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format(($item->price_cents * $item->quantity) / 100, 0, ',', '.') }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection