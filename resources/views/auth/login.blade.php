@extends('layouts.sincay')

@section('content')
    <div class="login p-t-100 p-b-100">
        <div class="login-wrapper">
            <div class="login-container">
                <div class="panel">
                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                        @csrf

                        <h1 class="login-title" style=" background-color: orangered">ÄÄƒng nháº­p</h1>
                        <p class="login-subtitle">Nháº­p email vÃ  máº­t kháº©u Ä‘á»ƒ tiáº¿p tá»¥c</p>

                        {{-- Hiá»ƒn thá»‹ lá»—i chung náº¿u Ä‘Äƒng nháº­p tháº¥t báº¡i --}}
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
                            <input type="password" class="form-input" id="password" name="password" placeholder="Máº­t kháº©u"
                                required>
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')"
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
                                Ghi nhá»› tÃ´i
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" style="color: #666; text-decoration: none;">QuÃªn
                                    máº­t kháº©u?</a>
                            @endif
                        </div>

                        @if (session('status'))
                            <div style="color: #27ae60; margin-bottom: 15px; font-size: 14px; text-align: center;">
                                {{ session('status') }}
                            </div>
                        @endif

                        <button type="submit" class="submit-btn" style="width: 100%; cursor: pointer;">
                            ÄÄƒng nháº­p
                        </button>
                    </form>

                    <div class="register-section" style="text-align: center; margin-top: 25px;">
                        ChÆ°a cÃ³ tÃ i khoáº£n?
                        <a href="{{ route('register.form') }}" class="register-btn" style="font-weight: bold; color: #f64403;">
                            ÄÄƒng kÃ½ ngay
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

