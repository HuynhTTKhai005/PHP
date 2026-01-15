@extends('layouts.pato')

@section('content')
    <div class="login">
        <div class="login-wrapper">
            <div class="login-container">
                <div class="panel">
                    <form id="registerForm" method="POST" action="{{ route('register') }}">
                        @csrf

                        <h1 class="login-title">Đăng ký tài khoản</h1>
                        <p class="login-subtitle">Tạo tài khoản mới để đặt món nhanh hơn</p>

                        <div class="form-group">
                            <input type="text" class="form-input" name="full_name" placeholder="Họ và tên"
                                value="{{ old('full_name') }}" required autofocus>
                            <i class="fas fa-user input-icon"></i>
                            @error('full_name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-input" name="email" placeholder="Email"
                                value="{{ old('email') }}" required>
                            <i class="fas fa-envelope input-icon"></i>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="tel" class="form-input" name="phone" placeholder="Số điện thoại"
                                value="{{ old('phone') }}" required>
                            <i class="fas fa-phone input-icon"></i>
                            @error('phone')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-input" id="password" name="password" placeholder="Mật khẩu"
                                required>
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-input" id="password_confirmation"
                                name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <button type="submit" class="submit-btn">
                            Đăng ký ngay
                        </button>
                    </form>

                    <div class="register-section">
                        Đã có tài khoản?
                        <a href="{{ route('login') }}" class="register-btn">Đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const field = document.getElementById(id);
            const icon = field.parentElement.querySelector('.password-toggle i');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
@endsection