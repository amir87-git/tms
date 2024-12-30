@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    <div class="card-header bg-success align-items-center">
        <div class="row align-items-center justify-content-center">
            <!-- Page Title Centered -->
            <div class="col text-center">
                <h3 class="text-white fw-bold">
                    <strong>Completed Shipments</strong>
                </h3>
                <p class="text-white fw-bold">
                    <i class="bi bi-check-circle fs-6"></i> Destination Reached – Shipment Complete!</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive shadow rounded">
        <table class="table table-hover bg-white align-middle">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Shipment ID</th>
                    <th>Client Name</th>
                    <th>Phone</th>
                    <th>Driver</th>
                    <th>Vehicle No.</th>
                    <th>Trailer No.</th>
                    <th>Shipment Type</th>
                    <th>Description</th>
                    <th>Total Time</th>
                    <th>Total (Km)</th>
                    <th>Total (Rs)</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($completedShipments as $shipment)
                    <tr>
                        <td>{{ ++$loop->index }}</td>
                        <td>{{ $shipment->id }}</td>
                        <td>{{ $shipment->client_name }}</td>
                        <td>{{ $shipment->phone }}</td>
                        <td>{{ $shipment->driver->username ?? 'N/A' }}</td>
                        <td>{{ $shipment->vehicle->vehicle_no }}</td>
                        <td>{{ $shipment->vehicle->Trailer_no ?? 'N/A' }}</td>
                        <td>{{ $shipment->type ?? 'N/A' }}</td>
                        <td>{{ $shipment->description ?? 'N/A' }}</td>
                        <td>{{ $shipment->total_time ?? 'N/A' }}</td>
                        <td>{{ $shipment->total_km ?? 'N/A' }}</td>
                        <td>{{ $shipment->total_amnt }}</td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('completed-shipments.pdf', $shipment->id) }}" class="btn btn-sm btn-outline-success shadow-sm">
                                    <i class="bi bi-file-earmark-pdf"></i> PDF
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="text-center text-muted">
                            No completed shipments found. <a href="{{ route('shipment.index') }}" class="text-primary">Create a new assignment</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
