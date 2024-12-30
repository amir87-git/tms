@extends('layouts.app')

@section('content')

<header style="text-align: center; margin-bottom: 20px;">
    <img src="{{ public_path('images/header.png') }}" alt="Company Logo" style="width: 100%; height: auto;">

    <table style="width: 15%; margin: 10px 0 0; border: 1px solid #ccc; font-size: 12px;">
        <tr style="background-color: #f8f9fa;">
            <th style="padding: 5px; text-align: left;">Shipment No:</th>
            <td style="padding: 5px; text-align: right;">{{ $completedShipments->id }}</td>
        </tr>
    </table>

    <hr style="border: 1px solid #007bff;">
    <p style="text-align: right; margin-top: 5px; font-size: 12px;">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
</header>

<div>
    <!-- Client Information -->
    <h4 style="font-size: 14px; text-align: left; color: #007bff; margin: 10px 0;">Client Information</h4>
    <table style="width: 100%; border: 1px solid #ccc; font-size: 12px; border-collapse: collapse; margin-bottom: 20px; border-radius: 5px; overflow: hidden;">
        <tr style="background-color: #f8f9fa;">
            <th style="padding: 5px; text-align: left; width: 25%;">Name:</th>
            <td style="padding: 5px;">{{ $completedShipments->client_name }}</td>
        </tr>
        <tr>
            <th style="padding: 5px; text-align: left;">Phone:</th>
            <td style="padding: 5px;">{{ $completedShipments->phone }}</td>
        </tr>
        <tr>
            <th style="padding: 5px; text-align: left;">Email:</th>
            <td style="padding: 5px;">{{ $completedShipments->email }}</td>
        </tr>
    </table>

    <!-- Vehicle & Driver Details -->
<h4 style="font-size: 14px; text-align: left; color: #007bff; margin: 10px 0;">Vehicle & Driver Details</h4>
<table style="width: 100%; border: 1px solid #ccc; font-size: 12px; border-collapse: collapse; margin-bottom: 20px; border-radius: 5px; overflow: hidden;">
    <thead>
        <tr style="background-color: #f8f9fa;">
            <th style="padding: 5px; text-align: left;">Driver Name</th>
            <th style="padding: 5px; text-align: left;">Driver Phone</th>
            <th style="padding: 5px; text-align: left;">Vehicle No</th>
            <th style="padding: 5px; text-align: left;">Vehicle Type</th>
            <th style="padding: 5px; text-align: left;">Total Distance</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 5px;">{{ $completedShipments->driver->username ?? 'N/A' }}</td>
            <td style="padding: 5px;">{{ $completedShipments->driver->phone ?? 'N/A' }}</td>
            <td style="padding: 5px;">{{ $completedShipments->vehicle->vehicle_no ?? 'N/A' }}</td>
            <td style="padding: 5px;">{{ $completedShipments->vehicle->vehicle_typ ?? 'N/A' }}</td>
            <td style="padding: 5px;">{{ $completedShipments->total_km ?? 'N/A' }}</td>
        </tr>
    </tbody>
</table>


    <!-- Trip Breakdown Section -->
    <h4 style="font-size: 14px; text-align: left; color: #007bff; margin: 10px 0;">Trip Breakdown</h4>
    @if($completedShipments->trips && $completedShipments->trips->isNotEmpty())
    <table style="width: 100%; border: 1px solid #ccc; font-size: 12px; border-collapse: collapse; border-radius: 5px; overflow: hidden;">
        <thead>
            <tr style="background-color: #f8f9fa;">
                <th style="padding: 5px; text-align: left;">Location</th>
                <th style="padding: 5px; text-align: left;">In Date</th>
                <th style="padding: 5px; text-align: left;">In Time</th>
                <th style="padding: 5px; text-align: left;">Out Date</th>
                <th style="padding: 5px; text-align: left;">Out Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($completedShipments->trips as $trip)
            <tr>
                <td style="padding: 5px;">{{ $trip->location ?? 'N/A' }}</td>
                <td style="padding: 5px;">{{ $trip->in_date ?? 'N/A' }}</td>
                <td style="padding: 5px;">{{ $trip->in_time ?? 'N/A' }}</td>
                <td style="padding: 5px;">{{ $trip->out_date ?? 'N/A' }}</td>
                <td style="padding: 5px;">{{ $trip->out_time ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="margin-top: 10px; font-size: 12px;"><strong>Total Trip Duration:</strong> {{ $completedShipments->total_time }}</p>
    @else
    <p style="font-size: 12px; color: #6c757d;">No trip details available for this shipment.</p>
    @endif

    <!-- Financial Breakdown -->
    <p style="font-size: 12px; margin-top: 20px;"><strong>Transport Charges:</strong> Rs.{{ number_format($completedShipments->transport_charges, 2) }}</p>
    <p style="font-size: 12px;"><strong>Highway Charges:</strong> Rs.{{ number_format($completedShipments->highway_charges, 2) }}</p>
    <p style="font-size: 12px; color: #007bff;"><strong>Total Amount:</strong> Rs.{{ number_format($completedShipments->total_amnt, 2) }}</p>
</div>

<footer style="background-color: #343a40; color: white; text-align: center; padding: 10px; border-radius: 5px; position: fixed; bottom: 0; left: 0; width: 100%; z-index: 9999;">
    <p style="margin: 0;">&copy; {{ date('Y') }} MSA Shipping. All Rights Reserved.</p>
    <p style="margin: 0;">
        <a href="mailto:info@msashipping.com" style="color: #f8f9fa; text-decoration: none;">Email</a> |
        <a href="tel:+1234567890" style="color: #f8f9fa; text-decoration: none;">Contact</a> |
        <a href="#" style="color: #f8f9fa; text-decoration: none;">Address</a>
    </p>
</footer>


@endsection
