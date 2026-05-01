<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Log CSRF/session info when rendering login form to help debug 419 issues
        \Log::debug('Rendering login form', [
            'session_id' => session()->getId(),
            'session_token' => session()->token(),
        ]);

        return view('auth.login');
    }

    public function login(Request $request)
    {
        \Log::debug('Login POST received', [
            'posted__token' => $request->input('_token'),
            'session_id' => session()->getId(),
            'session_token' => session()->token(),
            'host' => $request->headers->get('host'),
        ]);

        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
            'is_active' => true,
        ])) {
            $request->session()->regenerate();

            // Redirect users directly to the first allowed view for their role
            $role = Auth::user()->role->name ?? '';

            if ($role === 'ADMIN') {
                return redirect()->route('dashboard')->with('success', 'Bienvenido.');
            }

            // Roles that work with orders -> land on orders list
            if (in_array($role, ['SALES', 'WAREHOUSE', 'PURCHASING', 'ROUTE'], true)) {
                return redirect()->route('orders.index')->with('success', 'Bienvenido.');
            }

            // Sales (fallback) -> customers index
            if ($role === 'SALES') {
                return redirect()->route('customers.index')->with('success', 'Bienvenido.');
            }

            // Default fallback
            return redirect()->route('dashboard')->with('success', 'Bienvenido.');
        }

        return back()->withErrors([
            'username' => 'Las credenciales son incorrectas.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Sesión cerrada correctamente.');
    }
}