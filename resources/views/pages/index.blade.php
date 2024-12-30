@extends('layouts.app')

@section('content')

<div class="container-fluid py-5">

    <!-- Content Section -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Form Section -->
            <div class="card shadow-lg rounded mb-5">
                <div class="card-header bg-primary py-3">
                    <div class="row align-items-center">
                        <!-- Menu Icon -->
                        <div class="col-2 col-md-1">
                            <button class="btn btn-outline-primary dropdown-toggle btn-lg" id="menuIcon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-list fs-4 text-light"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="menuIcon">
                                <li><a class="dropdown-item" href="{{ route('vehicle.index') }}">
                                    <i class="bi bi-truck me-2"></i> Vehicle Management
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('shipment.index') }}">
                                    <i class="bi bi-cloud-arrow-up me-2"></i> Upload Shipments
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('assigned-shipments.index') }}">
                                    <i class="bi bi-person-lines-fill me-2"></i> Assigned Shipments
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('completedShipments.index') }}">
                                    <i class="bi bi-check-circle me-2"></i> Completed Shipments
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('approval.index') }}">
                                    <i class="bi bi-person-check-fill me-2"></i> Approvals
                                </a></li>
                            </ul>
                        </div>

                        
                        <!-- Page Title -->
                        <div class="col text-center">
                            <h3 class="text-white fw-bold mb-0"> Driver Management</h3>
                            <p class="text-white-50 mb-0"><i class="bi bi-person-badge me-2"></i> Register New Driver</p>
                        </div>
                        
                    </div>
                </div>
            
              
                <div class="card-body">
                    <form method="POST" action="{{ route('driver.store') }}">
                        @csrf
                        <div class="row g-3">
                            <!-- Driver Name -->
                            <div class="col-md-6">
                                <label for="username" class="form-label fw-bold">
                                    <i class="bi bi-person"></i> Driver Name
                                </label>
                                <input type="text" class="form-control rounded-pill" name="username" placeholder="Enter driver name" required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold">
                                    <i class="bi bi-envelope"></i> Email
                                </label>
                                <input type="email" class="form-control rounded-pill @error('email') is-invalid @enderror" name="email" placeholder="Enter email" required>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
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
                                    <input type="text" class="form-control rounded-end-pill" name="phone" placeholder="Enter phone no."
                                    minlength="10" maxlength="10" pattern="\d{10}" required>
                                </div>
                            </div>

                            <!-- Helper -->
                            <div class="col-md-6">
                                <label for="helper" class="form-label fw-bold">
                                    <i class="bi bi-people"></i> Helper
                                </label>
                                <input type="text" class="form-control rounded-pill" name="helper" placeholder="Enter helper name">
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold">
                                    <i class="bi bi-info-circle"></i> Status
                                </label>
                                <select class="form-select rounded-pill" name="status" required>
                                    <option selected disabled>Select status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
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
            <div class="card shadow-lg rounded">
                <div class="card-body">
                    <h5 class="card-title text-center text-primary fw-bold">
                        <i class="bi-list-check"></i> Driver List
                    </h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Driver Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Helper</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($drivers as $key => $driver)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $driver->username }}</td>
                                    <td>{{ $driver->email }}</td>
                                    <td>{{ $driver->phone }}</td>
                                    <td>{{ $driver->helper }}</td>
                                    <td>
                                        <span class="badge {{ $driver->status === 'Active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $driver->status }}
                                        </span>
                                    </td>
                                    <td class="text-center gap-2">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('driver.edit', $driver->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('driver.destroy', $driver->id) }}" method="POST" class="d-inline">
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

@endsection
