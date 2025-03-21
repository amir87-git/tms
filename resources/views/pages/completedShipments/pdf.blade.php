<!DOCTYPE html>
<html>
<head>
    <title>Shipment Report</title>
    <style>
        /* General Reset */
        body { margin: 0; padding: 0; font-family: Arial, sans-serif; }

        /* Page Setup for Printing */
        @page { size: A4; margin: 0; }
        @media print {
            /* Ensure header and footer are fixed */
            .header { position: fixed; top: 0; left: 0; right: 0; height: 50mm; }
            .footer { position: fixed; bottom: 0; left: 0; right: 0; height: 20mm; }
            /* Adjust content margins to avoid overlapping */
            .content { margin: 55mm 15mm 25mm 15mm; }
        }

        /* Header Styles */
        .header {
            text-align: center;
            background-color: #f8f9fa;
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
        }
        .header img {
            width: 210mm;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .header table {
            width: 40%;
            margin: 5px auto;
            font-size: 10px;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }
        .header th, .header td {
            padding: 5px;
            text-align: left;
        }
        .header th {
            background-color: #e9ecef;
            font-weight: bold;
            color: #333;
        }

        /* Footer Styles */
        .footer {
            background-color: #343a40;
            text-align: center;
            padding: 5px 0;
            color: #fff;
        }
        .footer p {
            margin: 0;
            font-size: 9px;
        }
        .footer p:last-child {
            font-size: 8px;
            color: #ccc;
        }

        /* Content Styles */
        .content {
            padding: 20px;
        }
        .content h4 {
            font-size: 12px;
            color: #007bff;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 10px;
        }
        .content th, .content td {
            padding: 5px;
            border: 1px solid #ccc;
        }
        .content th {
            background-color: #e9ecef;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <header class="header">
        <img src="{{ public_path('images/header.png') }}" alt="Company Logo">
        <div style="display: flex; justify-content: space-between; align-items: center; margin: 10px;">
            <p style="font-size: 12px; color: #333; margin: 0;">
                <strong>Shipment No:</strong>
                <span style="font-weight: bold; color: #007bff;">{{ $completedShipments->id }}</span>
            </p>
            <p style="font-size: 10px; color: #666; margin: 0;">
                {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
            </p>
        </div>
    </header>

    <!-- Content -->
    <div class="content">
        @if(!$completedShipments)
            <p style="font-size: 11px; color: #721c24; text-align: center; padding: 5px; background-color: #f8d7da;">
                No shipment data available.
            </p>
        @else
            <!-- Client Information -->
            <h4>Client Information</h4>
            <div style="display: flex; justify-content: space-between; padding: 8px; background-color: #f1f3f5; border: 1px solid #ccc; margin-bottom: 10px;">
                <div style="flex: 1; padding-right: 10px;">
                    <span style="font-size: 10px; font-weight: bold; color: #333;">Name:</span>
                    <span style="font-size: 10px; color: #333;">{{ $completedShipments->client_name ?? 'N/A' }}</span>
                </div>
                <div style="flex: 1; padding-right: 10px;">
                    <span style="font-size: 10px; font-weight: bold; color: #333;">Phone:</span>
                    <span style="font-size: 10px; color: #333;">{{ $completedShipments->phone ?? 'N/A' }}</span>
                </div>
                <div style="flex: 1;">
                    <span style="font-size: 10px; font-weight: bold; color: #333;">Email:</span>
                    <span style="font-size: 10px; color: #333;">{{ $completedShipments->email ?? 'N/A' }}</span>
                </div>
            </div>

            <!-- Vehicle & Driver Details -->
            <h4>Vehicle & Driver Details</h4>
            <table>
                <thead>
                    <tr>
                        <th>Driver Name</th>
                        <th>Driver Phone</th>
                        <th>Vehicle No</th>
                        <th>Trailer No</th>
                        <th>Vehicle Type</th>
                        <th>Total Distance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $completedShipments->driver->username ?? 'N/A' }}</td>
                        <td>{{ $completedShipments->driver->phone ?? 'N/A' }}</td>
                        <td>{{ $completedShipments->vehicle->vehicle_no ?? 'N/A' }}</td>
                        <td>{{ $completedShipments->vehicle->trailer_no ?? 'N/A' }}</td>
                        <td>{{ $completedShipments->vehicle->vehicle_typ ?? 'N/A' }}</td>
                        <td>{{ $completedShipments->total_km ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Trip Breakdown -->
            <h4>Trip Breakdown</h4>
            @if($completedShipments->trips && $completedShipments->trips->isNotEmpty())
                <table>
                    <thead>
                        <tr>
                            <th>Location</th>
                            <th>In Date</th>
                            <th>In Time</th>
                            <th>Out Date</th>
                            <th>Out Time</th>
                            <th>Total Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completedShipments->trips as $trip)
                            <tr>
                                <td>{{ $trip->location ?? 'N/A' }}</td>
                                <td>{{ $trip->in_date ?? 'N/A' }}</td>
                                <td>{{ $trip->in_time ?? 'N/A' }}</td>
                                <td>{{ $trip->out_date ?? 'N/A' }}</td>
                                <td>{{ $trip->out_time ?? 'N/A' }}</td>
                                <td>{{ $trip->total_time ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p style="margin: 5px 0; font-size: 10px; font-weight: bold; color: #333;">
                    <strong>Total Trip Duration:</strong> {{ $completedShipments->overall_time ?? 'N/A' }}
                </p>
            @else
                <p style="font-size: 10px; color: #666; padding: 5px;">No trip details available for this shipment.</p>
            @endif

            <!-- Financial Breakdown -->
            <h4>Financial Breakdown</h4>
            <div style="padding: 5px; border: 1px solid #ccc; margin-bottom: 10px;">
                <!-- Transport Charges -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin: 3px 0;">
                    <span style="font-size: 10px; color: #333;">
                        <strong>Transport Charges:</strong>
                    </span>
                    <span style="font-size: 10px; color: #333;">
                        Rs.{{ number_format($completedShipments->trnsprt_chrg ?? 0, 2) }}
                    </span>
                </div>

                <!-- Highway Charges -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin: 3px 0;">
                    <span style="font-size: 10px; color: #333;">
                        <strong>Highway Charges:</strong>
                    </span>
                    <span style="font-size: 10px; color: #333;">
                        Rs.{{ number_format($completedShipments->highway_chrg ?? 0, 2) }}
                    </span>
                </div>

                <!-- Total Heldup Hours -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin: 3px 0;">
                    <span style="font-size: 10px; color: #333;">
                        <strong>Total Heldup Hours:</strong>
                    </span>
                    <span style="font-size: 10px; color: #333;">
                        {{ number_format($completedShipments->heldUp_hrs ?? 0, 2) }}
                    </span>
                </div>

                <!-- Heldup Charges -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin: 3px 0;">
                    <span style="font-size: 10px; color: #333;">
                        <strong>Heldup Charges:</strong>
                    </span>
                    <span style="font-size: 10px; color: #333;">
                        Rs.{{ number_format($completedShipments->heldUp_chrg ?? 0, 2) }}
                    </span>
                </div>

                <!-- Total Amount -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin: 5px 0 0; padding-top: 5px; border-top: 1px solid #ccc;">
                    <span style="font-size: 11px; color: #007bff; font-weight: bold;">
                        <strong>Total Amount:</strong>
                    </span>
                    <span style="font-size: 11px; color: #007bff; font-weight: bold;">
                        Rs.{{ number_format($completedShipments->total_amnt ?? 0, 2) }}
                    </span>
                </div>
            </div>
        @endif
    </div>

    <footer class="footer" style="position: fixed; bottom: 0; left: 0; right: 0; background-color: #343a40; color: #fff; text-align: center; padding: 10px 0;">
        <p style="margin: 0; font-size: 9px;">© {{ date('Y') }} MSA Shipping. All Rights Reserved.</p>
        <p style="margin: 2px 0 0; font-size: 8px; color: #ccc;">
            Email: info@msashipping.com | Contact: +1234567890 | Address: [Your Address]
        </p>
    </footer>
</body>
</html>