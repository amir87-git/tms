@extends('layouts.app')

@section('content')

    <!-- Header Section with Project Title -->
    <div class="container-fluid p-4 text-center bg-light">
        <img src="{{ URL('images/msa.png') }}" alt="Header img" class="img-fluid" style="height: auto; max-height: 120px;">
        <h1 class="text-primary mt-3 mb-1 fw-bold">MSA Transport Management System</h1>
        <p class="mb-2 text-danger" style="font-size: 0.9rem;">Moving towards the right path >>></p>
    </div>

    <!-- Login Form Section -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-light">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-3 fw-bold text-primary">Login</h3>

                        <form method="POST" action="{{ route('login.store') }}">
                            @csrf

                            <!-- Email Input -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope-fill text-primary me-1"></i>Email
                                </label>
                                <input type="email" class="form-control form-control-sm" id="email" name="email" required autofocus placeholder="Enter your email" aria-label="Email Address">
                            </div>

                            <!-- Password Input -->
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label">
                                    <i class="bi bi-lock-fill text-primary me-1"></i>Password
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-sm" id="password" name="password" required placeholder="Enter your password" aria-label="Password">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="toggle-password" style="border-left: none;">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>
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
