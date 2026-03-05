@extends('admin.app')

@section('content')
    <div class="content-area products-page">
        <div class="page-header fade-in">
            <div class="page-title">
                <h1>Quản lý sản phẩm</h1>
                <p>Tổng quan và quản lý danh mục sản phẩm của cửa hàng</p>
            </div>
            <div class="header-actions">
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm sản phẩm
                    </a>
                @endif
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-total">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($totalProducts) }}</h3>
                    <p>Tổng sản phẩm</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-stock">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($inStockProducts) }}</h3>
                    <p>Còn hàng</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-stock">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($lowStockProducts) }}</h3>
                    <p>Sắp hết hàng</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-outofstock">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($outOfStockProducts) }}</h3>
                    <p>Hết hàng</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-categories">
                        <i class="fas fa-tags"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($totalCategories) }}</h3>
                    <p>Danh mục</p>
                </div>
            </div>
        </div>

        <div class="filter-section fade-in">
            <form method="GET" action="{{ route('admin.products') }}" class="products-filter-form">
                <div class="filter-group filter-group-category">
                    <label>Danh mục</label>
                    <select name="category" class="filter-select">
                        <option value="">Tất cả danh mục</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label>Tình trạng</label>
                    <select name="status" class="filter-select">
                        <option value="">Tất cả</option>
                        <option value="instock" {{ request('status') == 'instock' ? 'selected' : '' }}>Còn hàng</option>
                        <option value="lowstock" {{ request('status') == 'lowstock' ? 'selected' : '' }}>Sắp hết</option>
                        <option value="outofstock" {{ request('status') == 'outofstock' ? 'selected' : '' }}>Hết hàng
                        </option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="filter-input"
                        placeholder="Tên sản phẩm, mã SKU...">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Lọc
                    </button>
                    <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Đặt lại
                    </a>
                </div>
            </form>
        </div>

        <div class="products-container fade-in">
            <div class="section-header">
                <h2>Danh sách sản phẩm</h2>
                <div class="table-actions">
                    <button class="btn btn-secondary" onclick="location.reload()">
                        <i class="fas fa-sync-alt"></i> Làm mới
                    </button>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <div class="product-info">
                                        <div class="product-image">
                                            @if ($product->image_url)
                                                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
                                            @else
                                                <i class="fas fa-box"></i>
                                            @endif
                                        </div>
                                        <div class="product-details">
                                            <h4>{{ $product->name }}</h4>
                                            <p>{{ $product->category?->name ?? 'Không có danh mục' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="price">{{ number_format($product->base_price_cents, 0, ',', '.') }}đ</td>
                                <td>
                                    <div class="stock-progress">
                                        <span>{{ $product->stock }}</span>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ $product->progress_width }}%">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="status-badge status-{{ $product->stock_status }}">{{ $product->stock_text }}</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.products.show', $product) }}" class="action-btn view"
                                            title="Xem sản phẩm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.products.toggleAvailability', $product) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="action-btn {{ $product->is_available ? 'edit' : 'view' }}"
                                                title="{{ $product->is_available ? 'Tắt còn bán' : 'Bật còn bán' }}">
                                                <i
                                                    class="fas {{ $product->is_available ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                            </button>
                                        </form>
                                        @if (auth()->user()->isAdmin())
                                            <a href="{{ route('admin.products.edit', $product) }}" class="action-btn edit"
                                                title="Chỉnh sửa sản phẩm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                                class="js-delete-product-form" data-product-name="{{ $product->name }}"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete" title="Xóa sản phẩm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Không có sản phẩm nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="products-pagination">
                <p class="pagination-summary products-pagination-summary">
                    Hiển thị {{ $pagination['from'] }} - {{ $pagination['to'] }} trên {{ $pagination['total'] }} sản phẩm
                </p>
                <div class="pagination-links">
                    {{ $products->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
