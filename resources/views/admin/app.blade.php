 <!DOCTYPE html>
 <html lang="vi">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Dashboard - Sincay</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <script src="{{ asset('assets/js/chart.js') }}"></script>
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
                 <ul class="nav-menu">
                     <li><a href="{{ route('dashboard') }}"
                             class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i
                                 class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                     <li><a href="{{ route('admin.orders') }}"
                             class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}"><i
                                 class="fas fa-shopping-cart"></i> Đơn hàng</a></li>
                     <li><a href="{{ route('admin.products') }}"
                             class="{{ request()->routeIs('admin.products*') ? 'active' : '' }}"><i
                                 class="fas fa-box"></i> Sản phẩm</a></li>
                     @if (auth()->user()->isAdmin())
                         <li><a href="{{ route('admin.categories') }}"
                                 class="{{ request()->routeIs('admin.categories*') ? 'active' : '' }}"><i
                                     class="fas fa-layer-group"></i> Danh mục</a></li>
                     @endif
                     <li><a href="{{ route('admin.customers') }}"
                             class="{{ request()->routeIs('admin.customers*') ? 'active' : '' }}"><i
                                 class="fas fa-users"></i> Khách hàng</a></li>
                     @if (auth()->user()->isAdmin())
                         <li><a href="{{ route('admin.coupons') }}"
                                 class="{{ request()->routeIs('admin.coupons*') ? 'active' : '' }}"><i
                                     class="fas fa-tags"></i> Khuyến mãi</a></li>
                         <li><a href="{{ route('admin.users') }}"
                                 class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}"><i
                                     class="fas fa-user-shield"></i> Người dùng</a></li>
                     @endif
                     
                     <li><a href="{{ route('admin.reservations') }}"
                             class="{{ request()->routeIs('admin.reservations*') ? 'active' : '' }}"><i
                                 class="fas fa-calendar-check"></i> Đặt bàn</a></li>
                 </ul>
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
                    
                 </div>

                 <div class="header-right">
                     <details class="user-profile-dropdown">
                         <summary class="user-profile">
                             <div class="user-avatar">
                                 {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(auth()->user()->full_name ?? 'U', 0, 2)) }}
                             </div>
                             <div class="user-info">
                                 <h4>{{ auth()->user()->full_name ?? 'Người dùng' }}</h4>
                                 <p>{{ auth()->user()->isAdmin() ? 'Quản trị viên' : 'Nhân viên' }}</p>
                             </div>
                             <i class="fas fa-chevron-down"></i>
                         </summary>

                         <div class="user-dropdown-menu">
                             <form method="POST" action="{{ route('logout') }}">
                                 @csrf
                                 <button type="submit" class="user-dropdown-item">
                                     <i class="fas fa-sign-out-alt"></i>
                                     Đăng xuất
                                 </button>
                             </form>
                         </div>
                     </details>
                 </div>
             </div>

             <!-- Content Area -->
             <div class="content-area">
                 @yield('content')
             </div>
         </div>


 </body>

 </html>

