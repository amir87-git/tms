@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">

    <!-- Username Section -->
    <div class="text-center py-2">
        <h5 class="text-primary fw-bold mb-0">Welcome, {{ Auth::user()->username }}</h5>
        <p class="text-muted">Here is your dashboard for managing shipments.</p>
    </div>
<div class="container-fluid py-3">

    <!-- Page Title Section -->
    <div class="card-header bg-primary py-3">
            <div class="row align-items-center">
                <!-- Menu Icon -->
                <div class="col-2 col-md-1">
                    <button class="btn btn-outline-primary dropdown-toggle btn-lg" id="menuIcon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-list fs-4 text-light"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="menuIcon">
                        <li><a class="dropdown-item" href="{{ route('completedShipments.index') }}">
                            <i class="bi bi-check-circle me-2"></i> My Completed Shipments
                        </a></li>
                    </ul>
                </div>

                
                <!-- Page Title -->
                <div class="col-8 col-md-10 text-center">
                    <h3 class="text-white fw-bold mb-0">Received Shipments</h3>
                    <p class="text-white-50 mb-0"><i class="bi bi-play-circle me-1"></i> Start your journey with ease</p>
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

    <!-- Table Section -->
    <div class="table-responsive shadow rounded">
        <table class="table table-hover bg-white">
            <thead class="table-primary">
                <tr>
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
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($receiveShipments as $shipment)
                    <tr class="table-hover">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $shipment->id }}</td>
                        <td>{{ $shipment->client_name }}</td>
                        <td>{{ $shipment->phone }}</td>
                        <td>{{ $shipment->type }}</td>
                        <td>{{ $shipment->description }}</td>
                        <td>{{ $shipment->driver->username ?? 'N/A' }}</td>
                        <td>{{ $shipment->vehicle->vehicle_typ ?? 'N/A' }}</td>
                        <td>{{ $shipment->vehicle->vehicle_no ?? 'N/A' }}</td>
                        <td>{{ $shipment->vehicle->trailer_no ?? 'N/A' }}</td>
                        <td class="text-center">
                            <!-- Start Trip Button -->
                            <a href="{{ route('receive-shipments.form', $shipment->id) }}" class="btn btn-outline-primary btn-sm shadow-sm">
                                Start Trip
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">No received shipments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination Links -->
<div class="d-flex justify-content-center mt-3">
    {{ $receiveShipments->links() }}
</div>

@endsection
