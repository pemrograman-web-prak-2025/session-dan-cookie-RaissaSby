@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-center">
                    <i class="fas fa-sign-in-alt me-2"></i>Login to TaskReminder
                </h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Input -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold text-dark">
                            <i class="fas fa-envelope me-2 text-primary"></i>Email Address
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Enter your email address"
                               required 
                               autocomplete="email" 
                               autofocus>
                        @error('email')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold text-dark">
                            <i class="fas fa-lock me-2 text-primary"></i>Password
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Enter your password"
                               required 
                               autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="remember" 
                                   id="remember" 
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-dark fw-semibold" for="remember">
                                <i class="fas fa-remember me-1 text-success"></i>Ingatkan Saya / Remember Me
                            </label>
                        </div>
                        <div class="form-text text-muted ms-4">
                            <i class="fas fa-info-circle me-1 text-info"></i>
                            <strong>Jika dicentang:</strong> Tetap login meski browser ditutup (30 hari)<br>
                            <strong>Jika tidak dicentang:</strong> Harus login ulang saat browser ditutup
                        </div>
                    </div>

                    <!-- Login Button -->
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Login ke Akun
                        </button>
                    </div>

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-muted mb-2">Belum punya akun?</p>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus me-2"></i>Buat Akun Baru
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.form-control {
    border-radius: 8px;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-check-input:checked {
    background-color: #10b981;
    border-color: #10b981;
}

.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}

.fa-remember:before {
    content: "🔒";
}
</style>
@endsection