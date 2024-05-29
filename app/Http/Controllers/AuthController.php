<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Form Register
    public function register()
    {
        return view ('form.register');
    }

    // Register Post
    public function registerPost(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:255',
            'email'=> 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create ([
            'name'=> $request->name,
            'email'=> $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registerasi anda berhasil, silakan login!');
    }

    // Form Login
    public function login()
    {
        return view('form.login');
    }

    // Login Post
    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

        if (!$user->approved){
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun anda belum disetujui admin');
        }
         return redirect()->route('dashboard');
        } else {
            return redirect()->route('login')->with('error', 'Login gagal. Periksa kembali email dan password Anda.');
        }
    }
    // Log out
    public function logoutUser(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
    }