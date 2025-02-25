<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;

class ManagerController extends Controller
{
    protected $manager;

    public function __construct()
    {
        $this->middleware('auth'); // Ensures only logged-in users (admins) can access this controller
        $this->middleware('preventBackHistory'); // Prevents back navigation after logout
        $this->manager = new Manager();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response['managers'] = $this->manager->all();
        return view('pages.Admin.index')->with($response);
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
        $this->manager->create($request->all());
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
        $response['managers'] = $this->manager->find($id);
        return view('pages.Admin.edit')->with($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $manager = $this->manager->find($id);
        $manager->update(array_merge($manager->toArray(), $request->toArray()));
        return redirect('manager');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $manager = $this->manager->find($id);
        $manager->delete();
        return redirect('manager');
    }
}
