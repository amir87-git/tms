@extends('layouts.app')

@section('content')

<div class="container-fluid py-5">

    <!-- Form Section -->
    <div class="row justify-content-center mt-4">
        <div class="col-12 md-10 col-md-8">
            <!-- Header Section -->
            <div>
                <h3 class="card-header rounded bg-primary text-center text-white fw-bold">
                    <i class="bi bi-box-seam me-2"></i>Edit Shipment
                </h3>
            </div>

            <div class="card shadow-lg rounded p-4 bg-light">
                <form method="POST" action="{{ route('shipment.update', $shipment->id) }}">
                    @csrf
                    @method("PATCH")
                    <div class="row">
                        <!-- Client Name -->
                        <div class="col-md-6 mb-3">
                            <label for="client_name" class="form-label fw-bold">
                                <i class="bi bi-person"></i> Client Name
                            </label>
                            <input type="text" class="form-control rounded-pill" name="client_name" value="{{ $shipment->client_name }}" placeholder="Enter client name." required>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label fw-bold">
                                <i class="bi bi-telephone"></i> Phone
                            </label>
                            <div class="input-group">
                                <span class="text-muted input-group-text rounded-start-pill"><i class="fa fa-phone"></i>+94</span>
                                <input type="text" class="form-control rounded-end-pill" name="phone" value="{{ $shipment->phone }}" placeholder="Enter phone no."
                                minlength="10" maxlength="10" pattern="\d{10}" required>
                            </div>
                        </div>

                        <!-- Type -->
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label fw-bold">
                                <i class="bi bi-tags"></i> Type
                            </label>
                            <select class="form-select rounded-pill" name="type" required>
                                <option value="im" {{ $shipment->type == 'im' ? 'selected' : '' }}>IM</option>
                                <option value="ex" {{ $shipment->type == 'ex' ? 'selected' : '' }}>EX</option>
                                <option value="lcl" {{ $shipment->type == 'lcl' ? 'selected' : '' }}>LCL</option>
                                <option value="mt" {{ $shipment->type == 'mt' ? 'selected' : '' }}>MT</option>
                                <option value="laden" {{ $shipment->type == 'laden' ? 'selected' : '' }}>LADEN</option>
                            </select>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-bold">
                                <i class="bi bi-envelope"></i> Email
                            </label>
                            <input type="email" class="form-control rounded-pill" name="email" value="{{ $shipment->email }}" required>
                        </div>


                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label fw-bold">
                                <i class="bi bi-card-text"></i> Description
                            </label>
                            <textarea class="form-control rounded-3" name="description" placeholder="Enter description" rows="3" required>{{ $shipment->description }}</textarea>
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
