<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    protected $vehicle;
    public function __construct(){
        $this->vehicle = new Vehicle();
    }

    public function index()
    {
        $response['vehicles'] = $this->vehicle->all();
        return view('pages.vehicle.index')->with($response);
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
        $request->validate([
            'vehicle_no' => 'required|unique:vehicles,vehicle_no',
            'trailer_no' => 'required|unique:vehicles,trailer_no',
        ], [
            'vehicle_no.unique' => 'This vehicle number is already registered.',
            'trailer_no.unique' => 'This trailer number is already registered.',
        ]);
        
        $this->vehicle->create($request->all());
        return redirect()->back();
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
        $response['vehicles'] = $this->vehicle->find($id);
        return view('pages.vehicle.edit')->with($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vehicle = $this->vehicle->find($id);
        $vehicle->update(array_merge($vehicle->toArray(), $request->toArray()));
        return redirect('vehicle');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehicle = $this->vehicle->find($id);
        $vehicle->delete();
        return redirect('vehicle');
    }
}
