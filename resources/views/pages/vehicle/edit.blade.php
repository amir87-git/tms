@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header Section -->
            <div>
                <h3 class="card-header rounded bg-primary text-center text-white fw-bold">
                    <i class="bi bi-truck me-2"></i>Edit Vehicle
                </h3>
            </div>

            <!-- Form Section -->
            <div class="card shadow-lg rounded p-4 bg-light mb-4">
                <form method="POST" action="{{ route('vehicle.update', $vehicles->id) }}">
                    @csrf
                    @method("PATCH")
                    <div class="row">
                        <!-- Vehicle Type -->
                        <div class="col-md-6 mb-3">
                            <label for="vehicle_typ" class="form-label fw-bold">
                                <i class="bi bi-truck"></i> Vehicle Type
                            </label>
                            <select class="form-select rounded-pill" name="vehicle_typ" required>
                                <option value="prime_mover" {{ $vehicles->vehicle_typ == 'prime_mover' ? 'selected' : '' }}>Prime Mover</option>
                                <option value="lorry" {{ $vehicles->vehicle_typ == 'lorry' ? 'selected' : '' }}>Lorry</option>
                            </select>
                        </div>

                        <!-- Vehicle No -->
                        <div class="col-md-6 mb-3">
                            <label for="vehicle_no" class="form-label fw-bold">
                                <i class="bi bi-list-ol"></i> Vehicle No
                            </label>
                            <input type="text" class="form-control rounded-pill" name="vehicle_no" value="{{ $vehicles->vehicle_no }}" readonly>
                        </div>

                        <!-- Trailer No -->
                        <div class="col-md-6 mb-3">
                            <label for="trailer_no" class="form-label fw-bold">
                                <i class="bi bi-123"></i> Trailer No
                            </label>
                            <input type="text" class="form-control rounded-pill" name="trailer_no" value="{{ $vehicles->trailer_no }}" readonly>
                        </div>

                        <!-- Start Meter Reading -->
                        <div class="col-md-6 mb-3">
                            <label for="str_mtr_rdng" class="form-label fw-bold">
                                <i class="bi bi-speedometer2"></i> Start Meter Reading
                            </label>
                            <input type="text" class="form-control rounded-pill" name="str_mtr_rdng" value="{{ $vehicles->str_mtr_rdng }}" placeholder="Enter start meter reading">
                        </div>

                        <!-- End Meter Reading -->
                        <div class="col-md-6 mb-3">
                            <label for="end_mtr_rdng" class="form-label fw-bold">
                                <i class="bi bi-speedometer"></i> End Meter Reading
                            </label>
                            <input type="text" class="form-control rounded-pill" name="end_mtr_rdng" value="{{ $vehicles->end_mtr_rdng }}" placeholder="Enter end meter reading">
                        </div>

                        <!-- Fuel Needed -->
                        <div class="col-md-6 mb-3">
                            <label for="fuel" class="form-label">
                                <i class="bi bi-fuel-pump me-2"></i>Fuel Needed
                            </label>
                            <select class="form-select rounded-pill" name="fuel" required>
                                <option value="yes" {{ $vehicles->fuel == 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ $vehicles->fuel == 'no' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label fw-bold">
                                <i class="bi bi-info-circle"></i> Status
                            </label>
                            <select class="form-select rounded-pill" name="status" required>
                                <option value="active" {{ $vehicles->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $vehicles->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">
                                <i class="bi bi-save me-2"></i> Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
