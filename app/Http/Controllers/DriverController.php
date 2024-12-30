<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Shipment;
use App\Models\Vehicle;
use App\Models\Trip;

class DriverController extends Controller
{
    protected $driver;
    public function __construct(){
        $this->driver = new Driver();
    }


    public function index()
    {
        $response['drivers'] = $this->driver->all();
        return view('pages.index')->with($response);
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
            'phone' => 'required|digits:10',
        ]);

        if (Driver::where('email', $request->email)->exists()) {
            // Redirect back with an error message
            return back()->withErrors(['email' => 'This email is already registered.']);
        }

        $this->driver->create($request->all());
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
        $response['drivers'] = $this->driver->findOrFail($id);
        return view('pages.edit')->with($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $driver = $this->driver->findOrFail($id);
        $request->validate([
            'phone' => 'required|digits:10',
        ]);
        $driver->update(array_merge($driver->toArray(), $request->toArray()));
        return redirect('driver');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $driver = $this->driver->findOrFail($id);
        $driver->delete();
        return redirect('driver');
    }
}
