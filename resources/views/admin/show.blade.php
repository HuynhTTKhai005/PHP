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
                    {{ number_format($order->total_amount_cents, 0, ',', '.') }}d
                </p>
            </div>
            <div class="detail-group">
                <label>Trạng thái</label>
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST"
                    class="js-admin-order-status-form">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="filter-select" style="margin-bottom:8px;">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Đang chờ xử lý</option>
                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Đã xác nhận
                        </option>
                        <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Đang chuẩn bị
                        </option>
                        <option value="delivering" {{ $order->status === 'delivering' ? 'selected' : '' }}>Đang giao
                        </option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Hoàn thành
                        </option>
                        <option value="cancel_requested" {{ $order->status === 'cancel_requested' ? 'selected' : '' }}>Chờ
                            duyệt hủy</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                    <textarea name="note" class="filter-input" placeholder="Ghi chú khi đổi trạng thái (không bắt buộc)"></textarea>
                    <button type="submit" class="btn btn-primary" style="margin-top:8px;">
                        <i class="fas fa-save"></i> Cập nhật trạng thái
                    </button>
                </form>
            </div>

            @if ($order->total_discount_cents > 0)
                <div class="detail-group">
                    <label>Giảm giá</label>
                    <p style="color: #28a745;">-{{ number_format($order->total_discount_cents, 0, ',', '.') }}d</p>
                </div>
            @endif
            <div class="detail-group">
                <label>Phí giao hàng</label>
                <p>{{ number_format($order->shipping_fee_cents ?? 0, 0, ',', '.') }}d</p>
            </div>
            <div class="detail-group">
                <label>VAT (10%)</label>
                <p>{{ number_format($order->vat_cents, 0, ',', '.') }}d</p>
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
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item->product?->name ?? 'Sản phẩm đã xóa' }}</td>
                            <td>{{ number_format($item->unit_price_cents, 0, ',', '.') }}d</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->total_cents, 0, ',', '.') }}d</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h4 style="margin: 30px 0 15px;">Lịch sử thay đổi trạng thái</h4>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Thời gian</th>
                        <th>Trạng thái</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($order->statusHistories as $history)
                        <tr>
                            <td>{{ optional($history->timestamp)->format('d/m/Y H:i:s') ?: '-' }}</td>
                            <td>{{ $history->status }}</td>
                            <td>{{ $history->note ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Chưa có lịch sử trạng thái</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
