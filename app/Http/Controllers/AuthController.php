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
        return view('Login');
    }

    public function auth(LoginRequest $request)
    {
        if (Auth::attempt(['name' => $request['name'], 'password' => $request['password']])) {
            return redirect()->route('dashboard')->with('success', 'Berhasil Login');
        } else {
            return redirect()->route('login')->with('error', 'Login Gagal, Username atau Password Salah!');
        }
    }
}
