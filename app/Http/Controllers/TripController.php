<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Trip;
use App\Models\Vehicle;
use Brick\Math\BigNumber;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($shipmentId)
    {
        $shipment = Shipment::with('vehicle')->findOrFail($shipmentId);
        
        return view('pages.DriDashbrd.ReceiveShipment.form', [
            'shipment' => $shipment,
            'vehicle' => $shipment->vehicle,
            'str_mtr_rdng' => $shipment->vehicle ? $shipment->vehicle->end_mtr_rdng : null,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'shipment_id' => 'required|integer|exists:shipments,id',
            'str_mtr_rdng' => 'required|numeric',
            'end_mtr_rdng' => 'required|numeric|gte:' . $request->input('str_mtr_rdng'),
            'location'    => 'required|array',
            'in_date'     => 'required|array',
            'in_time'     => 'required|array',
            'out_date'    => 'required|array',
            'out_time'    => 'required|array',
            'total_time'  => 'required|string',
            'total_km'    => 'required|numeric',
            'fuel'        => 'required|string',
            'qty'         => 'required_if:fuel,yes|nullable|numeric',
        ]);

        // Store each trip detail in the trips table
        foreach ($validatedData['location'] as $index => $location) {
            Trip::create([
                'shipment_id' => $validatedData['shipment_id'],
                'location'    => $location,
                'in_date'     => $validatedData['in_date'][$index],
                'in_time'     => $validatedData['in_time'][$index],
                'out_date'    => $validatedData['out_date'][$index],
                'out_time'    => $validatedData['out_time'][$index],
            ]);
        }

        // Update Shipment with total time and total kilometers
        $shipment = Shipment::findOrFail($validatedData['shipment_id']);
        $shipment->update([
            'total_time' => $validatedData['total_time'],
            'total_km'   => $validatedData['total_km'],
        ]);

        if ($validatedData['fuel'] === 'yes' && isset($validatedData['qty'])) {
            $shipment = Shipment::findOrFail($validatedData['shipment_id']);
            $shipment->update(['qty' => $validatedData['qty']]);
        }

        // Update Vehicle's end meter reading
        $vehicle = $shipment->vehicle;
        if ($vehicle) {
            $vehicle->update(['end_mtr_rdng' => $validatedData['end_mtr_rdng']]);
        }

        // Redirect with a success message
        return redirect()->route('receive-shipments.index')
                        ->with('success', 'Trip details have been successfully saved.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
