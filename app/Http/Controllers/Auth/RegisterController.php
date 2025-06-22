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
        $validator = Validator::make(
            $request->all(),
            [
                'namaLengkap' => ['required', 'string', 'min:3', 'max:100'],
                'email' => ['required', 'string', 'email', 'min:3', 'max:255', 'unique:mahasiswas'],
                'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
            ],
            [
                'namaLengkap.required' => 'nama lengkap harus diisi',
                'namaLengkap.string' => 'nama lengkap harus string',
                'namaLengkap.min' => 'panjang nama lengkap minimal 3',
                'namaLengkap.max' => 'panjang nama lengkap maximal 100',
                'email.required' => 'email harus diisi',
                'email.string' => 'email harus string',
                'email.email' => 'email harus berbentuk @',
                'email.max' => 'panjang email maximal 255',
                'email.min' => 'panjang email minimal 3',
                'email.unique' => 'email sudah terdaftar',
                'password.required' => 'password harus diisi',
                'password.string' => 'password harus string',
                'password.min' => 'panjang password minimal 8',
                'password.max' => 'panjang password maximal 100',
                'password.confirmed' => 'confirm password tidak sama'
            ]
        );

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buat user baru
        Mahasiswa::create([
            'namaLengkap' => $request->namaLengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke halaman home
        return redirect()->route('login')->with('success', 'anda berhasil registrasi.');
    }
}
