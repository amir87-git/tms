<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Shipment;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Trip;

class PdfController extends Controller
{

    public function generatePDF(Shipment $shipment)
    {
        // Get the details of the completed shipment
        $data = [
            'completedShipments' => $shipment,
        ];

        // Load the PDF view and pass the shipment data
        $pdf = PDF::loadView('pages.completedShipments.pdf', $data);

        // Download the PDF or return it as a response to view
        return $pdf->stream('shipment-' . $shipment->id . '.pdf');
    }

}
