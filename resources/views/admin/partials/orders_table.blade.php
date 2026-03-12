<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Phương thức thanh toán</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td><strong>{{ $order->order_number ?? '#' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
                    </td>
                    <td>{{ $order->user?->full_name ?? ($order->shipping_name ?? 'Khách lẻ') }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($order->total_amount_cents, 0, ',', '.') }}đ</td>
                    <td>
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst(trans($order->status_text)) }}
                        </span>
                    </td>
                    <td>{{ $order->payment_method_text ?? 'Tiền mặt (COD)' }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="action-btn" title="Xem">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Không có đơn hàng nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination">
    {{ $orders->appends(request()->query())->links() }}
</div>