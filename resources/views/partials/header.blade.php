<header>
    <div class="header_menu_wrap">
        <div class="container h-full">
            <div class="header_wrap">
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/images/icons/logo.png') }}" alt="Sincay Logo" height="60">
                    </a>
                </div>

                <div class="menu-wrapper">
                    <nav class="nav-menu">
                        <ul class="nav-list">
                            <li>
                                <a href="{{ url('/') }}"
                                    class="{{ request()->routeIs('home') ? 'active' : '' }}">Trang chủ</a>
                            </li>
                            <li>
                                <a href="{{ url('menu') }}"
                                    class="{{ request()->routeIs('menu') || request()->routeIs('menu.show') ? 'active' : '' }}">Thực
                                    đơn</a>
                            </li>
                            <li>
                                <a href="{{ url('gallery') }}"
                                    class="{{ request()->routeIs('gallery') ? 'active' : '' }}">Thư viện</a>
                            </li>
                            <li>
                                <a href="{{ url('about') }}"
                                    class="{{ request()->routeIs('about') ? 'active' : '' }}">Giới thiệu</a>
                            </li>
                            <li>
                                <a href="{{ url('blog') }}"
                                    class="{{ request()->routeIs('blog') ? 'active' : '' }}">Blog</a>
                            </li>
                            <li>
                                <a href="{{ url('contact') }}"
                                    class="{{ request()->routeIs('contact') ? 'active' : '' }}">Liên hệ</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="social d-flex">
                    @auth
                        <div class="usered dropdown">
                            <a href="javascript:void(0)" class="login-btn dropdown-toggle" id="userDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span
                                    class="me-2 d-none d-md-inline">{{ Auth::user()->full_name ?? Auth::user()->email }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <a class="dropdown-item text-black" href="{{ route('profile') }}">
                                    <i class="fa fa-user-edit"></i> Hồ sơ cá nhân
                                </a>
                                <a class="dropdown-item text-black" href="{{ route('my-orders') }}">
                                    <i class="fa fa-shopping-bag"></i> Đơn hàng của tôi
                                </a>
                                <a class="dropdown-item text-black" href="{{ route('wishlist.index') }}">
                                    <i class="fa fa-heart"></i> Danh sách yêu thích
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fa fa-sign-out-alt"></i> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="login-btn">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span class="ms-2 d-none d-md-inline">Đăng nhập</span>
                        </a>
                    @endauth

                    <div class="cart-wrapitem">
                        <a href="{{ route('cart') }}" class="cart-hitem">
                            <i class="bi bi-cart"></i>
                            @if ($cartCount > 0)
                                <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
