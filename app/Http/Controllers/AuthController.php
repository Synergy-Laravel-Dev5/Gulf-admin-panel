<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:3',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $user = Auth::user();
            if ($user->role !== 'admin') {
                Auth::logout();
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors([
                        'email' => 'You are not authorized to access the admin panel.',
                    ]);
            }
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->with('success', 'Login successful! Welcome back.');
        }
        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Invalid email or password. Please try again.'
            ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}
