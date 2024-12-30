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
                        <!-- Menu Icon on the Left -->
                        <div class="col-2 col-md-1">
                            <button class="btn btn-outline-primary dropdown-toggle btn-lg" id="menuIcon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-list fs-4 text-light"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="menuIcon">
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
                                <li><a class="dropdown-item" href="{{ route('driver.index') }}">
                                    <i class="bi bi-person-badge me-2"></i> Driver Management
                                </a></li>
                            </ul>
                        </div>

                        <!-- Page Title -->
                        <div class="col-8 col-md-10 text-center">
                            <h3 class="text-white fw-bold mb-0">Vehicle Management</h3>
                            <p class="text-white-50 mb-0"><i class="bi bi-truck"></i> Register New Vehicle</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('vehicle.store') }}">
                        @csrf
                        <div class="row g-3">
                            <!-- Vehicle Type -->
                            <div class="col-md-6">
                                <label for="vehicle_typ" class="form-label fw-bold">
                                    <i class="bi bi-truck"></i> Vehicle Type
                                </label>
                                <select id="vehicle_typ" class="form-select rounded-pill" name="vehicle_typ" required>
                                    <option selected disabled>Select vehicle type</option>
                                    <option value="prime_mover">Prime Mover</option>
                                    <option value="lorry">Lorry</option>
                                </select>
                            </div>

                            <!-- Vehicle Number -->
                            <div class="col-md-6">
                                <label for="vehicle_no" class="form-label fw-bold">
                                    <i class="bi bi-list-ol"></i> Vehicle No
                                </label>
                                <input type="text" id="vehicle_no" class="form-control rounded-pill @error('vehicle_no') is-invalid @enderror" name="vehicle_no" placeholder="Enter vehicle no." required>
                                @error('vehicle_no')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Trailer Number -->
                            <div class="col-md-6">
                                <label for="trailer_no" class="form-label fw-bold">
                                    <i class="bi bi-123"></i> Trailer No
                                </label>
                                <input type="text" id="trailer_no" class="form-control rounded-pill @error('trailer_no') is-invalid @enderror" name="trailer_no" placeholder="Enter trailer no.">
                                @error('trailer_no')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Start Meter Reading -->
                            <div class="col-md-6">
                                <label for="str_mtr_rdng" class="form-label fw-bold">
                                    <i class="bi bi-speedometer2"></i> Start Meter Reading
                                </label>
                                <input type="text" id="str_mtr_rdng" class="form-control rounded-pill" name="str_mtr_rdng" placeholder="Enter start meter reading">
                            </div>

                            <!-- End Meter Reading -->
                            <div class="col-md-6">
                                <label for="end_mtr_rdng" class="form-label fw-bold">
                                    <i class="bi bi-speedometer"></i> End Meter Reading
                                </label>
                                <input type="text" id="end_mtr_rdng" class="form-control rounded-pill" name="end_mtr_rdng" placeholder="Enter end meter reading">
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold">
                                    <i class="bi bi-info-circle"></i> Status
                                </label>
                                <select id="status" class="form-select rounded-pill" name="status" required>
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
                    <i class="bi-list-check"></i> Vehicle List
                </h5>
                <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Vehicle Type</th>
                                    <th>Vehicle No</th>
                                    <th>Trailer No</th>
                                    <th>Start Meter Reading</th>
                                    <th>End Meter Reading</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vehicles as $key => $vehicle)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $vehicle->vehicle_typ }}</td>
                                    <td>{{ $vehicle->vehicle_no }}</td>
                                    <td>{{ $vehicle->trailer_no }}</td>
                                    <td>{{ $vehicle->str_mtr_rdng }}</td>
                                    <td>{{ $vehicle->end_mtr_rdng }}</td>
                                    <td>
                                        <span class="badge {{ strtolower($vehicle->status) === 'active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($vehicle->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('vehicle.edit', $vehicle->id) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center">
                                                <i class="bi bi-pencil me-1"></i> Edit
                                            </a>
                                            <!-- Delete Button -->
                                            <form action="{{ route('vehicle.destroy', $vehicle->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center">
                                                    <i class="bi bi-trash me-1"></i> Delete
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
