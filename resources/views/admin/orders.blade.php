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
        <div class="filter-section">
            <div class="filter-group">
                <label>Trạng thái</label>
                <select class="filter-select" id="statusFilter">
                    <option value="">Tất cả</option>
                    <option value="pending">Chờ xử lý</option>
                    <option value="processing">Đang xử lý</option>
                    <option value="shipped">Đang giao</option>
                    <option value="completed">Hoàn thành</option>
                    <option value="cancelled">Đã hủy</option>
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

        <!-- Orders Table -->
        <div class="orders-container">
            <div class="section-header">
                <h2>Danh sách đơn hàng</h2>
                <button class="btn btn-primary" onclick="addNewOrder()">
                    <i class="fas fa-plus"></i> Thêm đơn hàng
                </button>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thanh toán</th>
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
                                        {{ ucfirst(trans('order.status.' . $order->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}" class="action-btn" title="Xem">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Không có đơn hàng nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>





    </div>

    <script>
        function addNewOrder() {
            window.location.href = '{{ route('admin.orders.create') }}';
        }
    </script>
@endsection
