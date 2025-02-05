@extends('layouts.app')

@section('content')

<!-- Logout Button -->
<div class="text-end mt-3 me-3">
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-danger btn-sm rounded-pill">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>
</div>

<!-- Main Content -->
<div class="container-fluid py-5">

    <!-- Content Section -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Form Section -->
            <div class="card shadow-lg rounded mb-5 animate__animated animate__fadeIn">
                <!-- Page Title -->
                <div class="card-header bg-primary text-center text-white fw-bold">
                    <h3><strong>Manager Management</strong></h3>
                    <p><i class="bi bi-person-plus"></i> Register New Manager</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('manager.store') }}">
                        @csrf
                        <div class="row g-3">
                            <!-- Manager Name -->
                            <div class="col-md-6">
                                <label for="username" class="form-label fw-bold">
                                    <i class="bi bi-person"></i> Manager Name
                                </label>
                                <input type="text" class="form-control rounded-pill" name="username" placeholder="Enter manager name" required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold">
                                    <i class="bi bi-envelope"></i> Email
                                </label>
                                <input type="email" class="form-control rounded-pill" name="email" placeholder="Enter email" required>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-bold">
                                    <i class="bi bi-key"></i> Password
                                </label>
                                <input type="password" class="form-control rounded-pill" name="password" placeholder="Enter password" required>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-bold">
                                    <i class="bi bi-telephone"></i> Phone
                                </label>
                                <div class="input-group">
                                    <span class="text-muted input-group-text rounded-start-pill"><i class="fa fa-phone"></i>+94</span>
                                    <input type="text" class="form-control rounded-end-pill" name="phone" placeholder="Enter phone no." required>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill">
                                    <i class="bi bi-check-circle"></i> Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Section -->
            <div class="card shadow-lg rounded animate__animated animate__fadeInUp">
                <div class="card-body">
                    <h5 class="card-title text-center text-primary fw-bold">
                        <i class="bi-list-check"></i> Manager List
                    </h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Manager Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($managers as $key => $manager)
                                <tr class="animate__animated animate__fadeIn">
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $manager->username }}</td>
                                    <td>{{ $manager->email }}</td>
                                    <td>{{ $manager->phone }}</td>
                                    <td class="text-center gap-2">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('manager.edit', $manager->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('manager.destroy', $manager->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Add Animate.css for Animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<!-- Custom Styles -->
<style>
    /* Custom Animations */
    .animate__animated {
        animation-duration: 0.5s;
    }

    /* Hover Effects for Buttons */
    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: #fff;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    /* Table Row Hover Effect */
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .card-header h3 {
            font-size: 1.5rem;
        }

        .card-header p {
            font-size: 0.9rem;
        }

        .btn {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
    }
</style>

@endsection
