 
@extends('admin.app')

@section('title', 'Dashboard')
@section('content')
    <!-- Content Area -->
    <div class="content-area">
        <!-- Page Header -->
        <div class="page-header fade-in">
            <div class="page-title">
                <h1>Dashboard Thương mại điện tử</h1>
                <p>Tổng quan hiệu suất và thống kê kinh doanh</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-secondary">
                    <i class="fas fa-download"></i> Xuất báo cáo
                </button>
                <button class="btn btn-primary">
                    <a href="{{ route('admin.products') }}"><i class="fas fa-plus"></i> Thêm sản phẩm</a>
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            {{-- tổng doanh thu done --}}
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


            {{-- tổng đơn hàng done --}}
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

            {{-- <div class="stat-card fade-in delay-3">
                        <div class="stat-header">
                            <div class="stat-icon icon-customers">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="trend {{ $customersGrowth >= 0 ? 'up' : 'down' }}">
                                <i class="fas fa-arrow-{{ $customersGrowth >= 0 ? 'up' : 'down' }}"></i>
                                {{ abs($customersGrowth) }}%
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3>{{ number_format($newCustomersThisMonth) }}</h3>
                            <p>Khách hàng mới</p> <!-- hoặc "Tổng khách hàng" nếu bạn dùng tổng tích lũy -->
                        </div>
                        <div class="stat-footer">
                            <i class="fas fa-calendar"></i> {{ $monthDisplay }}
                        </div>
                    </div> --}}

        </div>

        <!-- Charts and Tables -->
        <div class="dashboard-grid">
            <!-- Left Column: Revenue Chart -->
            <div class="card fade-in">
                <div class="card-header">
                    <h3>Doanh thu theo tháng</h3>
                    <div class="options">
                        <select class="period-select">
                            <option>6 tháng gần nhất</option>
                            <option>Năm 2023</option>
                            <option>Năm 2024</option>
                        </select>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Right Column: Recent Activity -->
            <div class="card fade-in">
                <div class="card-header">
                    <h3>Hoạt động gần đây</h3>
                    <div class="options">
                        <i class="fas fa-ellipsis-h"></i>
                    </div>
                </div>
                <ul class="activity-feed">
                    <li class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="activity-content">
                            <h4>Đơn hàng mới #ORD-1006</h4>
                            <p>Khách hàng: Nguyễn Văn F - Tổng: 750.000đ</p>
                            <div class="activity-time">10 phút trước</div>
                        </div>
                    </li>
                    <li class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-content">
                            <h4>Khách hàng mới đăng ký</h4>
                            <p>Trần Thị G - Gói: Premium Member</p>
                            <div class="activity-time">45 phút trước</div>
                        </div>
                    </li>
                    <li class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="activity-content">
                            <h4>Sản phẩm mới được thêm</h4>
                            <p>Samsung Galaxy S24 - Danh mục: Điện thoại</p>
                            <div class="activity-time">2 giờ trước</div>
                        </div>
                    </li>
                    <li class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="activity-content">
                            <h4>Báo cáo doanh thu</h4>
                            <p>Doanh thu ngày hôm nay: 45.280.500đ</p>
                            <div class="activity-time">4 giờ trước</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Tables Grid -->
        <div class="dashboard-grid">
            <!-- Left Column: Recent Orders -->
            <div class="card fade-in">
                <div class="card-header">
                    <h3>Đơn hàng gần đây</h3>
                    <a href="/admin/orders" class="btn btn-secondary" style="padding: 8px 16px; font-size: 13px;">
                        Xem tất cả
                    </a>
                </div>
                <div class="table-container">
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
                            @forelse($recent_orders as $order)
                                <tr>
                                    <td><strong>{{ $order['order_number'] }}</strong>
                                    </td>
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
                                            ][$order['status']] ?? Str::title($order['status']) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 30px; color: #999;">
                                        Chưa có đơn hàng nào
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Column: Top Products -->
            <div class="card fade-in">
                <div class="card-header">
                    <h3>Sản phẩm bán chạy</h3>
                    <a href="#" class="btn btn-secondary" style="padding: 8px 16px; font-size: 13px;">
                        Xem tất cả
                    </a>
                </div>
                <div class="table-container">
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
                            <?php foreach ($top_products as $product): ?>
                            <tr>
                                <td>
                                    <div class="product-info">
                                        <div class="product-icon">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight: 600;"><?php echo $product['name']; ?></div>
                                            <div style="font-size: 12px; color: var(--gray);">Điện tử</div>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $product['sales']; ?></td>
                                <td><?php echo number_format($product['revenue'], 0, ',', '.'); ?>đ</td>
                                <td>
                                    <div><?php echo $product['stock']; ?></div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: <?php echo min(100, ($product['stock'] / 100) * 100); ?>%"></div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Customers -->
        <div class="card fade-in">
            <div class="card-header">
                <h3>Khách hàng mới</h3>
                <a href="#" class="btn btn-secondary" style="padding: 8px 16px; font-size: 13px;">
                    Xem tất cả
                </a>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Khách hàng</th>
                            <th>Ngày tham gia</th>
                            <th>Số đơn hàng</th>
                            <th>Tổng chi tiêu</th>
                            <th>Hạng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_customers as $customer): ?>
                        <tr>
                            <td>
                                <div style="font-weight: 600;"><?php echo $customer['name']; ?></div>
                                <div style="font-size: 13px; color: var(--gray);"><?php echo $customer['email']; ?></div>
                            </td>
                            <td><?php echo $customer['join_date']; ?></td>
                            <td><?php echo $customer['orders']; ?></td>
                            <td><?php echo number_format($customer['total'], 0, ',', '.'); ?>đ</td>
                            <td>
                                <?php if ($customer['total'] > 2000): ?>
                                <span class="status-badge"
                                    style="background: rgba(241, 196, 15, 0.1); color: #f1c40f;">VIP</span>
                                <?php elseif ($customer['total'] > 1000): ?>
                                <span class="status-badge" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">Thân
                                    thiết</span>
                                <?php else: ?>
                                <span class="status-badge"
                                    style="background: rgba(149, 165, 166, 0.1); color: #95a5a6;">Mới</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© 2024 E-Shop Pro Dashboard. Phiên bản 2.1.0</p>
            <p>Dữ liệu được cập nhật lần cuối: <?php echo date('H:i:s d/m/Y'); ?></p>
        </div>
    </div>
@endsection
