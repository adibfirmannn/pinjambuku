<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        // dd(Auth::check());

        if (Auth::guard('mahasiswa')->check()) {
            return redirect()->route('mahasiswa.dashboard');
        } elseif (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba autentikasi sebagai mahasiswa
        if (Auth::guard('mahasiswa')->attempt($request->only('email', 'password'))) {
            session(['id' => Auth::guard('mahasiswa')->user()->id]);
            session(['namaLengkap' => Auth::guard('mahasiswa')->user()->namaLengkap]);
            return redirect()->intended('/mahasiswa/dashboard');
        }
        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            session(['id' => Auth::guard('admin')->user()->id]);
            session(['namaLengkap' => Auth::guard('admin')->user()->namaLengkap]);
            return redirect()->intended('/admin/dashboard');
        }


        // Autentikasi gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {

        if (Auth::guard('mahasiswa')->check()) {
            Auth::guard('mahasiswa')->logout();
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
