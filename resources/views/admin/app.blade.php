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
                     <h2>Sincay</h2>
                     <p>DASHBOARD</p>
                 </div>
             </div>

             <div class="nav-section">
                 <h3 class="nav-title">Menu chính</h3>
                 <ul class="nav-menu">
                     <li><a href="{{ route('dashboard') }}"
                             class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i
                                 class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                     <li><a href="{{ route('admin.orders') }}"
                             class="{{ request()->routeIs('admin.orders') ? 'active' : '' }}"><i
                                 class="fas fa-shopping-cart"></i> Đơn hàng <span class="badge">24</span></a></li>
                     <li><a href="{{ route('admin.products') }}"
                             class="{{ request()->routeIs('admin.products') ? 'active' : '' }}"><i
                                 class="fas fa-box"></i> Sản phẩm</a></li>
                     <li><a href="{{ route('admin.customers') }}"
                             class="{{ request()->routeIs('admin.customers') ? 'active' : '' }}"><i
                                 class="fas fa-users"></i> Khách hàng</a></li>
                     <li><a href=" "><i class="fas fa-chart-bar"></i> Báo cáo</a></li>
                     <li><a href="{{ route('admin.coupons') }}"
                             class="{{ request()->routeIs('admin.coupons') ? 'active' : '' }}"><i
                                 class="fas fa-tags"></i> Khuyến mãi</a></li>
                 </ul>
             </div>

             <div class="nav-section">
                 <h3 class="nav-title">Cài đặt</h3>
                 <ul class="nav-menu">
                     <li><a href="#"><i class="fas fa-cog"></i> Cấu hình</a></li>
                     <li><a href="{{ route('admin.users') }}"
                             class="{{ request()->routeIs('admin.users') ? 'active' : '' }}"><i
                                 class="fas fa-user-shield"></i> Người dùng</a></li>
                     <li><a href="{{ route('admin.notifications') }}"
                             class="{{ request()->routeIs('admin.notifications') ? 'active' : '' }}"><i
                                 class="fas fa-bell"></i> Thông báo</a></li>
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
                 @yield('content')
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
