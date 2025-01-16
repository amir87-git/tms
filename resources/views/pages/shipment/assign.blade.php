@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card-header rounded bg-primary text-white">
                <h3 class="text-center fw-bold">🚚 Assign Shipment</h3>
            </div>
            <!-- Form Container with White Background and Shadow -->
            <div class="bg-white p-4 rounded shadow-lg">
                <form method="POST" action="{{ route('shipment.assign', $shipment->id) }}">
                    @csrf
                    <div class="row g-3">
                        <!-- Client Name -->
                        <div class="col-md-6">
                            <label for="client_name" class="form-label fw-bold">
                                <i class="bi bi-person"></i> Client Name
                            </label>
                            <input type="text" class="form-control rounded-pill" name="client_name"
                                   value="{{ $shipment->client_name }}" readonly>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold">
                                <i class="bi bi-telephone"></i> Phone
                            </label>
                            <div class="input-group">
                                <span class="text-muted input-group-text rounded-start-pill"><i class="fa fa-phone"></i>+94</span>
                                <input type="text" class="form-control" name="phone" value="{{ $shipment->phone }}" readonly>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label for="description" class="form-label fw-bold">
                                <i class="bi bi-card-text"></i> Description
                            </label>
                            <textarea class="form-control" name="description" rows="2" readonly>{{ $shipment->description }}</textarea>
                        </div>

                        <!-- Type -->
                        <div class="col-md-6">
                            <label for="type" class="form-label fw-bold">
                                <i class="bi bi-tags"></i> Type
                            </label>
                            <input type="text" class="form-control rounded-pill" name="type" value="{{ $shipment->type }}" readonly>
                        </div>

                        <!-- Choose Driver -->
                        <div class="col-md-6">
                            <label for="driver_id" class="form-label fw-bold">
                                <i class="bi bi-person-badge"></i> Assign Driver
                            </label>
                            <select class="form-select rounded-pill" name="driver_id" required>
                                <option value="" selected disabled>Select active driver</option>
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}">
                                        (ID: {{ $driver->id }}) {{ $driver->username }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Choose Vehicle -->
                        <div class="col-md-6">
                            <label for="vehicle_id" class="form-label fw-bold">
                                <i class="bi bi-truck"></i> Assign Vehicle
                            </label>
                            <select class="form-select rounded-pill" id="vehicleSelect" name="vehicle_id" required>
                                <option value="" selected disabled>Select active vehicle</option>
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" data-type="{{ $vehicle->vehicle_typ }}">
                                        ID: {{ $vehicle->id }} | {{ $vehicle->vehicle_typ }} (No: {{ $vehicle->vehicle_no }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Choose Trailer -->
                        <div class="col-md-6">
                            <label for="vehicle_id" class="form-label fw-bold">
                                <i class="bi bi-truck-front"></i> Assign Trailer
                            </label>
                            <select class="form-select rounded-pill" id="trailerSelect" name="trailer_no" required>
                                <option selected disabled>Select active trailer</option>
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->trailer_no }}">
                                        Trailer No: {{ $vehicle->trailer_no }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="rounded-pill btn btn-primary px-5 py-2">
                                <i class="bi bi-check-circle"></i> Assign Shipment
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const vehicleSelect = document.getElementById('vehicleSelect');
        const trailerSelect = document.getElementById('trailerSelect');

        vehicleSelect.addEventListener('change', function () {
            const selectedOption = vehicleSelect.options[vehicleSelect.selectedIndex];
            const vehicleType = selectedOption.getAttribute('data-type');

            if (vehicleType === 'Lorry') {
                trailerSelect.value = '';
                trailerSelect.setAttribute('disabled', 'disabled');
            } else {
                trailerSelect.removeAttribute('disabled');
            }
        });
    });
</script>

@endsection
