<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
    public function index()
    {
        $namaLengkap = session('namaLengkap');
        $histories = DB::table('peminjamans')
            ->join('detailspeminjamans', 'peminjamans.id', '=', 'detailspeminjamans.idPeminjaman')
            ->join('bukus', 'detailspeminjamans.idBuku', '=', 'bukus.id')
            ->join('mahasiswas', 'mahasiswas.id', '=', 'peminjamans.idMahasiswa')
            ->select('bukus.judul', 'peminjamans.tanggalPeminjaman', 'peminjamans.tanggalPengembalian', 'detailspeminjamans.status')
            ->where('namaLengkap', '=', $namaLengkap)
            ->get();

        return view('app.mahasiswa.history', compact('histories'));
    }
}
