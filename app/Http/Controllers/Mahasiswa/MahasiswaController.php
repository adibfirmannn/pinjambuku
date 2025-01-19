<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index($id)
    {
        // dd($id);
        $mahasiswa = Mahasiswa::find($id);
        return view('app.mahasiswa.setting', compact('mahasiswa'));
    }

    public function formChangePassword()
    {
        return view('app.mahasiswa.changePassword');
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'fotoProfil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'namaLengkap' => 'required|string|max:255',
            'nim' => 'nullable|numeric|digits_between:8,10',
            'email' => 'required|email|max:255',
            'nohp' => 'nullable|numeric|digits_between:10,15',
            'angkatan' => 'numeric|digits:4',
        ]);

        // Cari data mahasiswa berdasarkan ID
        $mahasiswa = Mahasiswa::findOrFail($id);

        // dd($mahasiswa);

        // Update data mahasiswa
        $mahasiswa->namaLengkap = $request->namaLengkap;
        $mahasiswa->nim = $request->nim;
        $mahasiswa->email = $request->email;
        $mahasiswa->noHp = $request->nohp;
        $mahasiswa->angkatan = $request->angkatan;

        // Jika ada fotoProfil yang diunggah
        if ($request->hasFile('fotoProfil')) {
            // Hapus fotoProfil lama jika ada
            if ($mahasiswa->fotoProfil) {
                $oldImagePath = public_path('img/' . $mahasiswa->fotoProfil);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Simpan fotoProfil baru
            $imageName = time() . '.' . $request->fotoProfil->extension();
            $request->fotoProfil->move(public_path('img'), $imageName);
            $mahasiswa->fotoProfil = $imageName;
        }

        session(['namaLengkap' => $mahasiswa->namaLengkap]);
        // dd(session('namaLengkap'));

        // Simpan perubahan ke database
        $mahasiswa->save();

        // Redirect dengan pesan sukses
        return redirect()->route('mahasiswa.setting', $mahasiswa->id)->with('success', 'Profil berhasil diperbarui.');
    }


    public function changePassword(Request $request, $id)
    {

        // dd($request);
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);

        if (!Hash::check($request->old_password, $mahasiswa->password)) {
            return back()->withErrors(['old_password' => 'Password lama salah']);
        }

        $mahasiswa->password = Hash::make($request->password);
        $mahasiswa->save();


        return redirect()->route('mahasiswa.formChangePassword')->with('success', 'Password Berhasil diubah');
    }
}
