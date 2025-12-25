<?php
session_start();
// Dữ liệu mẫu
$stats = [
    'total_revenue' => 45280.5,
    'total_orders' => 1284,
    'total_customers' => 842,
    'conversion_rate' => 3.2,
];

$recent_orders = [['id' => '#ORD-1001', 'customer' => 'Nguyễn Văn A', 'amount' => 450.0, 'status' => 'completed', 'date' => '15/01/2024'], ['id' => '#ORD-1002', 'customer' => 'Trần Thị B', 'amount' => 320.5, 'status' => 'pending', 'date' => '15/01/2024'], ['id' => '#ORD-1003', 'customer' => 'Lê Văn C', 'amount' => 210.75, 'status' => 'processing', 'date' => '14/01/2024'], ['id' => '#ORD-1004', 'customer' => 'Phạm Thị D', 'amount' => 189.9, 'status' => 'completed', 'date' => '14/01/2024'], ['id' => '#ORD-1005', 'customer' => 'Hoàng Văn E', 'amount' => 540.25, 'status' => 'cancelled', 'date' => '13/01/2024']];

$top_products = [['name' => 'iPhone 15 Pro Max', 'sales' => 245, 'revenue' => 367500, 'stock' => 42], ['name' => 'MacBook Air M2', 'sales' => 189, 'revenue' => 226800, 'stock' => 15], ['name' => 'AirPods Pro 2', 'sales' => 312, 'revenue' => 93600, 'stock' => 68], ['name' => 'iPad Air 5', 'sales' => 156, 'revenue' => 124800, 'stock' => 23], ['name' => 'Apple Watch S9', 'sales' => 278, 'revenue' => 111200, 'stock' => 31]];

$recent_customers = [['name' => 'Trần Minh Đức', 'email' => 'duc.tm@email.com', 'join_date' => '15/01/2024', 'orders' => 2, 'total' => 1250.5], ['name' => 'Nguyễn Thị Hương', 'email' => 'huong.nt@email.com', 'join_date' => '14/01/2024', 'orders' => 1, 'total' => 650.0], ['name' => 'Lê Văn Tài', 'email' => 'tai.lv@email.com', 'join_date' => '14/01/2024', 'orders' => 3, 'total' => 2100.75], ['name' => 'Phạm Quang Huy', 'email' => 'huy.pq@email.com', 'join_date' => '13/01/2024', 'orders' => 5, 'total' => 1890.9], ['name' => 'Hoàng Thị Mai', 'email' => 'mai.ht@email.com', 'join_date' => '12/01/2024', 'orders' => 2, 'total' => 1540.25]];
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Thương mại điện tử</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

</head>

