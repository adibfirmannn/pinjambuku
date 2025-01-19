<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardAdminController extends Controller
{
    public function index(Request $request)
    {
        //ambil input an user di tombol searching
        $query = $request->input('query');
        // ambil data buku dan namaKategorinya dengan menggunakan fungsi gruop_concet untuk menggabungkan nilainya yang berdasarkan id bukunya
        $books = DB::table('bukus')
            ->join('detailkategoris', 'bukus.id', '=', 'detailkategoris.idBuku')
            ->join('kategoris', 'detailkategoris.idKategori', '=', 'kategoris.id')
            ->select('bukus.*', DB::raw('GROUP_CONCAT(kategoris.namaKategori SEPARATOR ", ") as namaKategori'))
            ->where('bukus.judul', 'LIKE', "%{$query}%")
            ->orWhere('bukus.pengarang', 'LIKE', "%{$query}%")
            ->orWhere('kategoris.namaKategori', 'LIKE', "%{$query}%")
            ->groupBy('bukus.id')->get();

        return view('app.admin.dashboard', compact('books'));
    }



    public function create()
    {
        $categories = DB::table('kategoris')->select('kategoris.id', 'kategoris.namaKategori')->get();
        return view('app.admin.create-book', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:100|min:3',
            'pengarang' => 'required|string|max:100|min:3',
            'deskripsi' => 'required|string',
            'jumlah' => 'required|integer',
            'status' => 'required|boolean',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'kategori' => 'required|string'
        ]);

        // dd($request->kategori);
        $book = new Buku();
        $book->judul = $request->judul;
        $book->pengarang = $request->pengarang;
        $book->deskripsi = $request->deskripsi;
        $book->jumlah = $request->jumlah;
        $book->status = $request->status;

        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('img'), $imageName);
            $book->gambar = $imageName;
        }

        $book->save();

        $kategoriIds = explode(',', $request->kategori);

        foreach ($kategoriIds as $kategoriId) {
            DB::table('detailkategoris')->insert([
                'idBuku' => $book->id,
                'idKategori' => $kategoriId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'buku berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = DB::table('bukus')
            ->join('detailkategoris', 'bukus.id', '=', 'detailkategoris.idBuku')
            ->join('kategoris', 'detailkategoris.idKategori', '=', 'kategoris.id')
            ->select('bukus.*', DB::raw('GROUP_CONCAT(kategoris.namaKategori SEPARATOR ", ") as namaKategori'))
            ->where('bukus.id', $id)
            ->groupBy('bukus.id')
            ->get();

        // dd($book);
        return view('app.admin.show-book', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = DB::table('bukus')
            ->join('detailkategoris', 'bukus.id', '=', 'detailkategoris.idBuku')
            ->join('kategoris', 'detailkategoris.idKategori', '=', 'kategoris.id')
            ->select('bukus.*', DB::raw('GROUP_CONCAT(kategoris.id SEPARATOR ", ") as kategoriIds',))
            ->where('bukus.id', $id)
            ->groupBy('bukus.id')
            ->get()->first();
        $categories = DB::table('kategoris')->select('kategoris.id', 'kategoris.namaKategori')->get();

        // dd($categories);
        return view('app.admin.edit-book', compact('book', 'categories'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required|string|max:100|min:3',
            'pengarang' => 'required|string|max:100|min:3',
            'deskripsi' => 'required|string',
            'jumlah' => 'required|integer',
            'status' => 'required|boolean',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kategori' => 'required|string'
        ]);

        $book = Buku::find($id);
        $book->judul = $request->judul;
        $book->pengarang = $request->pengarang;
        $book->deskripsi = $request->deskripsi;
        $book->jumlah = $request->jumlah;
        $book->status = $request->status;

        //cek apakah ada file gambar yang dikirim oleh user
        if ($request->hasFile('gambar')) {
            // hapus gambar yang lama jika ada
            if ($book->gambar) {
                //ambil path gambar lama
                $oldImagePath = public_path('img/' . $book->gambar);
                // hapus gambar lama jika ada di server

                if (file_exists($oldImagePath)) {
                    // hapus file gambar lama
                    unlink($oldImagePath);
                }
            }
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('img'), $imageName);
            $book->gambar = $imageName;
        }

        $book->save();

        $kategoriIds = explode(',', $request->kategori);

        // hapus detail kategori yang ada di buku tersebut
        DB::table('detailkategoris')->where('idBuku', $id)->delete();

        // simpan detail kategori yang baru dibuku tersebut
        foreach ($kategoriIds as $kategoriId) {
            DB::table('detailkategoris')->insert([
                'idBuku' => $id,
                'idKategori' => $kategoriId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Buku berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
