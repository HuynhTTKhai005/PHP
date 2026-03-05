@extends('admin.app')

@section('content')
    <div class="content-area">
        <div class="page-header">
            <div class="page-title">
                <h1>Quản lý Thông báo</h1>
                <p>Gửi, theo dõi và quản lý tất cả thông báo trong hệ thống</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="{{ route('admin.notifications', request()->query()) }}"><i class="fas fa-sync"></i> Làm mới</a>
                <a class="btn btn-primary" href="{{ route('admin.notifications.create') }}"><i class="fas fa-paper-plane"></i> Gửi thông báo mới</a>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-total"><i class="fas fa-bell"></i></div>
                <div class="stat-content"><h3>{{ number_format($stats['total']) }}</h3><p>Tong thông báo da gui</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-completed"><i class="fas fa-eye"></i></div>
                <div class="stat-content"><h3>{{ number_format($stats['read']) }}</h3><p>Đã đọc</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-pending"><i class="fas fa-eye-slash"></i></div>
                <div class="stat-content"><h3>{{ number_format($stats['unread']) }}</h3><p>Chưa đọc</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-processing"><i class="fas fa-clock"></i></div>
                <div class="stat-content"><h3>{{ number_format($stats['today']) }}</h3><p>Gui hom nay</p></div>
            </div>
        </div>

        <div class="filter-section">
            <form method="GET" action="{{ route('admin.notifications') }}" style="display:flex;gap:15px;align-items:flex-end;flex-wrap:wrap;width:100%;">
                <div class="filter-group">
                    <label>Loai thông báo</label>
                    <select class="filter-select" name="type">
                        <option value="">Tất cả loai</option>
                        <option value="order_update" {{ request('type') === 'order_update' ? 'selected' : '' }}>Cập nhật đơn hàng</option>
                        <option value="promotion" {{ request('type') === 'promotion' ? 'selected' : '' }}>Khuyến mãi</option>
                        <option value="system_alert" {{ request('type') === 'system_alert' ? 'selected' : '' }}>Cảnh báo hệ thống</option>
                        <option value="password_reset" {{ request('type') === 'password_reset' ? 'selected' : '' }}>Dat lai mat khau</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Trạng thái doc</label>
                    <select class="filter-select" name="is_read">
                        <option value="">Tất cả</option>
                        <option value="1" {{ request('is_read') === '1' ? 'selected' : '' }}>Đã đọc</option>
                        <option value="0" {{ request('is_read') === '0' ? 'selected' : '' }}>Chưa đọc</option>
                    </select>
                </div>
                <div class="filter-group"><label>Tu ngay</label><input type="date" class="filter-input" name="from_date" value="{{ request('from_date') }}"></div>
                <div class="filter-group"><label>Den ngay</label><input type="date" class="filter-input" name="to_date" value="{{ request('to_date') }}"></div>
                <div class="filter-group"><label>Tìm kiếm</label><input type="text" class="filter-input" name="search" value="{{ request('search') }}" placeholder="Tiêu đề, nội dung, email..."></div>
                <div class="filter-actions">
                    <a class="btn btn-secondary" href="{{ route('admin.notifications') }}">Xóa bo loc</a>
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
                </div>
            </form>
        </div>

        <div class="card products-container">
            <div class="section-header">
                <h2>Danh sách thông báo</h2>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Người nhận</th>
                            <th>Loai</th>
                            <th>Tiêu đề</th>
                            <th>Noi dung</th>
                            <th>Đã đọc</th>
                            <th>Thoi gian gui</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notifications as $notification)
                            <tr>
                                <td>#{{ $notification->id }}</td>
                                <td>{{ $notification->user?->email ?: '-' }}</td>
                                <td><span class="status-badge">{{ $notification->type }}</span></td>
                                <td>{{ $notification->title }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($notification->message, 80) }}</td>
                                <td>
                                    @if ($notification->is_read)
                                        <span class="status-badge status-completed">Đã đọc</span>
                                    @else
                                        <span class="status-badge status-pending">Chưa đọc</span>
                                    @endif
                                </td>
                                <td>{{ $notification->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="action-buttons">
                                    <a class="action-btn edit" href="{{ route('admin.notifications.show', array_merge(['notification' => $notification->id], request()->query())) }}"><i class="fas fa-eye"></i></a>
                                    @if (!$notification->is_read)
                                        <form action="{{ route('admin.notifications.read', $notification) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button class="action-btn" type="submit"><i class="fas fa-check"></i></button>
                                        </form>
                                    @endif
                                    @if (auth()->user()->isAdmin())
                                        <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" class="js-delete-notification-form" data-notification-title="{{ $notification->title }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="action-btn delete" type="submit"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">Không có dữ liệu thông báo</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <div class="pagination-info">Hiển thị {{ $notifications->firstItem() ?? 0 }}-{{ $notifications->lastItem() ?? 0 }} của {{ $notifications->total() }} thông báo</div>
                <div class="pagination-controls">{{ $notifications->links() }}</div>
            </div>
        </div>
    </div>

    <div class="modal" id="viewNotificationModal" style="display: {{ $selectedNotification ? 'flex' : 'none' }};">
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h3>Chi tiết thông báo #{{ $selectedNotification?->id }}</h3>
                <a class="close-modal" href="{{ route('admin.notifications', request()->query()) }}">&times;</a>
            </div>
            @if ($selectedNotification)
                <div class="modal-body">
                    <div class="detail-group"><label>Người nhận</label><p>{{ $selectedNotification->user?->email ?: '-' }}</p></div>
                    <div class="detail-group"><label>Loai</label><p>{{ $selectedNotification->type }}</p></div>
                    <div class="detail-group"><label>Tiêu đề</label><p><strong>{{ $selectedNotification->title }}</strong></p></div>
                    <div class="detail-group"><label>Noi dung</label><p>{{ $selectedNotification->message }}</p></div>
                    <div class="detail-group">
                        <label>Trạng thái</label>
                        <p>
                            @if ($selectedNotification->is_read)
                                <span class="status-badge status-completed">Đã đọc</span>
                            @else
                                <span class="status-badge status-pending">Chưa đọc</span>
                            @endif
                        </p>
                    </div>
                    <div class="detail-group"><label>Thoi gian gui</label><p>{{ $selectedNotification->created_at?->format('d/m/Y H:i') }}</p></div>
                </div>
            @endif
        </div>
    </div>
@endsection

