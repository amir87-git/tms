<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Driver;
use App\Models\Vehicle;

class AssignedShipmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:manager');
        $this->middleware('preventBackHistory')->except(['show', 'store']);
    }

    public function index()
    {
        // Fetch only 'Assigned' shipments along with related driver and vehicle details
        $assignedShipments = Shipment::with(['driver', 'vehicle'])
                                     ->where('status', 'Assigned')
                                     ->orderBy('id', 'asc') // Example: Sort by ID descending - desc | for ascending - asc
                                     ->paginate(25);

        // Pass the data to the index view
        return view('pages.ManDshbrd.AssignedShipments.index', compact('assignedShipments'));
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
}