<body>
    <div class="app-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div class="logo-text">
                    <h2>E-Shop Pro</h2>
                    <p>Admin Dashboard</p>
                </div>
            </div>

            <div class="nav-section">
                <h3 class="nav-title">Menu chính</h3>
                <ul class="nav-menu">
                    <li><a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="#"><i class="fas fa-shopping-cart"></i> Đơn hàng <span
                                class="badge">24</span></a></li>
                    <li><a href="#"><i class="fas fa-box"></i> Sản phẩm</a></li>
                    <li><a href="#"><i class="fas fa-users"></i> Khách hàng</a></li>
                    <li><a href="#"><i class="fas fa-chart-bar"></i> Báo cáo</a></li>
                    <li><a href="#"><i class="fas fa-tags"></i> Khuyến mãi</a></li>
                </ul>
            </div>

            <div class="nav-section">
                <h3 class="nav-title">Cài đặt</h3>
                <ul class="nav-menu">
                    <li><a href="#"><i class="fas fa-cog"></i> Cấu hình</a></li>
                    <li><a href="#"><i class="fas fa-user-shield"></i> Người dùng</a></li>
                    <li><a href="#"><i class="fas fa-bell"></i> Thông báo</a></li>
                    <li><a href="#"><i class="fas fa-question-circle"></i> Trợ giúp</a></li>
                </ul>
            </div>

            <div class="nav-section" style="margin-top: auto; padding-bottom: 30px;">
                <div class="quick-stats">
                    <div class="quick-stat">
                        <h4>98%</h4>
                        <p>Uptime</p>
                    </div>
                    <div class="quick-stat">
                        <h4>2.4s</h4>
                        <p>Tải trang</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Header -->
            <div class="top-header">
                <div class="header-left">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Tìm kiếm đơn hàng, sản phẩm, khách hàng...">
                    </div>
                </div>

                <div class="header-right">
                    <div class="header-icon">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">5</span>
                    </div>
                    <div class="header-icon">
                        <i class="fas fa-envelope"></i>
                        <span class="notification-badge">3</span>
                    </div>
                    <div class="header-icon">
                        <i class="fas fa-cog"></i>
                    </div>

                    <div class="user-profile">
                        <div class="user-avatar">
                            AD
                        </div>
                        <div class="user-info">
                            <h4>Admin User</h4>
                            <p>Quản trị viên</p>
                        </div>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>

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
                            <i class="fas fa-plus"></i> Thêm sản phẩm
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card fade-in delay-1">
                        <div class="stat-header">
                            <div class="stat-icon icon-revenue">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="trend">
                                <i class="fas fa-arrow-up"></i> 12.5%
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['total_revenue'], 0, ',', '.'); ?>đ</h3>
                            <p>Tổng doanh thu</p>
                        </div>
                        <div class="stat-footer">
                            <i class="fas fa-calendar"></i> Tháng 1, 2024
                        </div>
                    </div>

                    <div class="stat-card fade-in delay-2">
                        <div class="stat-header">
                            <div class="stat-icon icon-orders">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="trend">
                                <i class="fas fa-arrow-up"></i> 8.2%
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['total_orders']); ?></h3>
                            <p>Tổng đơn hàng</p>
                        </div>
                        <div class="stat-footer">
                            <i class="fas fa-calendar"></i> Tháng 1, 2024
                        </div>
                    </div>

                    <div class="stat-card fade-in delay-3">
                        <div class="stat-header">
                            <div class="stat-icon icon-customers">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="trend">
                                <i class="fas fa-arrow-up"></i> 5.7%
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['total_customers']); ?></h3>
                            <p>Tổng khách hàng</p>
                        </div>
                        <div class="stat-footer">
                            <i class="fas fa-calendar"></i> Tháng 1, 2024
                        </div>
                    </div>

                    <div class="stat-card fade-in delay-4">
                        <div class="stat-header">
                            <div class="stat-icon icon-conversion">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="trend down">
                                <i class="fas fa-arrow-down"></i> 1.3%
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $stats['conversion_rate']; ?>%</h3>
                            <p>Tỷ lệ chuyển đổi</p>
                        </div>
                        <div class="stat-footer">
                            <i class="fas fa-calendar"></i> So với tháng trước
                        </div>
                    </div>
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
                            <a href="#" class="btn btn-secondary" style="padding: 8px 16px; font-size: 13px;">
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
                                    <?php foreach ($recent_orders as $order): ?>
                                    <tr>
                                        <td><strong><?php echo $order['id']; ?></strong></td>
                                        <td><?php echo $order['customer']; ?></td>
                                        <td><?php echo $order['date']; ?></td>
                                        <td><?php echo number_format($order['amount'], 0, ',', '.'); ?>đ</td>
                                        <td>
                                            <span class="status-badge status-<?php echo $order['status']; ?>">
                                                <?php
                                                $status_labels = [
                                                    'completed' => 'Hoàn thành',
                                                    'pending' => 'Chờ xử lý',
                                                    'processing' => 'Đang xử lý',
                                                    'cancelled' => 'Đã hủy',
                                                ];
                                                echo $status_labels[$order['status']];
                                                ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
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
                                        <span class="status-badge"
                                            style="background: rgba(52, 152, 219, 0.1); color: #3498db;">Thân
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
        </div>
    </div>

    <script>
        // Toggle Sidebar
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                datasets: [{
                    label: 'Doanh thu (triệu VNĐ)',
                    data: [32.5, 38.2, 42.8, 48.5, 45.2, 52.8],
                    borderColor: '#4361ee',
                    backgroundColor: 'rgba(67, 97, 238, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#4361ee',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += new Intl.NumberFormat('vi-VN', {
                                    style: 'currency',
                                    currency: 'VND'
                                }).format(context.parsed.y * 1000000);
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + 'M';
                            }
                        },
                        grid: {
                            borderDash: [5, 5]
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'nearest'
                }
            }
        });

        // Update chart on period change
        document.querySelector('.period-select').addEventListener('change', function(e) {
            // In thực tế, sẽ gọi API để lấy dữ liệu mới
            console.log('Period changed to:', e.target.value);
        });

        // Auto refresh data every 60 seconds
        setInterval(function() {
            // Simulate data update
            const revenueElement = document.querySelector('.stat-card:nth-child(1) h3');
            const currentRevenue = parseFloat(revenueElement.textContent.replace(/[^0-9]/g, ''));
            const newRevenue = currentRevenue + Math.floor(Math.random() * 1000000);
            revenueElement.textContent = new Intl.NumberFormat('vi-VN').format(newRevenue) + 'đ';

            // Show notification
            console.log('Dữ liệu đã được cập nhật tự động');
        }, 60000);

        // Add animation to stats cards on hover
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Search functionality
        const searchInput = document.querySelector('.search-box input');
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                alert('Tìm kiếm: ' + this.value);
                // In thực tế, sẽ thực hiện tìm kiếm và hiển thị kết quả
            }
        });
    </script>
</body>

</html>
