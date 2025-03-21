<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Trip;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the search term from the request
        $search = $request->query('search');

        // Start the query with your existing conditions
        $query = Shipment::has('trips') // Only shipments with at least one trip
                        ->with(['driver', 'vehicle', 'trips']) // Eager load relationships
                        ->where('status', 'Assigned'); // Filter by 'Assigned' status

        // Apply search filter if a search term is provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%") // Search by shipment ID
                  ->orWhereHas('driver', function ($q) use ($search) {
                      $q->where('username', 'like', "%{$search}%"); // Search by driver username
                  });
            });
        }

        // Get the filtered results (with pagination if desired)
        $approvalShipments = $query->get(); // Or use ->paginate(9) for pagination

        return view('pages.ManDshbrd.Approval.index', compact('approvalShipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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

    public function approveForm($id)
    {
        $shipment = Shipment::findOrFail($id);
        return view('pages.ManDshbrd.Approval.approve', compact('shipment'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'mrktng_persnl' => 'required|string|max:255',
            'highway_chrg' => 'required|numeric',
            'trnsprt_chrg' => 'required|numeric',
            'heldUp_hrs' => 'required|numeric',
            'rate_perHr' => 'required|numeric',
            'heldUp_chrg' => 'required|numeric',
            'total_amnt' => 'required|numeric',
        ]);

        $shipment = Shipment::findOrFail($id);
        
        $shipment->mrktng_persnl = $request->mrktng_persnl;
        $shipment->highway_chrg = $request->highway_chrg;
        $shipment->trnsprt_chrg = $request->trnsprt_chrg;
        $shipment->heldUp_hrs = $request->heldUp_hrs;
        $shipment->rate_perHr = $request->rate_perHr;
        $shipment->heldUp_chrg = $request->heldUp_chrg;
        $shipment->total_amnt = $request->total_amnt;
        $shipment->status = 'completed';
        $shipment->save();

        return redirect()->route('approval.index')->with('success', 'Shipment approved and details saved successfully!');
    }


}
