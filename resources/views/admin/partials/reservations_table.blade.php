<div class="orders-container">
    <div class="section-header">
        <h2>Danh sách đặt bàn</h2>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Khách hàng</th>
                    <th>Ngày đặt</th>
                    <th>Giờ</th>
                    <th>Số người</th>
                    <th>Trạng thái</th>
                    <th>Ghi chú</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservations as $reservation)
                    <tr>
                        <td>#{{ str_pad((string) $reservation->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <strong>{{ $reservation->full_name }}</strong><br>
                            <small>{{ $reservation->phone }}</small><br>
                            <small>{{ $reservation->email ?: '-' }}</small>
                        </td>
                        <td>{{ \Illuminate\Support\Carbon::parse($reservation->reservation_date)->format('d/m/Y') }}</td>
                        <td>{{ substr((string) $reservation->reservation_time, 0, 5) }}</td>
                        <td>{{ $reservation->people_count }}</td>
                        <td>
                            <span class="status-badge {{ $reservation->status_class }}">
                                {{ $reservation->status_text }}
                            </span>
                        </td>
                        <td>{{ $reservation->note ?: '-' }}</td>
                        <td>
                            <div class="action-buttons">
                                @if ($reservation->can_confirm)
                                    <form action="{{ route('admin.reservations.updateStatus', $reservation) }}" method="POST"
                                        class="reservation-action-form js-admin-reservation-form">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button class="action-btn edit" type="submit" title="Xác nhận">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif

                                @if ($reservation->can_cancel)
                                    <form action="{{ route('admin.reservations.updateStatus', $reservation) }}" method="POST"
                                        class="reservation-action-form js-admin-reservation-form">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button class="action-btn delete" type="submit" title="Hủy bàn">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Chưa có dữ liệu đặt bàn</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <div class="pagination-info">
            Hiển thị <strong>{{ $reservations->firstItem() ?? 0 }}-{{ $reservations->lastItem() ?? 0 }}</strong> /
            <strong>{{ $reservations->total() }}</strong> lượt đặt bàn
        </div>
        <div class="pagination-controls">
            {{ $reservations->links() }}
        </div>
    </div>
</div>