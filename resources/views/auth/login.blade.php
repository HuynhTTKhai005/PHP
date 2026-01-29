@extends('layouts.pato')

@section('content')
    <div class="login p-t-100 p-b-100">
        <div class="login-wrapper">
            <div class="login-container">
                <div class="panel">
                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                        @csrf

                        <h1 class="login-title">Đăng nhập</h1>
                        <p class="login-subtitle">Nhập email và mật khẩu để tiếp tục</p>

                        {{-- Hiển thị lỗi chung nếu đăng nhập thất bại --}}
                        @if ($errors->has('login_error'))
                            <div class="error-message" style="color: #e74c3c; margin-bottom: 15px; text-align: center;">
                                {{ $errors->first('login_error') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <input type="email" class="form-input" name="email" placeholder="Email"
                                value="{{ old('email') }}" required autofocus>
                            <i class="fas fa-envelope input-icon"></i>

                            @error('email')
                                <div class="error-message" style="color: #e74c3c; font-size: 13px; margin-top: 5px;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-input" id="password" name="password" placeholder="Mật khẩu"
                                required>
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" onclick="togglePassword()"
                                style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </button>

                            @error('password')
                                <div class="error-message" style="color: #e74c3c; font-size: 13px; margin-top: 5px;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-options"
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                                <input type="checkbox" name="remember">
                                Ghi nhớ tôi
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" style="color: #666; text-decoration: none;">Quên
                                    mật khẩu?</a>
                            @endif
                        </div>

                        @if (session('status'))
                            <div style="color: #27ae60; margin-bottom: 15px; font-size: 14px; text-align: center;">
                                {{ session('status') }}
                            </div>
                        @endif

                        <button type="submit" class="submit-btn" style="width: 100%; cursor: pointer;">
                            Đăng nhập
                        </button>
                    </form>

                    <div class="register-section" style="text-align: center; margin-top: 25px;">
                        Chưa có tài khoản?
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="register-btn"
                                style="font-weight: bold; color: #f64403;">Đăng ký ngay</a>
                        @else
                            <span style="color: #999;">(Tính năng đăng ký đang khóa)</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle i');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
@endsection
