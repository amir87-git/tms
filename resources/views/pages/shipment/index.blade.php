@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">

    <!-- Form Section -->
    <div class="row justify-content-center">
        <div class="col-md-8">

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
                                <li><a class="dropdown-item" href="{{ route('assigned-shipments.index') }}">
                                    <i class="bi bi-person-lines-fill me-2"></i> Assigned Shipments
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('completedShipments.index') }}">
                                    <i class="bi bi-check-circle me-2"></i> Completed Shipments
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('driver.index') }}">
                                    <i class="bi bi-person-badge me-2"></i> Driver Management
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('approval.index') }}">
                                    <i class="bi bi-person-check-fill me-2"></i> Approvals
                                </a></li>
                            </ul>
                        </div>

                        
                        <!-- Page Title -->
                        <div class="col-8 col-md-10 text-center">
                            <h3 class="text-white fw-bold mb-0">Create New Shipment</h3>
                            <p class="text-white-50 mb-0"><i class="bi-cloud-upload"></i> Upload Shipment Details</p>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    <form method="POST" action="{{ route('shipment.store') }}">
                        @csrf
                        <div class="row g-4">
                            <!-- Client Name -->
                            <div class="col-md-6">
                                <label for="client_name" class="form-label fw-bold">
                                    <i class="bi bi-person"></i> Client Name
                                </label>
                                <input type="text" class="form-control rounded-pill" name="client_name" placeholder="Enter client name" required>
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

                            <!-- Shipment Type -->
                            <div class="col-md-6">
                                <label for="type" class="form-label fw-bold">
                                    <i class="bi bi-tags"></i> Type
                                </label>
                                <select class="form-select rounded-pill" name="type" required>
                                    <option value="" selected disabled>Select type</option>
                                    <option value="IM">IM</option>
                                    <option value="EX">EX</option>
                                    <option value="LCL">LCL</option>
                                    <option value="MT">MT</option>
                                    <option value="LADEN">LADEN</option>
                                </select>
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

                            <!-- Description -->
                            <div class="col-12">
                                <label for="description" class="form-label fw-bold">
                                    <i class="bi bi-card-text"></i> Description
                                </label>
                                <textarea class="form-control rounded-3" name="description" placeholder="Enter description" rows="3" required></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">
                                    <i class="bi bi-upload"></i> Upload
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
                        <i class="bi-list-check"></i> Shipment List
                    </h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Client Name</th>
                                    <th>Phone</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shipments as $key => $shipment)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $shipment->client_name }}</td>
                                    <td>{{ $shipment->phone }}</td>
                                    <td>{{ $shipment->type }}</td>
                                    <td>{{ $shipment->description }}</td>
                                    <td>
                                        <span class="badge {{ $shipment->status === 'Assigned' ? 'bg-primary' : ($shipment->status === 'Completed' ? 'bg-success' : 'bg-warning') }}">
                                            {{ $shipment->status }}
                                        </span>
                                    </td>
                                    <td class="text-center gap-2">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Assign Button -->
                                            <a href="{{ route('shipment.assign', $shipment->id) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i> Assign
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('shipment.edit', $shipment->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('shipment.destroy', $shipment->id) }}" method="POST" class="d-inline">
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
