<?php

namespace App\Http\Controllers;

use App\Models\PostUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Inertia\Inertia;

class AuthController extends Controller
{
    public function register() {
        session()->forget('user');
        return Inertia::render('Auth/Register');
    }

    public function store(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:6'
        ]);

        $userCredentials = PostUser::storeUser([
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    public function login() {
        session()->forget('user');
        return Inertia::render('Auth/Login', ['success' => session('success')]);
    }

    public function loginUser(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $userCredentials = PostUser::login($request->only('username', 'password'));
        
        session()->put('user', $userCredentials['user']);

        return redirect()->route('dashboard');
    }
}
