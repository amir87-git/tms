<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;


class ReceiveShipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:driver');
        $this->middleware('preventBackHistory');
    }


    public function index()
    {
        // Get the logged-in user's ID
        $userId = Auth::guard('driver')->id();

        // Fetch shipments assigned to the logged-in user
        $receiveShipments = Shipment::with(['driver', 'vehicle'])
                                    ->where('status', 'Assigned')
                                    ->where('driver_id', $userId)
                                    ->orderBy('id', 'asc') // Example: Sort by ID descending - desc | for ascending - asc
                                    ->paginate(25);

        // Pass the filtered data to the index view
        return view('pages.DriDashbrd.ReceiveShipment.index', compact('receiveShipments'));
    }

    /**
     * Show the form for starting a trip for the shipment.
     */
    public function showForm($id)
    {
        $shipment = Shipment::findOrFail($id);
        $vehicle = $shipment->vehicle;
        $str_mtr_rdng = $vehicle ? $vehicle->end_mtr_rdng : null;

        return view('pages.DriDashbrd.ReceiveShipment.form', compact('shipment', 'str_mtr_rdng'));
    }

    /**
     * Store the shipment's trip details.
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Optional: If you need to show details for a single shipment or trip
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Optional: Implement edit functionality if needed
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Optional: Implement update functionality if needed
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Optional: Implement destroy functionality if needed
    }
}
