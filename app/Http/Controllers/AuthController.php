<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        $title = 'Login';
        return view('Login', compact('title'));
    }

    public function auth(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return redirect()->intended('dashboard/dashboard')->with('success', 'Berhasil Login');
        } else {
            return redirect()->route('login')->with('error', 'Login Gagal, Username atau Password Salah!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
