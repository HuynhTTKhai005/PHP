@extends('admin.app')

@section('content')
    <div class="content-area users-page">
        <div class="page-header">
            <div class="page-title">
                <h1>Quản lý người dùng</h1>
                <p>Quản lý tài khoản Admin và Nhân viên</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm người dùng
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success reservation-alert">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger reservation-alert">{{ session('error') }}</div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-total"><i class="fas fa-users"></i></div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['total']) }}</h3>
                    <p>Tổng tài khoản</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-completed"><i class="fas fa-user-shield"></i></div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['admin']) }}</h3>
                    <p>Admin</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-processing"><i class="fas fa-user-tie"></i></div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['staff']) }}</h3>
                    <p>Nhân viên</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-active"><i class="fas fa-check-circle"></i></div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['active']) }}</h3>
                    <p>Đang hoạt động</p>
                </div>
            </div>
        </div>

        <div class="filter-section">
            <form method="GET" action="{{ route('admin.users') }}" class="users-filter-form">
                <div class="filter-group">
                    <label>Role</label>
                    <select class="filter-select" name="role_id">
                        <option value="">Tất cả</option>
                        <option value="1" {{ request('role_id') === '1' ? 'selected' : '' }}>Admin</option>
                        <option value="2" {{ request('role_id') === '2' ? 'selected' : '' }}>Nhân viên</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Trạng thái</label>
                    <select class="filter-select" name="status">
                        <option value="">Tất cả</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Đã khóa</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Tìm kiếm</label>
                    <input type="text" class="filter-input" name="search" value="{{ request('search') }}"
                        placeholder="Tên, email, SĐT...">
                </div>
                <div class="filter-actions">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Lọc</button>
                    <a class="btn btn-secondary" href="{{ route('admin.users') }}"><i class="fas fa-redo"></i> Đặt lại</a>
                </div>
            </form>
        </div>

        <div class="card products-container">
            <div class="section-header">
                <h2>Danh sách Admin và Nhân viên</h2>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>Quyền hiện tại</th>
                            <th>Trạng thái</th>
                            <th>Tạo lúc</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?: '-' }}</td>
                                <td><span class="status-badge {{ $user->role_badge }}">{{ $user->role_label }}</span></td>
                                <td><span class="status-badge {{ $user->status_badge }}">{{ $user->status_label }}</span></td>
                                <td>{{ $user->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="action-buttons">
                                    <form action="{{ route('admin.users.updateRole', $user) }}" method="POST"
                                        class="users-inline-form users-action-form">
                                        @csrf
                                        @method('PATCH')
                                        <select class="filter-select users-role-select" name="role_id" aria-label="Đổi quyền">
                                            <option value="{{ \App\Models\User::ROLE_ADMIN }}"
                                                {{ (int) $user->role_id === \App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>
                                                Admin</option>
                                            <option value="{{ \App\Models\User::ROLE_STAFF }}"
                                                {{ (int) $user->role_id === \App\Models\User::ROLE_STAFF ? 'selected' : '' }}>
                                                Nhân viên</option>
                                        </select>
                                        <button type="submit" class="action-btn edit" title="Thay đổi quyền">
                                            <i class="fas fa-user-cog"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.users.updateStatus', $user) }}" method="POST"
                                        class="users-inline-form users-action-form">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="is_active" value="{{ $user->is_active ? 0 : 1 }}">
                                        <button type="submit" class="action-btn {{ $user->is_active ? 'delete' : 'edit' }}"
                                            title="{{ $user->is_active ? 'Khóa hoạt động' : 'Mở hoạt động' }}">
                                            <i class="fas {{ $user->is_active ? 'fa-user-lock' : 'fa-user-check' }}"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Không có dữ liệu tài khoản</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <div class="pagination-info">
                    Hiển thị {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} / {{ $users->total() }} tài khoản
                </div>
                <div class="pagination-controls">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
@endsection
