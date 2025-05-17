<?php

namespace App\Http\Controllers\Auth;

use App\Models\Mahasiswa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{


    public function index()
    {
        if (Auth::guard('mahasiswa')->check()) {
            return redirect()->route('mahasiswa.dashboard');
        } elseif (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:mahasiswas'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buat user baru
        Mahasiswa::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke halaman home
        return redirect()->route('login');
    }
}
