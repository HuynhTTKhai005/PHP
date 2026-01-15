@extends('layouts.pato')

@section('title', 'Đăng nhập - Nhà hàng Sincay')

{{-- Ẩn sidebar mobile nếu muốn trang login sạch hơn --}}
@push('styles')
<style>
    body { background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('assets/images/bg-login.jpg') }}') center/cover no-repeat fixed; }
    .sidebar { display: none !important; }
    .btn-show-sidebar { display: none !important; }
</style>
@endpush

@section('content')
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-l-50 p-r-50 p-t-77 p-b-30">
            <form method="POST" action="{{ route('login') }}" class="login100-form validate-form">
                @csrf

                <span class="login100-form-title p-b-55" style="font-size: 34px; color: #b89d6b;">
                    Đăng nhập thành viên
                </span>

                <span class="login100-form-subtitle p-b-40">
                    Chào mừng bạn quay lại Nhà hàng Sincay
                </span>

                <!-- Email -->
                <div class="wrap-input100 validate-input m-b-16">
                    <input class="input100 @error('email') is-invalid @enderror"
                           type="email" name="email" placeholder="Email của bạn" required autofocus
                           value="{{ old('email') }}">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100"><i class="fa fa-envelope"></i></span>
                </div>
                @error('email')
                    <div class="text-danger text-center m-b-10">{{ $message }}</div>
                @enderror

                <!-- Password -->
                <div class="wrap-input100 validate-input m-b-16">
                    <input class="input100 @error('password') is-invalid @enderror"
                           type="password" name="password" placeholder="Mật khẩu" required>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100"><i class="fa fa-lock"></i></span>
                </div>
                @error('password')
                    <div class="text-danger text-center m-b-10">{{ $message }}</div>
                @enderror

                <!-- Options -->
                <div class="flex-sb-m w-full p-t-3 p-b-24">
                    <div class="contact100-form-checkbox">
                        <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember">
                        <label class="label-checkbox100" for="ckb1">Ghi nhớ đăng nhập</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="txt1" style="color: #b89d6b;">
                            Quên mật khẩu?
                        </a>
                    @endif
                </div>

                <!-- Nút đăng nhập -->
                <div class="container-login100-form-btn m-t-17">
                    <button type="submit" class="login100-form-btn" style="background: linear-gradient(135deg, #b89d6b, #d4af37);">
                        Đăng nhập
                    </button>
                </div>

                <!-- Đăng ký -->
                <div class="text-center p-t-50">
                    <span class="txt1">Chưa có tài khoản?</span>
                    <a class="txt2" href="{{ route('register') }}" style="color: #b89d6b; font-weight: bold;">
                        Đăng ký ngay
                    </a>
                </div>

                <!-- Demo account -->
                <div class="text-center p-t-20">
                    <small style="color: #aaa;">
                        Demo khách: khach@sincay.com / 12345678
                    </small>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection