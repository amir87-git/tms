<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.login.index');
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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        // Attempt to authenticate as a driver using Auth guard
        if (Auth::guard('driver')->attempt(['email' => $email, 'password' => $password])) {
            Log::info('Login successful', [
                'email' => $email,
                'user_role' => 'driver',
                'timestamp' => now(),
            ]);

            // Redirect to the driver's dashboard
            return redirect()->route('receive-shipments.index');
        }

        // Attempt to authenticate as a manager (fallback to manual method)
        if (Auth::guard('manager')->attempt(['email' => $email, 'password' => $password])) {
            Log::info('Login successful', [
                'email' => $email,
                'user_role' => 'manager',
                'timestamp' => now(),
            ]);

            return redirect()->route('assigned-shipments.index');
        }

        // Log failed login attempt
        Log::warning('Login failed', [
            'email' => $email,
            'timestamp' => now(),
        ]);

        return back()->withErrors(['email' => 'Invalid email or password'])->withInput();
    }

    /**
     * Authenticate a user based on the provided email and password for managers.
     */
    protected function authenticateUser($email, $password, $model)
    {
        $user = $model::where('email', $email)->first();
        return $user && Hash::check($password, $user->password) ? $user : null;
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.index')->with('success', 'You have been logged out successfully.');
    }
}
