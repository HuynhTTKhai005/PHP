@extends('layouts.sincay')

@section('content')
    <div class="login">
        <div class="login-wrapper">
            <div class="login-container">
                <div class="panel">
                    <form id="registerForm" method="POST" action="{{ route('register.submit') }}">
                        @csrf

                        <h1 class="login-title">ÄÄƒng kÃ½ tÃ i khoáº£n</h1>
                        <p class="login-subtitle">Táº¡o tÃ i khoáº£n má»›i Ä‘á»ƒ Ä‘áº·t mÃ³n nhanh hÆ¡n</p>

                        <div class="form-group">
                            <input type="text" class="form-input" name="full_name" placeholder="Há» vÃ  tÃªn"
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
                            <input type="tel" class="form-input" name="phone" placeholder="Sá»‘ Ä‘iá»‡n thoáº¡i"
                                value="{{ old('phone') }}" required>
                            <i class="fas fa-phone input-icon"></i>
                            @error('phone')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-input" id="password" name="password" placeholder="Máº­t kháº©u"
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
                                name="password_confirmation" placeholder="XÃ¡c nháº­n máº­t kháº©u" required>
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <button type="submit" class="submit-btn">
                            ÄÄƒng kÃ½ ngay
                        </button>
                    </form>

                    <div class="register-section">
                        ÄÃ£ cÃ³ tÃ i khoáº£n?
                        <a href="{{ route('login') }}" class="register-btn">ÄÄƒng nháº­p</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

