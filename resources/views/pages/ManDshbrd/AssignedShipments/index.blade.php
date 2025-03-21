@extends('layouts.app')

@section('content')

<div class="container-fluid d-flex">

    <!-- Sidebar -->
    <div class="sidebar bg-dark text-light d-flex flex-column shadow-lg" style="width: 250px; height: 100vh;">
    <div class="text-center py-4">
    <img src="{{ asset('images/msa.png') }}" alt="MSA Shipping Logo" style="width: 150px; height: auto;">
    <p class="text-muted">Transport Management</p>
        <div class="d-flex justify-content-center align-items-center">
                <!-- If user has a profile image, display it; else show a Bootstrap icon -->
                @if(auth()->user()->profile_image)
                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}"
                        alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                @else
                    <!-- Use a Bootstrap icon as fallback -->
                    <i class="bi bi-person-circle" style="font-size: 40px; color: #fff;"></i>
                @endif
                <p class="ms-2 mb-0 text-white" style="font-size: 1.5rem; font-weight: bold;">
                    {{ 'Hi, ' . auth()->user()->username }}
                </p>
            </div>
        </div>

        <div class="nav flex-column px-3">
            <div class="nav-item mb-2">
                <a class="btn btn-outline-light w-100 py-3 mb-2 rounded-3 text-start hover-shadow {{ request()->routeIs('shipment.index') ? 'active' : '' }}" href="{{ route('shipment.index') }}">
                    <i class="bi bi-cloud-arrow-up me-2"></i> Upload Shipments
                </a>
            </div>
            <div class="nav-item mb-2">
                <a class="btn btn-outline-light w-100 py-3 mb-2 rounded-3 text-start hover-shadow {{ request()->routeIs('vehicle.index') ? 'active' : '' }}" href="{{ route('vehicle.index') }}">
                    <i class="bi bi-truck me-2"></i> Vehicle Management
                </a>
            </div>
            <div class="nav-item mb-2">
                <a class="btn btn-outline-light w-100 py-3 mb-2 rounded-3 text-start hover-shadow {{ request()->routeIs('driver.index') ? 'active' : '' }}" href="{{ route('driver.index') }}">
                    <i class="bi bi-person-badge me-2"></i> Driver Management
                </a>
            </div>
            <div class="nav-item mb-2">
                <a class="btn btn-outline-light w-100 py-3 mb-2 rounded-3 text-start hover-shadow {{ request()->routeIs('approval.index') ? 'active' : '' }}" href="{{ route('approval.index') }}">
                    <i class="bi bi-person-check-fill me-2"></i> Approvals
                </a>
            </div>
            <div class="nav-item mb-2">
                <a class="btn btn-outline-light w-100 py-3 mb-2 rounded-3 text-start hover-shadow {{ request()->routeIs('completedShipments.index') ? 'active' : '' }}" href="{{ route('completedShipments.index') }}">
                    <i class="bi bi-check-circle me-2"></i> Completed Shipments
                </a>
            </div>
        </div>

        <!-- Logout -->
        <div class="mt-auto py-4 text-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm shadow-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 py-3">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="text-center mb-4">
                <div class="card-header bg-primary py-3">
                    <div class="row align-items-center">
                        <div class="col text-center">
                            <h3 class="text-white fw-bold mb-0">Assigned Shipments</h3>
                            <p class="text-white-50 mb-0"><i class="bi bi-person-check"></i> Review and manage all assigned shipments with ease</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="table-responsive shadow-lg rounded">
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
                                <td>{{ $shipment->vehicle->vehicle_no ?? 'N/A' }}</td>
                                <td>{{ $shipment->trailer_no ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    <i class="bi bi-box-arrow-in-left me-2"></i> No assigned shipments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Action Button -->
            <div class="text-center mt-4">
                <a href="{{ route('shipment.index') }}" class="btn btn-primary px-4 py-2 shadow-lg">
                    <i class="bi bi-file-earmark-plus me-2"></i> Assign New Shipment
                </a>
            </div>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-3">
                {{ $assignedShipments->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
    window.history.pushState(null, null, window.location.href);
    window.onpopstate = function() {
        window.history.pushState(null, null, window.location.href);
    };
})();
</script>

@endsection
