@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h3 class="card-header bg-primary mb-3 text-center text-white fw-bold">
        <strong>Approve Shipment Details - {{ $shipment->id }}</strong>
        <br>
        <small class="text-light">Driver: {{ $shipment->driver->username }}</small>
    </h3>

    <!-- Shipment Basic Details -->
    <div class="card mb-3">
        <div class="card-header bg-light text-primary">Shipment Basic Details</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="client_name" class="form-label fw-bold">
                        <i class="bi bi-person" data-bs-toggle="tooltip" data-bs-placement="top" title="Client Name"></i> Client Name
                    </label>
                    <input type="text" class="form-control" name="client_name" value="{{ $shipment->client_name }}" readonly>
                </div>

                <div class="col-md-3">
                    <label for="phone" class="form-label fw-bold">
                        <i class="bi bi-telephone" data-bs-toggle="tooltip" data-bs-placement="top" title="Phone"></i> Phone
                    </label>
                    <input type="text" class="form-control" name="phone" value="{{ $shipment->phone }}" readonly>
                </div>

                <div class="col-md-3">
                    <label for="type" class="form-label fw-bold">
                        <i class="bi bi-archive" data-bs-toggle="tooltip" data-bs-placement="top" title="Type"></i> Type
                    </label>
                    <input type="text" class="form-control" name="type" value="{{ $shipment->type }}" readonly>
                </div>

                <div class="col-md-3">
                    <label for="vehicle_type" class="form-label fw-bold">
                        <i class="bi bi-truck" data-bs-toggle="tooltip" data-bs-placement="top" title="Vehicle Type"></i> Vehicle Type
                    </label>
                    <input type="text" class="form-control" name="vehicle_type" value="{{ $shipment->vehicle->vehicle_typ }}" readonly>
                </div>

                <div class="col-md-3">
                    <label for="vehicle_no" class="form-label fw-bold">
                        <i class="bi bi-clipboard" data-bs-toggle="tooltip" data-bs-placement="top" title="Vehicle No."></i> Vehicle No.
                    </label>
                    <input type="text" class="form-control" name="vehicle_no" value="{{ $shipment->vehicle->vehicle_no }}" readonly>
                </div>

                <div class="col-md-3">
                    <label for="trailer_no" class="form-label fw-bold">
                        <i class="bi bi-truck" data-bs-toggle="tooltip" data-bs-placement="top" title="Trailer No."></i> Trailer No.
                    </label>
                    <input type="text" class="form-control" name="trailer_no" value="{{ $shipment->vehicle->trailer_no ?? 'N/A' }}" readonly>
                </div>

                <div class="col-md-3">
                    <label for="total_time" class="form-label fw-bold">
                        <i class="bi bi-truck" data-bs-toggle="tooltip" data-bs-placement="top" title="Total Time."></i> Total Time.
                    </label>
                    <input type="text" class="form-control" name="total_time" value="{{ $shipment->total_time ?? 'N/A' }}" readonly>
                </div>

                <div class="col-md-3">
                    <label for="total_km" class="form-label fw-bold">
                        <i class="bi bi-truck" data-bs-toggle="tooltip" data-bs-placement="top" title="Total_Km"></i> Total Km
                    </label>
                    <input type="text" class="form-control" name="total_km" value="{{ $shipment->total_km ?? 'N/A' }}" readonly>
                </div>

                <div class="col-12">
                    <label for="description" class="form-label fw-bold">
                        <i class="bi bi-card-text" data-bs-toggle="tooltip" data-bs-placement="top" title="Description"></i> Description
                    </label>
                    <textarea class="form-control" name="description" rows="2" readonly>{{ $shipment->description }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion" id="tripAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTrips">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTrips" aria-expanded="true" aria-controls="collapseTrips">
                    Trip Details
                </button>
            </h2>
            <div id="collapseTrips" class="accordion-collapse collapse show" aria-labelledby="headingTrips" data-bs-parent="#tripAccordion">
                <div class="accordion-body">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Trip ID</th>
                                <th>Location</th>
                                <th>In Date</th>
                                <th>In Time</th>
                                <th>Out Date</th>
                                <th>Out Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shipment->trips as $trip)
                            <tr>
                                <td>{{ $trip->id }}</td>
                                <td>{{ $trip->location }}</td>
                                <td>{{ $trip->in_date }}</td>
                                <td>{{ $trip->in_time }}</td>
                                <td>{{ $trip->out_date }}</td>
                                <td>{{ $trip->out_time }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Approval Form -->
    <form action="{{ route('approval.approve', $shipment->id) }}" method="POST" class="mt-4">
        @csrf
        <div class="card">
            <div class="card-header bg-success text-white">Approve Shipment</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="mrktng_persnl" class="form-label">Marketing Personnel</label>
                        <input type="text" class="form-control @error('mrktng_persnl') is-invalid @enderror" id="mrktng_persnl" name="mrktng_persnl" required>
                        @error('mrktng_persnl')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="highway_chrg" class="form-label">Highway Charge</label>
                        <input type="number" step="0.01" class="form-control @error('highway_chrg') is-invalid @enderror" id="highway_chrg" name="highway_chrg" required>
                        @error('highway_chrg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="trnsprt_chrg" class="form-label">Transport Charge</label>
                        <input type="number" step="0.01" class="form-control @error('trnsprt_chrg') is-invalid @enderror" id="trnsprt_chrg" name="trnsprt_chrg" required>
                        @error('trnsprt_chrg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="total_amnt" class="form-label">Total Amount</label>
                        <input type="number" step="0.01" class="form-control @error('total_amnt') is-invalid @enderror" id="total_amnt" name="total_amnt" required>
                        @error('total_amnt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Approve Shipment</button>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
