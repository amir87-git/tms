@extends('layouts.app')

@section('content')

<div class="container-fluid py-3">
    <!-- Page Header -->
    <div class="card-header bg-primary text-white justify-content-between align-items-center mb-4 rounded shadow-sm">
        <div class="row align-items-center">
            <!-- Dropdown Menu -->
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
                        <li><a class="dropdown-item" href="{{ route('driver.index') }}">
                            <i class="bi bi-person-badge me-2"></i> Driver Management
                        </a></li>
                    </ul>
            </div>
            <!-- Page Title -->
            <div class="col-8 col-md-10 text-center">
                <h3 class="fw-bold mb-1"> Shipment Approval</h3>
                <p class="text-white-50 text-center mb-0"><i class="bi bi-shield-check"></i> Review and manage pending shipments with a click</p>
            </div>
        </div>
    </div>

    <!-- Filter/Search Section -->
    <div class="d-flex justify-content-between mb-4 align-items-center">
        <div>
            <a href="{{ route('approval.index') }}" class="text-decoration-none">
                <button class="btn btn-primary btn-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="View all shipments">
                    <i class="bi bi-funnel"></i> All
                </button>
            </a>
            <a href="{{ route('completedShipments.index') }}" class="text-decoration-none">
                <button class="btn btn-success btn-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="View approved shipments">
                    <i class="bi bi-check-circle"></i> Completed
                </button>
            </a>
            <a href="{{ route('assigned-shipments.index') }}" class="text-decoration-none">
                <button class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="View rejected shipments">
                    <i class="bi bi-x-circle"></i> Assigned
                </button>
            </a>
        </div>
        
        <div class="input-group w-25">
            <form action="{{ route('approval.index') }}" method="GET" class="w-100">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form-control-sm" 
                        placeholder="Search by ID or Driver..." 
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-secondary btn-sm" 
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Search">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    

    <!-- Shipment Cards Section -->
    <div class="row gy-4">
        @forelse ($approvalShipments as $shipment)
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        <h5 class="card-title mb-0">{{ $shipment->client_name }}</h5>
                        <small class="text-light fs-6">#{{ $shipment->id }}</small>
                    </div>
                    <div class="card-body">
                        <p><strong>Phone:</strong> {{ $shipment->phone }}</p>
                        <p><strong>Type:</strong> {{ $shipment->type }}</p>
                        <p><strong>Description:</strong> {{ Str::limit($shipment->description, 50) }}</p>
                        <p><strong>Driver:</strong> {{ $shipment->driver->username ?? 'N/A' }}</p>
                        <p><strong>Vehicle:</strong> {{ $shipment->vehicle->vehicle_no ?? 'N/A' }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <a href="{{ route('approval.approve', $shipment->id) }}" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve shipment">
                            <i class="bi bi-check-circle"></i> Approve
                        </a>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Reject shipment">
                            <i class="bi bi-x-circle"></i> Reject
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">No pending shipments found.</div>
            </div>
        @endforelse
    </div>
</div>

@endsection
