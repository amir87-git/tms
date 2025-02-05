<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Check if user is an admin
        if ($this->isAdmin($credentials['email'], $credentials['password'])) {
            Log::info('Admin login successful', ['email' => $credentials['email'], 'user_role' => 'admin']);
            return redirect()->route('manager.index');
        }

        // Try logging in as a driver
        if (Auth::guard('driver')->attempt($credentials)) {
            Log::info('Driver login successful', ['email' => $credentials['email'], 'user_role' => 'driver']);
            return redirect()->route('receive-shipments.index');
        }

        // Try logging in as a manager
        if (Auth::guard('manager')->attempt($credentials)) {
            Log::info('Manager login successful', ['email' => $credentials['email'], 'user_role' => 'manager']);
            return redirect()->route('assigned-shipments.index');
        }

        // Log failed login attempt
        Log::warning('Login failed', ['email' => $credentials['email']]);
        return back()->withErrors(['email' => 'Invalid email or password'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    protected function isAdmin($email, $password)
    {
        return $email === 'ad@ad.com' && $password === '123';
    }
}
