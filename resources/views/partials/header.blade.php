<header>
    <!-- Header desktop -->
    <div class="wrap-menu-header gradient1 trans-0-4">
        <div class="container h-full">
            <div class="wrap_header trans-0-3">
                <!-- Logo -->
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="assets/images/icons/logo.png" alt="IMG-LOGO"
                            data-logofixed="assets/images/icons/logo2.png">
                    </a>
                </div>

                <!-- Menu -->
                <div class="wrap_menu p-l-45 p-l-0-xl">
                    <nav class="menu">
                        <ul class="main_menu">
                            <li>
                                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Trang chủ</a>
                            </li>

                            <li>
                                <a href="{{ url('menu') }}"
                                    class="{{ request()->is('menu') ? 'active' : '' }}">Thực đơn</a>
                            </li>

                            <li>
                                <a href="{{ url('gallery') }}"
                                    class="{{ request()->is('gallery') ? 'active' : '' }}">Thư viện</a>
                            </li>

                            <li>
                                <a href="{{ url('about') }}"
                                    class="{{ request()->is('about') ? 'active' : '' }}">Giới thiệu</a>
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

                <!-- Social -->
                <div class="social d-flex  flex-l-m p-r-20">
                    <a href="{{ url('login') }}" class="hlogin-btn">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </a>
                    <div class="header-cart-wrapitem">
                        <a href="{{ route('cart') }}" class="header-cart-item">
                            <i class="bi bi-cart fs-20 "></i>

                            @php
                                $cartCount = collect(session('cart', []))->sum('quantity');
                            @endphp

                            @if ($cartCount > 0)
                                <span class="header-cart-badge">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </div>

                    <button class="btn-show-sidebar m-l-33 trans-0-4"></button>
                </div> <!-- Giỏ hàng ở header -->


            </div>
        </div>
    </div>
</header>
