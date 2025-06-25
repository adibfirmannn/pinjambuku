<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index()
    {
        $idMahasiswa = session('id');
        $mahasiswa = Mahasiswa::findOrFail($idMahasiswa);
        return view('app.mahasiswa.setting', compact('mahasiswa'));
    }

    public function formChangePassword()
    {
        return view('app.mahasiswa.changePassword');
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate(
            [
                'fotoProfil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'namaLengkap' => 'required|string|min:3|max:100',
                'nim' => 'nullable|string|size:12',
                'email' => 'required|email|min:3|max:255',
                'nohp' => 'nullable|string|size:12',
                'angkatan' => 'string|digits:4',
            ],
            [
                'fotoProfil.image' => 'foto profil harus image',
                'fotoProfil.mimes' => 'foto profil harus berupa jpeg/png/jpg',
                'fotoProfil.max' => 'foto profil maximal 2048kb',
                'namaLengkap.required' => 'nama lengkap harus diisi',
                'namaLengkap.string' => 'nama lengkap harus string',
                'namaLengkap.min' => 'panjang nama lengkap minimal 3',
                'namaLengkap.max' => 'panjang nama lengkap maximal 100',
                'nim.string' => 'nim harus string',
                'nim.size' => 'nim harus berjumlah 12',
                'email.required' => 'email harus diisi',
                'email.email' => 'email harus berbentuk @',
                'email.min' => 'panjang email minimal 3',
                'email.max' => 'panjang email maximal 255',
                'nohp.string' => 'nohp harus string',
                'nohp.size' => 'nohp harus berjumlah 12',
                'angkatan.string' => 'angkatan harus string',
                'angkatan.digits' => 'angkatan harus berjumlah 4'
            ]
        );

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
                $oldImagePath = public_path('img/mahasiswa/' . $mahasiswa->fotoProfil);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Simpan fotoProfil baru
            $imageName = time() . '.' . $request->fotoProfil->extension();
            $request->fotoProfil->move(public_path('img/mahasiswa/'), $imageName);
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
        $request->validate(
            [
                'old_password' => 'required',
                'password' => 'required|min:8|max:100|confirmed',
            ],
            [
                'old_password.required' => 'old password harus diisi',
                'password.required' => 'password harus diisi',
                'password.min' => 'panjang password minimal 8',
                'password.max' => 'panjang password maximal 100',
                'password.confirmed' => 'confirm password tidak sama'
            ]
        );

        $mahasiswa = Mahasiswa::findOrFail($id);

        if (!Hash::check($request->old_password, $mahasiswa->password)) {
            return back()->withErrors(['old_password' => 'Password lama salah']);
        }

        $mahasiswa->password = Hash::make($request->password);
        $mahasiswa->save();


        return redirect()->route('mahasiswa.formChangePassword')->with('success', 'Password Berhasil diubah');
    }
}
