<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view(
            'layouts.auth',
            [
                "title" => "Login",
            ]

        );
    }

    public function login(Request $request)
    {
        $login = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($login)) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                session(['role' => 'admin']);
            } else {
                session(['role' => 'public']);
            }
            return redirect('/home')->with('success', 'Successful login!');
        } else {
            return back()->with('error', 'Login failed!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
