<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index($id)
    {
        $admin = Admin::find($id);
        return view('app.admin.setting', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        // Validasi input data
        $request->validate([
            'namaLengkap' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'old_password' => 'nullable|string|min:4',
            'password' => 'nullable|string|min:4|confirmed'
        ]);

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
