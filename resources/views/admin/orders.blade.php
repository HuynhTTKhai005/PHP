@extends('admin.app')
@section('content')
    <!-- Content Area -->
    <div class="content-area">
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card fade-in">
                <div class="stat-icon icon-total">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="stat-info">
                    <h3 id="totalOrders">{{ $totalOrdersThisMonth }}</h3>
                    <p>Tổng đơn hàng</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-icon icon-pending">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3 id="pendingOrders">{{ $pendingOrders }}</h3>
                    <p>Chờ xử lý</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-icon icon-processing">
                    <i class="fas fa-sync-alt"></i>
                </div>
                <div class="stat-info">
                    <h3 id="processingOrders">{{ $processingOrders }}</h3>
                    <p>Đang xử lý</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-icon icon-completed">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3 id="completedOrders">{{ $completedOrders }}</h3>
                    <p>Hoàn thành</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <form action="{{ route('admin.orders') }}" method="GET" class="filter-form js-admin-orders-filter">

            <div class="filter-section">
                <div class="filter-group">
                    <label>Trạng thái</label>
                    <select name="status" class="filter-select" id="statusFilter">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Đang chờ xử lý
                        </option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận
                        </option>
                        <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>Đang chuẩn bị
                        </option>
                        <option value="delivering" {{ request('status') == 'delivering' ? 'selected' : '' }}>Đang giao
                        </option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành
                        </option>
                        <option value="cancel_requested" {{ request('status') == 'cancel_requested' ? 'selected' : '' }}>
                            Chờ duyệt hủy</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>

                </div>
                <div class="filter-group">
                    <label>Từ ngày</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="filter-input">
                </div>
                <div class="filter-group">
                    <label>Đến ngày</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="filter-input">
                </div>
                <div class="filter-group">
                    <label>Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Mã đơn, tên KH..."
                        class="filter-input">
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Lọc
                    </button>
                    <a href="{{ route('admin.orders') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Đặt lại
                    </a>
                </div>
            </div>
        </form>

        <!-- Orders Table -->
        <div class="orders-container" id="admin-orders-table">
            <div class="section-header">
                <h2>Danh sách đơn hàng</h2>
            </div>
            @include('admin.partials.orders_table', ['orders' => $orders])
        </div>

    </div>
@endsection