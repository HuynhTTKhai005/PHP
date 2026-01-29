<header>
    <!-- Header desktop -->
    <div class="header_menu_wrap">
        <div class="container h-full">
            <div class="header_wrap ">
                <!-- Logo -->
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/images/icons/logo.png') }}" alt="Sincay Logo" height="60">
                    </a>
                </div>

                <!-- Menu -->
                <div class="menu-wrapper">
                    <nav class="nav-menu">
                        <ul class="nav-list">
                            <li>
                                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Trang
                                    chủ</a>
                            </li>

                            <li>
                                <a href="{{ url('menu') }}" class="{{ request()->is('menu') ? 'active' : '' }}">Thực
                                    đơn</a>
                            </li>

                            {{-- <li>
                                <a href="{{ url('reservation') }}"
                                    class="{{ request()->is('reservation') ? 'active' : '' }}">Đặt bàn</a>
                            </li> --}}

                            <li>
                                <a href="{{ url('gallery') }}"
                                    class="{{ request()->is('gallery') ? 'active' : '' }}">Thư viện</a>
                            </li>

                            <li>
                                <a href="{{ url('about') }}" class="{{ request()->is('about') ? 'active' : '' }}">Giới
                                    thiệu</a>
                            </li>

                            <li>
                                <a href="{{ url('blog') }}"
                                    class="{{ request()->is('blog') ? 'active' : '' }}">Blog</a>
                            </li>

                            <li>
                                <a href="{{ url('contact') }}"
                                    class="{{ request()->is('contact') ? 'active' : '' }}">Liên hệ</a>
                            </li>
                        </ul>

                    </nav>
                </div>

                <!--   Login/Logout -->
                <div class="social d-flex ">
                    @auth
                        <!-- ĐÃ ĐĂNG NHẬP -->
                        <div class="usered">
                            <a href="javascript:void(0)" class="login-btn" id="userDropdown" data-toggle="dropdown">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span
                                    class="me-2 d-none d-md-inline">{{ Auth::user()->full_name ?? Auth::user()->email }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <a class="dropdown-item text-black" href="{{ route('profile') }}">
                                    <i class="fa fa-user-edit"></i> Hồ sơ cá nhân
                                </a>
                                <a class="dropdown-item text-black" href="{{ route('checkout') ?? '#' }}">
                                    <i class="fa fa-shopping-bag"></i> Đơn hàng của tôi
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
                        <!-- CHƯA ĐĂNG NHẬP -->
                        <a href="{{ route('login') }}" class="login-btn ">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span class="ms-2 d-none d-md-inline ">Đăng nhập</span>
                        </a>
                    @endauth

                    <!-- Giỏ hàng -->
                    <div class="cart-wrapitem">
                        <a href="{{ route('cart') }}" class="cart-hitem">
                            <i class="bi bi-cart "></i>

                            @php
                                $cartCount = collect(session('cart', []))->sum('quantity');
                            @endphp

                            @if ($cartCount > 0)
                                <span class="cart-badge">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</header>
