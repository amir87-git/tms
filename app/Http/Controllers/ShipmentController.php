<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    protected $shipment;

    public function __construct(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    public function index()
    {
        $response['shipments'] = $this->shipment->all();
        return view('pages.shipment.index')->with($response);
    }

    public function create()
    {
        //lnjn
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10',
        ]);

        $this->shipment->create($request->all());
        return redirect()->route('shipment.index')->with('success', 'Shipment created successfully.');
    }

    public function show(string $id)
    {
        $shipment = $this->shipment->findOrFail($id);
        return view('pages.shipment.show', compact('shipment'));
    }

    public function edit(string $id)
    {
        $shipment = $this->shipment->findOrFail($id);
        return view('pages.shipment.edit', compact('shipment'));
    }

    public function update(Request $request, string $id)
    {
        $shipment = $this->shipment->findOrFail($id);

        $request->validate([
            'phone' => 'required|digits:10',
        ]);

        $shipment->update($request->all());
        return redirect()->route('shipment.index')->with('success', 'Shipment updated successfully.');
    }

    public function destroy(string $id)
    {
        $shipment = $this->shipment->findOrFail($id);
        $shipment->delete();
        return redirect()->route('shipment.index')->with('success', 'Shipment deleted successfully.');
    }

    public function assign(string $id)
    {
        $shipment = $this->shipment->findOrFail($id);
        $drivers = Driver::where('status', 'active')->get();
        $vehicles = Vehicle::where('status', 'active')->get();

        return view('pages.shipment.assign', compact('shipment', 'drivers', 'vehicles'));
    }

    public function storeAssignment(Request $request, string $id)
    {
        $shipment = $this->shipment->findOrFail($id);

        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'trailer_no' => 'nullable|string',
        ]);

        $shipment->update([
            'driver_id' => $request->driver_id,
            'vehicle_id' => $request->vehicle_id,
            'trailer_no' => $request->trailer_no,
            'status' => 'Assigned', // Set the status to "Assigned"
        ]);

        return redirect()->route('shipment.index')->with('success', 'Shipment assigned successfully.');
    }

    public function completedShipments(Request $request)
    {
        if (Auth::guard('driver')->check()) {
            $driverId = Auth::guard('driver')->id();
            $completedShipments = $this->shipment
                                    ->where('status', 'Completed')
                                    ->where('driver_id', $driverId)
                                    ->get();

            return view('pages.completedShipments.index', compact('completedShipments'));
        }

        // Check if the authenticated user is a manager
        else {
            $completedShipments = $this->shipment
                                    ->where('status', 'Completed')
                                    ->get();

            return view('pages.completedShipments.index', compact('completedShipments'));
        }

        // Redirect if no user is authenticated
        return redirect()->route('login')->with('error', 'Please log in to view shipments.');
    }

}
