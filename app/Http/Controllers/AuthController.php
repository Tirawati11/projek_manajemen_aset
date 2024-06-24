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
        return view('form.register');
    }

    // Register Post
    public function registerPost(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Logika untuk menentukan jabatan berdasarkan email
        $jabatan = $this->determineJabatan($request->email);

        User::create([
            'nama_user' => $request->nama_user,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'jabatan' => $jabatan,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi anda berhasil, silakan login!');
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

            if (!$user->approved) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Akun anda belum disetujui admin');
            }

            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login')->with('error', 'Login gagal, periksa kembali email dan password Anda.');
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

    protected function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login_at' => now(),
        ]);
    }

    private function determineJabatan($email)
    {
        // Logika untuk menentukan jabatan berdasarkan email
        if (strpos($email, 'admin') !== false) {
            return 'admin';
        } elseif (strpos($email, 'hrd') !== false) {
            return 'hrd';
        } else {
            return 'karyawan';
        }
    }
}
