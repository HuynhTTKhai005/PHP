@extends('layouts.sincay')

@section('content')
    <div class="login p-t-100 p-b-100">
        <div class="login-wrapper">
            <div class="login-container">
                <div class="panel">

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <h1 class="login-title" style="background-color: orangered">
                            Đặt lại mật khẩu
                        </h1>

                        <p class="login-subtitle">
                            Nhập mật khẩu mới để hoàn tất quá trình
                        </p>

                        {{-- Lỗi tổng --}}
                        @if ($errors->any())
                            <div class="error-message" style="margin-bottom: 15px; text-align: center;">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        {{-- Email --}}
                        <div class="form-group">
                            <input type="email"
                                   class="form-input"
                                   name="email"
                                   value="{{ $email ?? old('email') }}"
                                   placeholder="Email"
                                   required>
                            <i class="fas fa-envelope input-icon"></i>
                        </div>

                        {{-- Mật khẩu mới --}}
                        <div class="form-group">
                            <input type="password"
                                   class="form-input"
                                   name="password"
                                   id="password"
                                   placeholder="Mật khẩu mới"
                                   required>
                            <i class="fas fa-lock input-icon"></i>

                            @error('password')
                                <div class="error-message" style="margin-top: 5px;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Xác nhận mật khẩu --}}
                        <div class="form-group">
                            <input type="password"
                                   class="form-input"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   placeholder="Xác nhận mật khẩu"
                                   required>
                            <i class="fas fa-lock input-icon"></i>
                        </div>

                        <button type="submit"
                                class="submit-btn"
                                style="width: 100%; cursor: pointer;">
                            Cập nhật mật khẩu
                        </button>
                    </form>

                    <div class="register-section"
                         style="text-align: center; margin-top: 25px;">
                        Quay lại
                        <a href="{{ route('login') }}"
                           class="register-btn"
                           style="font-weight: bold; color: #f64403;">
                            Đăng nhập
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

