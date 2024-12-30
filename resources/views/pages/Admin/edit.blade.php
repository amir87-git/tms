@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <h3 class="card-header rounded bg-primary text-center text-white fw-bold">
                    <i class="bi bi-person me-2"></i> Edit Manager
                </h3>
            </div>

            <!-- Form Section -->
            <div class="card shadow-sm rounded p-4 bg-light mb-4">
                <form method="POST" action="{{ route('manager.update', $managers->id) }}">
                    @csrf
                    @method("PATCH")
                    <div class="row">
                        <!-- Manager Name -->
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label fw-bold">
                                <i class="bi bi-person"></i> Manager Name
                            </label>
                            <input type="text" class="form-control rounded-pill" name="username" value="{{ $managers->username }}" placeholder="Enter manager name">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-bold">
                                <i class="bi bi-envelope"></i> Email
                            </label>
                            <input type="email" class="form-control rounded-pill" name="email" value="{{ $managers->email }}" placeholder="Enter email">
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-bold">
                                <i class="bi bi-key"></i> Password
                            </label>
                            <input type="password" class="form-control rounded-pill" name="password" placeholder="Enter password (Leave empty to keep current)">
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label fw-bold">
                                <i class="bi bi-telephone"></i> Phone
                            </label>
                            <input type="text" class="form-control rounded-pill" name="phone" value="{{ $managers->phone }}" placeholder="Enter phone number">
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 text-end ">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 px-5">
                            <i class="bi bi-save me-2"></i>Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
