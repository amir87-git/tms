@extends('layouts.app')

@section('content')
    <!-- Header Section with Project Title -->
    <div class="container-fluid p-3 p-md-4 text-center bg-light">
        <img src="{{ URL('images/msa.png') }}" alt="Header img" class="img-fluid" style="height: auto; max-height: 100px;">
        <h1 class="text-primary mt-2 mt-md-3 mb-1 fw-bold" style="font-size: 1.5rem; font-size: clamp(1.5rem, 4vw, 2rem);">MSA Transport Management System</h1>
        <p class="mb-2 text-danger" style="font-size: 0.8rem; font-size: clamp(0.8rem, 2.5vw, 0.9rem);">Moving towards the right path >>></p>
    </div>

    <!-- Login Form Section -->
    <div class="container mt-3 mt-md-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-sm border-light">
                    <div class="card-body p-3 p-md-4">
                        <h3 class="text-center mb-3 fw-bold text-primary" style="font-size: 1.25rem; font-size: clamp(1.25rem, 3.5vw, 1.5rem);">Login</h3>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Input -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope-fill text-primary me-1"></i>Email
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email">
                                
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label">
                                    <i class="bi bi-lock-fill text-primary me-1"></i>Password
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Enter your password">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="toggle-password" style="border-left: none;">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-secondary" for="remember">Remember Me</label>
                            </div>

                            <!-- Display Errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger mb-3 p-2" role="alert">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 py-2 mt-3 btn-sm">
                                <span class="spinner-border spinner-border-sm me-1 d-none" id="login-loader"></span> Login
                            </button>

                            <!-- Forgot Password -->
                            <!-- @if (Route::has('password.request'))
                                <div class="text-center mt-3">
                                    <a class="text-decoration-none text-primary" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            @endif -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Show/Hide Password -->
    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            }
        });
    </script>
@endsection
