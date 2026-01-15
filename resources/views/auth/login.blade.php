@extends('layouts.pato')

@section('content')
    <div class="login">
        <div class="login-wrapper">
            <div class="login-container">
                <div class="panel">
                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                        @csrf

                        <h1 class="login-title">Đăng nhập</h1>
                        <p class="login-subtitle">Nhập email và mật khẩu để tiếp tục</p>

                        <div class="form-group">
                            <input type="email" class="form-input" name="email" placeholder="Email"
                                value="{{ old('email') }}" required autofocus>
                            <i class="fas fa-envelope input-icon"></i>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-input" id="password" name="password" placeholder="Mật khẩu"
                                required>
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye"></i>
                            </button>
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-options">
                            <label>
                                <input type="checkbox" name="remember">
                                Ghi nhớ tôi
                            </label>
                            <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
                        </div>

                        @if(session('status'))
                            <div style="color: #27ae60; margin-bottom: 15px; font-size: 14px;">
                                {{ session('status') }}
                            </div>
                        @endif

                        <button type="submit" class="submit-btn">
                            Đăng nhập
                        </button>
                    </form>

                    <div class="register-section">
                        Chưa có tài khoản?
                        <a href="{{ route('register') }}" class="register-btn">Đăng ký ngay</a>
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