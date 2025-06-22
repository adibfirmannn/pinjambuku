<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $idAdmin = session('id');
        $admin = Admin::find($idAdmin);
        return view('app.admin.setting', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        // Validasi input data
        $request->validate(
            [
                'namaLengkap' => 'required|string|min:3|max:100',
                'email' => 'required|email|unique:admins,email,' . $admin->id,
                'old_password' => 'nullable|string|min:8',
                'password' => 'nullable|string|min:8|max:100|confirmed'
            ],
            [
                'namaLengkap.required' => 'nama lengkap harus diisi',
                'namaLengkap.string' => 'nama lengkap harus string',
                'namaLengkap.min' => 'panjang nama lengkap minimal 3',
                'email.required' => 'email harus diisi',
                'email.email' => 'email harus berbentuk email',
                'email.unique' => 'email sudah terdaftar',
                'old_password.string' => 'old password harus string',
                'old_password.min' => 'panjang old password minimal 8',
                'password.string' => 'password harus string',
                'password.min' => 'panjang password minimal 8',
                'password.max' => 'panjang password maximal 100',
                'password.confirmed' => 'confirm password tidak sama'

            ]
        );

        // dd($request);

        //perbarui namaLengkap dan email admin
        $admin->namaLengkap = $request->input('namaLengkap');
        $admin->email = $request->input('email');



        // cek apakah old password diisi
        if ($request->filled('old_password')) {
            //cek apakah old password sama dengan yang ada di database
            if (Hash::check($request->input('old_password'), $admin->password)) {
                //masukkan password baru
                $admin->password = Hash::make($request->input('password'));
            } else {
                // Jika password lama tidak cocok, kembali ke halaman sebelumnya dengan pesan error
                return back()->withErrors(['old_password' => 'Password lama tidak sesuai.'])->withInput();
            }
        }

        $admin->update();

        session(['namaLengkap' => $admin->namaLengkap]);

        return redirect()->route('admin.setting', $admin->id)->with(['success' => 'Profil Anda Berhasil diperbarui.']);
    }
}
