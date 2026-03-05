@extends('layouts.pato')

@section('content')
    <div class="login p-t-100 p-b-100">
        <div class="login-wrapper">
            <div class="login-container">
                <div class="panel">
                    <form id="forgotPasswordForm" method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <h1 class="login-title" style=" background-color: orangered">Quên mật khẩu</h1>
                        <p class="login-subtitle">Nhập email để nhận link đặt lại mật khẩu</p>

                        {{-- Hiển thị trạng thái thành công --}}
                        @if (session('status'))
                            <div class="success-message" style="color: #27ae60; margin-bottom: 15px; text-align: center;">
                                {{ session('status') }}
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

                        <button type="submit" class="submit-btn" style="width: 100%; cursor: pointer;">
                            Gửi link đặt lại mật khẩu
                        </button>
                    </form>

                    <div class="register-section" style="text-align: center; margin-top: 25px;">
                        Quay lại
                        <a href="{{ route('login') }}" class="register-btn" style="font-weight: bold; color: #f64403;">
                            Đăng nhập
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
