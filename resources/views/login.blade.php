@extends('layouts.app')

@section('title', 'Login - FaceAbsen')

@section('styles')
<style>
    .login-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .login-card {
        background: rgba(30, 30, 30, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 20px;
        padding: 3rem;
        max-width: 450px;
        width: 100%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        animation: slideUp 0.5s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .login-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #3B82F6, #2563EB);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
    }

    .login-icon i {
        font-size: 2.5rem;
        color: #fff;
    }

    .login-header h1 {
        color: #3B82F6;
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
    }

    .login-header p {
        color: #9CA3AF;
        font-size: 0.95rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        color: #D1D5DB;
        font-weight: 500;
        margin-bottom: 0.7rem;
        font-size: 0.95rem;
    }

    .form-label i {
        margin-right: 0.5rem;
        color: #3B82F6;
    }

    .input-wrapper {
        position: relative;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        background: rgba(255, 255, 255, 0.05);
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-input:focus {
        outline: none;
        border-color: #3B82F6;
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .form-input::placeholder {
        color: #6B7280;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #3B82F6;
        font-size: 1.1rem;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #9CA3AF;
        cursor: pointer;
        font-size: 1.1rem;
        padding: 0.5rem;
        transition: color 0.3s;
    }

    .password-toggle:hover {
        color: #3B82F6;
    }

    .btn-login {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #3B82F6, #2563EB);
        border: none;
        border-radius: 12px;
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.7rem;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(59, 130, 246, 0.4);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .btn-login i {
        font-size: 1.2rem;
    }

    .alert {
        padding: 1rem 1.2rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.15);
        border: 1px solid rgba(34, 197, 94, 0.3);
        color: #22C55E;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #EF4444;
    }

    .alert i {
        font-size: 1.2rem;
    }

    .login-footer {
        text-align: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .login-footer p {
        color: #9CA3AF;
        font-size: 0.9rem;
        margin-bottom: 0.7rem;
    }

    .login-footer a {
        color: #3B82F6;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }

    .login-footer a:hover {
        color: #60A5FA;
        text-decoration: underline;
    }

    .default-credentials {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1.5rem;
        text-align: center;
    }

    .default-credentials p {
        color: #D1D5DB;
        font-size: 0.85rem;
        margin: 0 0 0.5rem 0;
    }

    .default-credentials code {
        background: rgba(0, 0, 0, 0.3);
        padding: 0.3rem 0.7rem;
        border-radius: 6px;
        color: #3B82F6;
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .login-card {
            padding: 2rem 1.5rem;
        }

        .login-header h1 {
            font-size: 1.5rem;
        }

        .login-icon {
            width: 70px;
            height: 70px;
        }

        .login-icon i {
            font-size: 2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h1>Login</h1>
            <p>Masuk untuk mendapatkan fitur Dashboard</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if($errors->has('login'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ $errors->first('login') }}</span>
        </div>
        @endif

        <form action="{{ route('login.authenticate') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-user"></i> Username
                </label>
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input 
                        type="text" 
                        name="username" 
                        class="form-input" 
                        placeholder="Masukkan username"
                        value="{{ old('username') }}"
                        required
                        autofocus
                    >
                </div>
                @error('username')
                    <small style="color: #EF4444; font-size: 0.85rem; margin-top: 0.5rem; display: block;">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-lock"></i> Password
                </label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input 
                        type="password" 
                        name="password_login" 
                        id="passwordInput"
                        class="form-input" 
                        placeholder="Masukkan password"
                        required
                    >
                    <button type="button" class="password-toggle" id="togglePassword">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
                @error('password_login')
                    <small style="color: #EF4444; font-size: 0.85rem; margin-top: 0.5rem; display: block;">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                Login Dashboard
            </button>
        </form>
        
        <div class="login-footer">
            <p>Kembali ke halaman utama?</p>
            <a href="{{ route('absen.index') }}">
                <i class="fas fa-arrow-left"></i> Halaman Absensi
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Toggle Password Visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('passwordInput');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        if(type === 'password') {
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        } else {
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        }
    });

    // Auto hide success/error alert after 5 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.3s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        });
    }, 5000);
</script>
@endsection