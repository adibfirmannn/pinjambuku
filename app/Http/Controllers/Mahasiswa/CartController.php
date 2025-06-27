<?php

namespace App\Http\Controllers\Mahasiswa;

use Carbon\Carbon;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index($id = null)
    {
        // Periksa apakah ada ID yang dikirim
        if ($id) {
            // Ambil cart dari session atau buat array baru jika belum ada
            $cart = session()->get('cart', []);

            // Tambahkan ID ke cart jika belum ada
            if (!in_array($id, $cart)) {
                $cart[] = $id;
            }

            // Simpan cart kembali ke session
            session()->put('cart', $cart);
        }

        // Ambil daftar ID dari session
        $cartIds = session()->get('cart', []);

        // Query data buku berdasarkan ID di session
        $cartItems = Buku::whereIn('id', $cartIds)->get();

        // Return data ke view
        return view('app.mahasiswa.cart', compact('cartItems'));
    }



    public function formBorrow(Buku $buku)
    {
        return view('app.mahasiswa.borrow', compact('buku'));
    }

    public function remove($id)
    {
        // Ambil cart dari session
        $cart = session()->get('cart', []);

        // Hapus item berdasarkan ID
        if (($key = array_search($id, $cart)) !== false) {
            unset($cart[$key]);
        }

        // Simpan kembali cart ke session
        session()->put('cart', $cart);

        // Redirect ke halaman cart dengan pesan sukses
        return redirect()->route('mahasiswa.cart')->with('success', 'Item berhasil dihapus dari cart.');
    }

    public function borrow()
    {
        $idMahasiswa = session('id');
        $tanggalPeminjaman = Carbon::now();

        // Mengambil data keranjang dari session
        $cartItems = session('cart', []);

        // Tambahkan ke tabel peminjamans
        $idPeminjaman = DB::table('peminjamans')->insertGetId([
            'idAdmin' => "fa003692-3262-487a-ae66-69b3228e829b",
            'idMahasiswa' => $idMahasiswa,
            'tanggalPeminjaman' => $tanggalPeminjaman,
            'tanggalPengembalian' => null,
            'jumlahBuku' => count($cartItems),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        foreach ($cartItems as $idBuku) {
            // Masukkan data ke tabel detailspeminjamans
            DB::table('detailspeminjamans')->insert([
                'idBuku' => $idBuku,
                'idPeminjaman' => $idPeminjaman,
                'status' => 0, // Status 'Dipinjam'
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Kosongkan keranjang
        session()->forget('cart');

        return redirect()->route('mahasiswa.history')->with('success', 'Peminjaman Buku Berhasil');
    }
}
