@extends('admin.app')

@section('content')
    <div class="content-area reservations-page">
        <div class="page-header fade-in">
            <div class="page-title">
                <h1>Quản lý đặt bàn</h1>
                <p>Theo dõi và xử lý yêu cầu đặt bàn của khách hàng</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success reservation-alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger reservation-alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card fade-in">
                <div class="stat-icon icon-total"><i class="fas fa-calendar-alt"></i></div>
                <div class="stat-info">
                    <h3>{{ number_format($stats['total']) }}</h3>
                    <p>Tổng lượt đặt bàn</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-icon icon-processing"><i class="fas fa-calendar-day"></i></div>
                <div class="stat-info">
                    <h3>{{ number_format($stats['today']) }}</h3>
                    <p>Đặt bàn hôm nay</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-icon icon-pending"><i class="fas fa-hourglass-half"></i></div>
                <div class="stat-info">
                    <h3>{{ number_format($stats['pending']) }}</h3>
                    <p>Chờ xác nhận</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-icon icon-completed"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <h3>{{ number_format($stats['confirmed']) }}</h3>
                    <p>Đã xác nhận</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-icon icon-cancelled"><i class="fas fa-times-circle"></i></div>
                <div class="stat-info">
                    <h3>{{ number_format($stats['cancelled']) }}</h3>
                    <p>Đã hủy</p>
                </div>
            </div>
        </div>

        <div class="filter-section fade-in">
            <form method="GET" action="{{ route('admin.reservations') }}" class="reservations-filter-form">
                <div class="filter-group">
                    <label>Trạng thái</label>
                    <select class="filter-select" name="status">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Từ ngày</label>
                    <input type="date" class="filter-input" name="date_from" value="{{ request('date_from') }}">
                </div>

                <div class="filter-group">
                    <label>Đến ngày</label>
                    <input type="date" class="filter-input" name="date_to" value="{{ request('date_to') }}">
                </div>

                <div class="filter-group">
                    <label>Tìm kiếm</label>
                    <input type="text" class="filter-input" name="search" value="{{ request('search') }}"
                        placeholder="Tên, SĐT, email...">
                </div>

                <div class="filter-actions">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Lọc</button>
                    <a class="btn btn-secondary" href="{{ route('admin.reservations') }}"><i class="fas fa-redo"></i> Đặt lại</a>
                </div>
            </form>
        </div>

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
                                                class="reservation-action-form">
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
                                                class="reservation-action-form">
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
                    Hiển thị <strong>{{ $reservations->firstItem() ?? 0 }}-{{ $reservations->lastItem() ?? 0 }}</strong> / <strong>{{ $reservations->total() }}</strong> lượt đặt bàn
                </div>
                <div class="pagination-controls">
                    {{ $reservations->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
