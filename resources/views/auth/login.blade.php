@extends('layouts.pato')
@include('partials.sidebar')

@section('content')
    <!DOCTYPE html>
    <html lang="vi">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Đăng nhập - TechStore</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            :root {
                --primary: #eb4343;
                --primary-dark: #070709;
                --secondary: #0e0d11;
                --gray-200: #e5e7eb;
                --gray-500: #6b7280;
                --radius: 0.75rem;
                --radius-lg: 1rem;
                --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
                --transition: all 0.3s ease;
            }

            body {
                font-family: 'Inter', sans-serif;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .login-wrapper {
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 2rem 1rem;
                margin-top: 100px;
                height: 100%;
            }

            .login-container {
                width: 100%;
                max-width: 480px;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border-radius: var(--radius-lg);
                box-shadow: var(--shadow-lg);
                overflow: hidden;
                animation: fadeUp 0.8s ease-out;
            }

            @keyframes fadeUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }



            .brand-logo {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .logo-icon {
                width: 56px;
                height: 56px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.8rem;
                backdrop-filter: blur(10px);
            }

            .brand-name {
                font-size: 2rem;
                font-weight: 800;
            }
 

            

            .features {
                margin-top: 2rem;
                display: grid;
                gap: 1rem;
            }

            .feature {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 1rem;
                font-size: 0.95rem;
            }

            .feature-icon {
                width: 40px;
                height: 40px;
                background: rgba(255, 255, 255, 0.15);
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .panel {
                height: 100%;
                padding: 3rem 2.5rem;
            }

            .login-title {
                font-size: 1.8rem;
                font-weight: 700;
                text-align: center;
                margin-bottom: 0.5rem;
            }

            .login-subtitle {
                text-align: center;
                color: var(--gray-500);
                margin-bottom: 2rem;
            }

            .social-login {
                display: grid;
                gap: 0.75rem;
                margin-bottom: 1.5rem;
            }

            .social-btn {
                padding: 0.9rem;
                border: 1.5px solid var(--gray-200);
                border-radius: var(--radius);
                background: white;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
                font-weight: 500;
                transition: var(--transition);
            }

            .social-btn:hover {
                border-color: var(--primary);
                transform: translateY(-2px);
            }

            .divider {
                text-align: center;
                margin: 1.5rem 0;
                color: var(--gray-500);
            }



            .divider span {
                background: white;
                padding: 0 1rem;
            }

            .form-group {
                position: relative;
                margin-bottom: 1.25rem;
            }

            .form-input {
                width: 100%;
                padding: 1rem 1rem 1rem 3rem;
                border: 2px solid var(--gray-200);
                border-radius: var(--radius);
                font-size: 1rem;
                transition: var(--transition);
            }

            .form-input:focus {
                outline: none;
                border-color: var(--primary);
                box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            }

            .input-icon {
                position: absolute;
                left: 0rem;
                top: 50%;
                transform: translateY(-50%);
                color: var(--gray-500);
                pointer-events: none;
            }

            .form-input:focus+.input-icon {
                color: var(--primary);
            }

            .password-toggle {
                position: absolute;
                right: 1rem;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                cursor: pointer;
                color: var(--gray-500);
                font-size: 1.1rem;
            }

            .password-toggle:hover {
                color: var(--primary);
            }

            .form-options {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1rem;
                font-size: 0.9rem;
            }

            .submit-btn {
                width: 100%;
                padding: 1.1rem;
                background: var(--primary);
                color: white;
                border: none;
                border-radius: var(--radius);
                font-weight: 600;
                cursor: pointer;
                transition: var(--transition);
            }

            .submit-btn:hover {
                transform: translateY(-2px);
                box-shadow: var(--shadow-lg);
            }

            .register-section {
                text-align: center;
                margin-top: 1.5rem;
            }

            .register-btn {
                color: var(--primary);
                font-weight: 600;
            }
        </style>
    </head>

    <body>

        <div class="login-wrapper">
            <div class="login-container">
                <!-- Form đăng nhập (màu trắng) -->
                <div class="panel">
                    <form id="loginForm">
                        <h1 class="login-title">Đăng nhập</h1>
                        <p class="login-subtitle">Nhập email và mật khẩu để tiếp tục</p>

                        <div class="form-group">
                            <input type="email" class="form-input" placeholder="Email" required>
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" id="password" placeholder="Mật khẩu" required>
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle"><i class="fas fa-eye"></i></button>
                        </div>

                        <div class="form-options">
                            <label><input type="checkbox" style="margin-right:0.5rem;"> Ghi nhớ tôi</label>
                            <a href="#" style="color:var(--primary);">Quên mật khẩu?</a>
                        </div>

                        <button type="submit" class="submit-btn">Đăng nhập</button>
                    </form>

                    <div class="register-section">
                        Chưa có tài khoản? <a href="#" class="register-btn">Đăng ký ngay</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.querySelector('.password-toggle').addEventListener('click', function() {
                const input = document.getElementById('password');
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        </script>
    </body>

    </html>
@endsection
