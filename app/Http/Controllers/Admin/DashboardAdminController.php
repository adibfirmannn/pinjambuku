<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

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
        $categories = DB::table('kategoris')->select('kategoris.id', 'kategoris.namaKategori')
            ->where('status', 1)->get();
        return view('app.admin.create-book', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'judul' => 'required|string|max:100|min:3|unique:bukus,judul',
                'pengarang' => 'required|string|max:100|min:3',
                'deskripsi' => 'required|string|max:300|min:3',
                'jumlah' => 'required|integer',
                'status' => 'required|boolean',
                'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'kategori' => 'required|string'
            ],
            [
                'judul.required' => 'judul harus diisi',
                'judul.string' => 'judul harus string',
                'judul.max' => 'panjang judul maximal 100',
                'judul.min' => 'panjang judul minimal 3',
                'judul.unique' => 'judul sudah ada',
                'pengarang.required' => 'pengarang harus diisi',
                'pengarang.string' => 'pengarang harus string',
                'pengarang.max' => 'panjang pengarang maximal 100',
                'pengarang.min' => 'panjang pengarang minimal 3',
                'deskripsi.required' => 'deskripsi harus diisi',
                'deskripsi.string' => 'deskripsi harus string',
                'deskripsi.max' => 'panjang deskripsi maximal 300',
                'deskripsi.min' => 'panjang deskripsi minimal 3',
                'jumlah.required' => 'jumlah harus diisi',
                'jumlah.integer' => 'jumlah harus bilangan bulat',
                'status.required' => 'status harus diisi',
                'status.boolean' => 'status harus boolean',
                'gambar.required' => 'gambar harus diisi',
                'gambar.image' => 'gambar harus image',
                'gambar.mimes' => 'gambar harus berupa jpeg/png/jpg',
                'gambar.max' => 'gambar maximal 2048kb',
                'kategori.required' => 'kategori harus diisi',
                'kategori.string' => 'kategori harus string'
            ]
        );

        // dd($request->kategori);
        $book = new Buku();
        $book->judul = $request->judul;
        $book->slug = Str::slug($request->judul);
        $book->pengarang = $request->pengarang;
        $book->deskripsi = $request->deskripsi;
        $book->jumlah = $request->jumlah;
        $book->status = $request->status;

        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('img/buku/'), $imageName);
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
    public function show(Buku $buku)
    {
        $book = DB::table('bukus')
            ->join('detailkategoris', 'bukus.id', '=', 'detailkategoris.idBuku')
            ->join('kategoris', 'detailkategoris.idKategori', '=', 'kategoris.id')
            ->select('bukus.*', DB::raw('GROUP_CONCAT(kategoris.namaKategori SEPARATOR ", ") as namaKategori'))
            ->where('bukus.slug', $buku->slug)
            ->groupBy('bukus.id')
            ->get();

        // dd($book);
        return view('app.admin.show-book', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        $book = DB::table('bukus')
            ->join('detailkategoris', 'bukus.id', '=', 'detailkategoris.idBuku')
            ->join('kategoris', 'detailkategoris.idKategori', '=', 'kategoris.id')
            ->select('bukus.*', DB::raw('GROUP_CONCAT(kategoris.id SEPARATOR ", ") as kategoriIds',))
            ->where('bukus.slug', $buku->slug)
            ->groupBy('bukus.id')
            ->get()->first();
        // Kategori aktif (status 1) untuk select option
        $categories = DB::table('kategoris')
            ->select('id', 'namaKategori')
            ->where('status', 1)
            ->get();
        // Kategori yang sudah dipilih buku (bisa status 0/1)
        $selectedCategories = DB::table('kategoris')
            ->join('detailkategoris', 'kategoris.id', '=', 'detailkategoris.idKategori')
            ->where('detailkategoris.idBuku', $buku->id)
            ->select('kategoris.id', 'kategoris.namaKategori')
            ->get();
        return view('app.admin.edit-book', compact('book', 'categories', 'selectedCategories'));
    }


    public function update(Request $request, Buku $buku)
    {
        $request->validate(
            [
                'judul' => 'required|string|max:100|min:3|unique:bukus,judul,' . $buku->id,
                'pengarang' => 'required|string|max:100|min:3',
                'deskripsi' => 'required|string|max:300|min:3',
                'jumlah' => 'required|integer',
                'status' => 'required|boolean',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'kategori' => 'required|string'
            ],
            [
                'judul.required' => 'judul harus diisi',
                'judul.string' => 'judul harus string',
                'judul.max' => 'panjang judul maximal 100',
                'judul.min' => 'panjang judul minimal 3',
                'judul.unique' => 'judul sudah ada',
                'pengarang.required' => 'pengarang harus diisi',
                'pengarang.string' => 'pengarang harus string',
                'pengarang.max' => 'panjang pengarang maximal 100',
                'pengarang.min' => 'panjang pengarang minimal 3',
                'deskripsi.required' => 'deskripsi harus diisi',
                'deskripsi.string' => 'deskripsi harus string',
                'deskripsi.max' => 'panjang deskripsi maximal 300',
                'deskripsi.min' => 'panjang deskripsi minimal 3',
                'jumlah.required' => 'jumlah harus diisi',
                'jumlah.integer' => 'jumlah harus bilangan bulat',
                'status.required' => 'status harus diisi',
                'status.boolean' => 'status harus boolean',
                'gambar.required' => 'gambar harus diisi',
                'gambar.image' => 'gambar harus image',
                'gambar.mimes' => 'gambar harus berupa jpeg/png/jpg',
                'gambar.max' => 'gambar maximal 2048kb',
                'kategori.required' => 'kategori harus diisi',
                'kategori.string' => 'kategori harus string'
            ]
        );

        $book = Buku::find($buku->id);
        $book->judul = $request->judul;
        $book->slug = Str::slug($request->judul);
        $book->pengarang = $request->pengarang;
        $book->deskripsi = $request->deskripsi;
        $book->jumlah = $request->jumlah;
        $book->status = $request->status;

        //cek apakah ada file gambar yang dikirim oleh user
        if ($request->hasFile('gambar')) {
            // hapus gambar yang lama jika ada
            if ($book->gambar) {
                //ambil path gambar lama
                $oldImagePath = public_path('img/buku/' . $book->gambar);
                // hapus gambar lama jika ada di server

                if (file_exists($oldImagePath)) {
                    // hapus file gambar lama
                    unlink($oldImagePath);
                }
            }
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('img/buku/'), $imageName);
            $book->gambar = $imageName;
        }

        $book->save();

        $kategoriIds = explode(',', $request->kategori);

        // hapus detail kategori yang ada di buku tersebut
        DB::table('detailkategoris')->where('idBuku', $buku->id)->delete();

        // simpan detail kategori yang baru dibuku tersebut
        foreach ($kategoriIds as $kategoriId) {
            DB::table('detailkategoris')->insert([
                'idBuku' => $buku->id,
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
