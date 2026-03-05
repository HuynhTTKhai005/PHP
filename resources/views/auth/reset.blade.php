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
                            Äáº·t láº¡i máº­t kháº©u
                        </h1>

                        <p class="login-subtitle">
                            Nháº­p máº­t kháº©u má»›i Ä‘á»ƒ hoÃ n táº¥t quÃ¡ trÃ¬nh
                        </p>

                        {{-- Lá»—i tá»•ng --}}
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

                        {{-- Máº­t kháº©u má»›i --}}
                        <div class="form-group">
                            <input type="password"
                                   class="form-input"
                                   name="password"
                                   id="password"
                                   placeholder="Máº­t kháº©u má»›i"
                                   required>
                            <i class="fas fa-lock input-icon"></i>

                            @error('password')
                                <div class="error-message" style="margin-top: 5px;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- XÃ¡c nháº­n máº­t kháº©u --}}
                        <div class="form-group">
                            <input type="password"
                                   class="form-input"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   placeholder="XÃ¡c nháº­n máº­t kháº©u"
                                   required>
                            <i class="fas fa-lock input-icon"></i>
                        </div>

                        <button type="submit"
                                class="submit-btn"
                                style="width: 100%; cursor: pointer;">
                            Cáº­p nháº­t máº­t kháº©u
                        </button>
                    </form>

                    <div class="register-section"
                         style="text-align: center; margin-top: 25px;">
                        Quay láº¡i
                        <a href="{{ route('login') }}"
                           class="register-btn"
                           style="font-weight: bold; color: #f64403;">
                            ÄÄƒng nháº­p
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

