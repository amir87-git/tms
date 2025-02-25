@extends('layouts.app')

@section('content')
<div class="container-fluid min-vh-100">

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
        <div class="container-fluid">
            <!-- Logo at Start -->
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/msa.png') }}" alt="MSA Shipping Logo" style="width: 80px;">
            </a>

            <!-- MSA Shipping Text at Center -->
            <div class="navbar-brand mx-auto text-center d-none d-lg-block">
                <span class="fs-5 fw-bold text-uppercase" style="letter-spacing: 1px;">MSA Shipping</span>
            </div>

            <!-- Toggle Button for Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu at End -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Completed Shipments Link -->
                    <li class="nav-item me-3">
                        <a class="nav-link d-flex align-items-center" href="{{ route('completedShipments.index') }}">
                            <i class="bi bi-check-circle me-2"></i>
                            <span>Completed Shipments</span>
                        </a>
                    </li>

                    <!-- Logout Button -->
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link d-flex align-items-center">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4" style="margin-top: 70px;"> <!-- Adjusted margin for fixed navbar -->

        <!-- Page Title Section -->
        <div class="text-center mb-4">
            <div class="card bg-primary text-white py-3 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title fw-bold mb-0">Received Shipments</h3>
                    <p class="card-text text-white-50 mb-0">
                        <i class="bi bi-play-circle me-1"></i> Start your journey with ease
                    </p>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 d-none d-lg-table">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Client Name</th>
                                <th>Phone</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Vehicle Type</th>
                                <th>Vehicle No</th>
                                <th>Trailer No</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($receiveShipments as $shipment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $shipment->id }}</td>
                                    <td>{{ $shipment->client_name }}</td>
                                    <td>{{ $shipment->phone }}</td>
                                    <td>{{ $shipment->type }}</td>
                                    <td>{{ $shipment->description }}</td>
                                    <td>{{ $shipment->vehicle->vehicle_typ ?? 'N/A' }}</td>
                                    <td>{{ $shipment->vehicle->vehicle_no ?? 'N/A' }}</td>
                                    <td>{{ $shipment->vehicle->trailer_no ?? 'N/A' }}</td>
                                    <td class="text-center">
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

                    <!-- Mobile Responsive Cards -->
                    <div class="d-block d-lg-none">
                        @forelse ($receiveShipments as $shipment)
                            <div class="card mb-3 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $shipment->client_name }}</h5>
                                    <p class="card-text"><strong>ID:</strong> {{ $shipment->id }}</p>
                                    <p class="card-text"><strong>Phone:</strong> {{ $shipment->phone }}</p>
                                    <p class="card-text"><strong>Type:</strong> {{ $shipment->type }}</p>
                                    <p class="card-text"><strong>Description:</strong> {{ $shipment->description }}</p>
                                    <p class="card-text"><strong>Vehicle Type:</strong> {{ $shipment->vehicle->vehicle_typ ?? 'N/A' }}</p>
                                    <p class="card-text"><strong>Vehicle No:</strong> {{ $shipment->vehicle->vehicle_no ?? 'N/A' }}</p>
                                    <p class="card-text"><strong>Trailer No:</strong> {{ $shipment->vehicle->trailer_no ?? 'N/A' }}</p>
                                    <div class="text-center">
                                        <a href="{{ route('receive-shipments.form', $shipment->id) }}" class="btn btn-outline-primary btn-sm shadow-sm">
                                            Start Trip
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="card mb-3 shadow-sm">
                                <div class="card-body text-center py-4 text-muted">
                                    No received shipments found.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-3">
            {{ $receiveShipments->links() }}
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
