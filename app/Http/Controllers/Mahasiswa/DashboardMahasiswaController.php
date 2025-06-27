<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        $books = DB::table('bukus')
            ->join('detailkategoris', 'bukus.id', '=', 'detailkategoris.idBuku')
            ->join('kategoris', 'detailkategoris.idKategori', '=', 'kategoris.id')
            ->select('bukus.*', DB::raw('GROUP_CONCAT(kategoris.namaKategori SEPARATOR ", ") as namaKategori'))
            ->where('bukus.status', 1)
            ->where(function ($q) use ($query) {
                $q->where('bukus.judul', 'LIKE', "%{$query}%")
                    ->orWhere('bukus.pengarang', 'LIKE', "%{$query}%");
            })
            ->groupBy('bukus.id')
            ->get();

        return view('app.mahasiswa.dashboard', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        $book = DB::table('bukus')
            ->join('detailkategoris', 'bukus.id', '=', 'detailkategoris.idBuku')
            ->join('kategoris', 'detailkategoris.idKategori', '=', 'kategoris.id')
            ->select('bukus.*', DB::raw('GROUP_CONCAT(kategoris.namaKategori SEPARATOR ", ") as namaKategori'))
            ->where('bukus.slug', $buku->slug)
            ->groupBy('bukus.id')
            ->get();

        return view('app.mahasiswa.show-book', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
