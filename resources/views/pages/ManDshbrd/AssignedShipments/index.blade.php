@extends('layouts.app')

@section('content')

<div class="container-fluid py-3">
    <!-- Page Title -->
    <div class="text-center">
        <div class="card-header bg-primary py-3">
            <div class="row align-items-center">
                <!-- Menu Icon -->
                <div class="col-auto">
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
                <div class="col text-center">
                    <h3 class="text-white fw-bold mb-0">Assigned Shipments</h3>
                    <p class="text-white-50 mb-0"><i class="bi bi-person-check"></i> Review and manage all assigned shipments with ease</p>
                </div>
                
                <!-- Logout Button -->
                <div class="col-auto text-end">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm shadow-sm">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-responsive shadow rounded">
        <table class="table table-hover bg-white">
            <thead class="table-primary">
                <tr class="text-center">
                    <th>#</th>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>Phone</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Driver</th>
                    <th>Vehicle Type</th>
                    <th>Vehicle No</th>
                    <th>Trailer No</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($assignedShipments as $shipment)
                    <tr class="align-middle text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $shipment->id }}</td>
                        <td>{{ $shipment->client_name }}</td>
                        <td>{{ $shipment->phone }}</td>
                        <td>{{ $shipment->type }}</td>
                        <td>{{ $shipment->description }}</td>
                        <td>{{ $shipment->driver->username ?? 'N/A' }}</td>
                        <td>{{ $shipment->vehicle->vehicle_typ ?? 'N/A' }}</td>
                        <td>{{ $shipment->vehicle->vehicle_no }}</td>
                        <td>{{ $shipment->vehicle->trailer_no }}</td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                No assigned shipments found.
                                <br>
                                <a href="{{ route('shipment.index') }}" class="btn btn-primary mt-3">
                                    <i class="bi bi-file-earmark-plus me-2"></i> Assign New Shipment
                                </a>
                            </td>
                        </tr>
                    @endforelse

            </tbody>
        </table>
    </div>

    <!-- Action Button -->
    <div class="text-center mt-4">
        <a href="{{ route('shipment.index') }}" class="btn btn-primary px-4 py-2 shadow">
            <i class="bi bi-file-earmark-plus me-2"></i>Assign New Shipment
        </a>
    </div>
</div>

<!-- Pagination Links -->
<div class="d-flex justify-content-center mt-3">
    {{ $assignedShipments->links() }}
</div>

@endsection
