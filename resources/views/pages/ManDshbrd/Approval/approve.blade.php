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
                                <th>Total Time</th>
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
                                <td>{{ $trip->total_time }}</td>
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
                        <label for="heldUp_hrs" class="form-label">Held Up Hours</label>
                        <input type="number" step="0.01" class="form-control @error('heldUp_hrs') is-invalid @enderror" id="heldUp_hrs" name="heldUp_hrs" required>
                        @error('heldUp_hrs')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="rate_perHr" class="form-label">Rate per hour</label>
                        <input type="number" step="0.01" class="form-control @error('rate_perHr') is-invalid @enderror" id="rate_perHr" name="rate_perHr" required>
                        @error('rate_perHr')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Held Up Charge (Calculated) -->
                    <div class="col-md-3">
                        <label for="heldUp_chrg" class="form-label">Held Up Charge</label>
                        <div id="heldUpChrgDisplay" class="form-control-plaintext bg-light p-2 rounded">0</div>
                        <input type="hidden" id="heldUp_chrg" name="heldUp_chrg">
                    </div>

                    <!-- Total Amount (Calculated) -->
                    <div class="col-md-3">
                        <label for="total_amnt" class="form-label">Total Amount</label>
                        <div id="totalAmntDisplay" class="form-control-plaintext bg-light p-2 rounded">0</div>
                        <input type="hidden" id="total_amnt" name="total_amnt">
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Approve Shipment</button>
            </div>

        </div>
    </form>
</div>

<script>
    // Function to calculate charges
    function calculateCharges() {
        const highwayChrg = parseFloat(document.getElementById('highway_chrg').value) || 0;
        const trnsprtChrg = parseFloat(document.getElementById('trnsprt_chrg').value) || 0;
        const heldUpHrs = parseFloat(document.getElementById('heldUp_hrs').value) || 0;
        const ratePerHr = parseFloat(document.getElementById('rate_perHr').value) || 0;

        // Calculate Held Up Charge
        const heldUpChrg = heldUpHrs * ratePerHr;
        document.getElementById('heldUpChrgDisplay').textContent = heldUpChrg.toFixed(2);
        document.getElementById('heldUp_chrg').value = heldUpChrg.toFixed(2);

        // Calculate Total Amount
        const totalAmnt = highwayChrg + trnsprtChrg + heldUpChrg;
        document.getElementById('totalAmntDisplay').textContent = totalAmnt.toFixed(2);
        document.getElementById('total_amnt').value = totalAmnt.toFixed(2);
    }

    // Add event listeners to input fields
    document.getElementById('highway_chrg').addEventListener('input', calculateCharges);
    document.getElementById('trnsprt_chrg').addEventListener('input', calculateCharges);
    document.getElementById('heldUp_hrs').addEventListener('input', calculateCharges);
    document.getElementById('rate_perHr').addEventListener('input', calculateCharges);

    calculateCharges();
</script>

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
