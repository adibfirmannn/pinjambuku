<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BorrowingController extends Controller
{
    public function index()
    {
        $namaPeminjams = DB::table('mahasiswas')
            ->select('namaLengkap')->get();
        $tanggalPeminjamans = DB::table('peminjamans')
            ->select('tanggalPeminjaman')
            ->distinct()  // Menambahkan distinct untuk mengambil tanggal unik
            ->get();
        return view('app.admin.borrowing', compact('namaPeminjams', 'tanggalPeminjamans'));
    }

    public function edit($id)
    {
        $peminjaman = DB::table('peminjamans')
            ->join('detailspeminjamans', 'peminjamans.id', '=', 'detailspeminjamans.idPeminjaman')
            ->join('bukus', 'bukus.id', '=', 'detailspeminjamans.idBuku')
            ->join('mahasiswas', 'mahasiswas.id', '=', 'peminjamans.idMahasiswa')
            ->where('peminjamans.id', $id)
            ->select('peminjamans.id', 'mahasiswas.namaLengkap', DB::raw('GROUP_CONCAT(bukus.judul SEPARATOR ", ") as judul'), 'peminjamans.tanggalPengembalian', 'peminjamans.tanggalPeminjaman', DB::raw('GROUP_CONCAT(detailspeminjamans.status SEPARATOR ", ") as status'))->groupBy('peminjamans.id')->get()->first();

        // Mengonversi string judul dan status menjadi array
        $books = explode(',', $peminjaman->judul);
        $statuses = explode(',', $peminjaman->status);
        // dd($statuses);
        return view('app.admin.edit-borrowing', compact('peminjaman', 'statuses', 'books'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'tanggalPengembalian' => 'required|date',
                'status' => 'required|array',
                'status.*' => 'required|boolean',
            ],
            [
                'tanggalPengembalian.required' => 'tanggal pengembalian harus diisi',
                'tanggalPengembalian.date' => 'tanggal pengembalian harus format date',
                'status.required' => 'status harus diisi',
                'status.array' => 'status harus array',
                'status.boolean' => 'status harus boolean'
            ]
        );

        // ambil data peminjaman untuk cek tanggalPengembalian awal
        $peminjaman = DB::table('peminjamans')->where('id', $id)->first();

        // ambil semua detail peminjaman
        $details = DB::table('detailspeminjamans')
            ->where('idPeminjaman', $id)
            ->get();

        // Cegah admin langsung ubah ke status = 1 saat tanggal pengembalian masih null (belum dikonfirmasi)
        foreach ($request->input('status') as $index => $statusBaru) {
            if (is_null($peminjaman->tanggalPengembalian) && (int)$statusBaru === 1) {
                return back()->withErrors(['status' => 'Tidak boleh langsung tandai sebagai dikembalikan sebelum tanggal pengembalian dikonfirmasi.']);
            }
        }

        // Update tanggal pengembalian (setelah validasi di atas)
        DB::table('peminjamans')
            ->where('id', $id)
            ->update(['tanggalPengembalian' => $request->input('tanggalPengembalian')]);

        foreach ($request->input('status') as $index => $statusBaru) {
            $detail = $details[$index];
            $statusLama = (int)$detail->status;
            $statusBaru = (int)$statusBaru;
            $idBuku = $detail->idBuku;

            // Update status di detail
            DB::table('detailspeminjamans')
                ->where('idPeminjaman', $id)
                ->where('idBuku', $idBuku)
                ->update(['status' => $statusBaru]);

            //  Jika status berubah dari belum ke sudah dikembalikan → tambah stok
            if ($statusLama === 0 && $statusBaru === 1) {
                DB::table('bukus')->where('id', $idBuku)->increment('jumlah', 1);
            }

            //  Jika status tetap 0 dan tanggal sudah diisi → kurangi stok
            if ($statusLama === 0 && $statusBaru === 0 && $request->filled('tanggalPengembalian')) {
                DB::table('bukus')->where('id', $idBuku)->decrement('jumlah', 1);
            }
        }

        return redirect()->route('admin.borrowing')->with('success', 'Update Peminjaman Berhasil');
    }

    public function search(Request $request)
    {
        // cek apakah data kosong
        if (!$request->filled('namaLengkap') && !$request->filled('tanggalPeminjaman')) {
            return response()->json(['peminjamans' => []]); // Return empty data
        }

        // ambil data 
        $query = DB::table('peminjamans')
            ->join('detailspeminjamans', 'peminjamans.id', '=', 'detailspeminjamans.idPeminjaman')
            ->join('bukus', 'bukus.id', '=', 'detailspeminjamans.idBuku')
            ->join('mahasiswas', 'mahasiswas.id', '=', 'peminjamans.idMahasiswa')
            ->select(
                'peminjamans.id',
                'mahasiswas.namaLengkap',
                DB::raw('GROUP_CONCAT(bukus.judul SEPARATOR ", ") as judul'),
                'peminjamans.tanggalPengembalian',
                'peminjamans.tanggalPeminjaman',
                DB::raw('GROUP_CONCAT(detailspeminjamans.status SEPARATOR ", ") as status')
            )
            ->groupBy('peminjamans.id');

        //cek jika ada namaLengkap yang dikirimkan maka cari berdasarkan itu
        if ($request->filled('namaLengkap')) {
            $query->where('mahasiswas.namaLengkap', 'LIKE', '%' . $request->namaLengkap . '%');
        }

        //cek jika ada tanggalPeminjaman yang dikirimkan maka cari berdasarkan itu
        if ($request->filled('tanggalPeminjaman')) {
            $query->whereDate('peminjamans.tanggalPeminjaman', '=', $request->tanggalPeminjaman);
        }

        // ambil data yang sudah dikembalikan
        $peminjamans = $query->get()->map(function ($peminjaman) {
            $statusArray = explode(',', $peminjaman->status);
            $peminjaman->allReturned = !in_array('0', $statusArray);
            return $peminjaman;
        });

        // kembalikan data ke client sebagai JSON
        return response()->json(['peminjamans' => $peminjamans]);
    }
}
