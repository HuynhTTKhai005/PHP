<div class="content-area dashboard-home">
    <div class="page-header fade-in">
        <div class="page-title">
            <h1>Dashboard Quản trị</h1>
            <p>Tổng quan hiệu suất và thống kê kinh doanh</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.products') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm sản phẩm
            </a>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card fade-in delay-1">
            <div class="stat-header">
                <div class="stat-icon icon-revenue">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="trend {{ $growthPercentage >= 0 ? 'up' : 'down' }}">
                    <i class="fas fa-arrow-{{ $growthPercentage >= 0 ? 'up' : 'down' }}"></i>
                    {{ abs($growthPercentage) }}%
                </div>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($totalRevenueThisMonth, 0, ',', '.') }}đ</h3>
                <p>Tổng doanh thu</p>
            </div>
            <div class="stat-footer">
                <i class="fas fa-calendar"></i> {{ $monthDisplay }}
            </div>
        </div>

        <div class="stat-card fade-in delay-2">
            <div class="stat-header">
                <div class="stat-icon icon-orders">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="trend {{ $ordersGrowth >= 0 ? 'up' : 'down' }}">
                    <i class="fas fa-arrow-{{ $ordersGrowth >= 0 ? 'up' : 'down' }}"></i>
                    {{ abs($ordersGrowth) }}%
                </div>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($totalOrdersThisMonth) }}</h3>
                <p>Tổng đơn hàng</p>
            </div>
            <div class="stat-footer">
                <i class="fas fa-calendar"></i> {{ $monthDisplay }}
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="card fade-in">
            <div class="card-header">
                <h3>Doanh thu theo tháng</h3>
            </div>
            <div class="chart-container" style="height: 320px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <div class="card fade-in">
            <div class="card-header">
                <h3>Hoạt động gần đây</h3>
                <div class="options">
                    <i class="fas fa-ellipsis-h"></i>
                </div>
            </div>
            <ul class="activity-feed dashboard-scroll activity-scroll">
                @forelse($recentActivities as $activity)
                    <li class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-{{ $activity['icon'] }}"></i>
                        </div>
                        <div class="activity-content">
                            <h4>{{ $activity['title'] }}</h4>
                            <p>{{ $activity['description'] }}</p>
                            <div class="activity-time">{{ $activity['time_ago'] }}</div>
                        </div>
                    </li>
                @empty
                    <li class="activity-item activity-empty">
                        <p>Chưa có hoạt động nào</p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="card fade-in">
            <div class="card-header">
                <h3>Đơn hàng gần đây</h3>
                <a href="{{ route('admin.orders') }}" class="btn btn-secondary">Xem tất cả</a>
            </div>
            <div class="table-container dashboard-scroll orders-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Số tiền</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td><strong>{{ $order['order_number'] }}</strong></td>
                                <td>{{ $order['customer'] }}</td>
                                <td>{{ $order['date'] }}</td>
                                <td>{{ number_format($order['amount'], 0, ',', '.') }}đ</td>
                                <td>
                                    <span class="status-badge status-{{ $order['status'] }}">
                                        {{ [
                                            'completed' => 'Hoàn thành',
                                            'processing' => 'Đang xử lý',
                                            'pending' => 'Chờ xử lý',
                                            'cancelled' => 'Đã hủy',
                                            'shipped' => 'Đã giao',
                                        ][$order['status']] ?? 
                                            \Illuminate\Support\Str::title($order['status']) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-table-cell">Chưa có đơn hàng nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card fade-in">
            <div class="card-header">
                <h3>Sản phẩm bán chạy</h3>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">Xem tất cả</a>
            </div>
            <div class="table-container dashboard-scroll top-products-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đã bán</th>
                            <th>Doanh thu</th>
                            <th>Tồn kho</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $product)
                            <tr>
                                <td>
                                    <div class="product-info">
                                        <div class="product-icon">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight: 600;">{{ $product['name'] }}</div>
                                            <div style="font-size: 12px; color: var(--gray);">Sản phẩm</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $product['sales'] }}</td>
                                <td>{{ number_format($product['revenue'], 0, ',', '.') }}đ</td>
                                <td>
                                    <div>{{ $product['stock'] }}</div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $product['stock_percent'] }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-table-cell">Chưa có dữ liệu bán hàng</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card fade-in">
        <div class="card-header">
            <h3>Khách hàng mới</h3>
            <a href="{{ route('admin.customers') }}" class="btn btn-secondary">Xem tất cả</a>
        </div>
        <div class="customers-list-container dashboard-scroll customers-scroll">
            @forelse($recentCustomers as $customer)
                <div class="customer-item">
                    <div class="customer-avatar">
                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($customer['name'], 0, 1)) }}
                    </div>
                    <div class="customer-info">
                        <div class="customer-name">{{ $customer['name'] }}</div>
                        <div class="customer-email">{{ $customer['email'] }}</div>
                        <div class="customer-meta">
                            <span class="meta-item">
                                <i class="fas fa-shopping-bag"></i> {{ $customer['orders'] }} đơn
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-calendar"></i> {{ $customer['time_ago'] }}
                            </span>
                        </div>
                    </div>
                    <div class="customer-total">
                        {{ number_format($customer['total'], 0, ',', '.') }}đ
                    </div>
                </div>
            @empty
                <div class="customer-empty-state">
                    <i class="fas fa-inbox"></i>
                    Chưa có khách hàng mới
                </div>
            @endforelse
        </div>
    </div>

    <div class="footer">
        <p>© 2026 Sincay Dashboard</p>
        <p>Dữ liệu được cập nhật lần cuối: {{ $lastUpdatedAt }}</p>
    </div>
</div>