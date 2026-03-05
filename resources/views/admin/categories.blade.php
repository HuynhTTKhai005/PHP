@extends('admin.app')

@section('content')
    <div class="content-area">
        <div class="page-header fade-in">
            <div class="page-title">
                <h1>Quản lý danh mục</h1>
                <p>Quản lý danh mục sản phẩm trong hệ thống.</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm danh mục
                </a>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-total"><i class="fas fa-layer-group"></i></div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['total']) }}</h3>
                    <p>Tổng danh mục</p>
                </div>
            </div>
            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-active"><i class="fas fa-check-circle"></i></div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['active']) }}</h3>
                    <p>Đang hoạt động</p>
                </div>
            </div>
            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-expired"><i class="fas fa-ban"></i></div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['inactive']) }}</h3>
                    <p>Đã tắt</p>
                </div>
            </div>
        </div>

        <div class="filter-section fade-in">
            <form method="GET" action="{{ route('admin.categories') }}" style="display:flex;gap:15px;align-items:flex-end;flex-wrap:wrap;width:100%;">
                <div class="filter-group">
                    <label>Trạng thái</label>
                    <select class="filter-select" name="status">
                        <option value="">Tất cả</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Đã tắt</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Tìm kiếm</label>
                    <input type="text" class="filter-input" name="search" value="{{ request('search') }}" placeholder="Tên danh mục, slug...">
                </div>

                <div class="filter-actions">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Lọc</button>
                    <a class="btn btn-secondary" href="{{ route('admin.categories') }}"><i class="fas fa-redo"></i> Đặt lại</a>
                </div>
            </form>
        </div>

        <div class="coupons-container fade-in">
            <div class="section-header">
                <h2>Danh sách danh mục</h2>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Tên danh mục</th>
                            <th>Slug</th>
                            <th>Số sản phẩm</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ number_format($category->products_count) }}</td>
                                <td>
                                    @if ($category->is_active)
                                        <span class="status-badge status-active">Đang hoạt động</span>
                                    @else
                                        <span class="status-badge status-disabled">Đã tắt</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="action-btn edit" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="js-delete-category-form" data-category-name="{{ $category->name }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Không có dữ liệu danh mục.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <div class="pagination-info">
                    Hiển thị <strong>{{ $categories->firstItem() ?? 0 }}-{{ $categories->lastItem() ?? 0 }}</strong> của
                    <strong>{{ $categories->total() }}</strong> danh mục
                </div>
                <div class="pagination-controls">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection