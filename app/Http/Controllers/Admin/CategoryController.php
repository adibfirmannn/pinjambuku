<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        // Ambil nilai pencarian dari input
        $query = $request->input('search');

        // Cek jika terdapat query pencarian
        if ($query) {
            // Lakukan pencarian data berdasarkan namaKategori
            $categories = Kategori::where('namaKategori', 'like', "%{$query}%")
                ->paginate(4);
        } else {
            // Ambil data kategori tanpa pencarian
            $categories = Kategori::paginate(4);
        }

        // Kembalikan view dengan data kategori yang sudah ditemukan atau tanpa pencarian
        if ($request->ajax()) {
            // Jika permintaan AJAX, kembalikan hanya bagian isi tabel (partial view)
            return view('app.admin.category-table', compact('categories'))->render();
        } else {
            // Jika permintaan biasa, kembalikan view utama dengan data kategori
            return view('app.admin.category', compact('categories'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.admin.create-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'namaKategori' => 'required|string|min:3|max:15|unique:kategoris,namaKategori',
            'status' => 'required|boolean',
            'deskripsi' => 'required|string'
        ]);

        Kategori::create($request->all());
        return redirect('/category')->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Kategori::find($id);
        return view('app.admin.show-category', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Kategori::find($id);
        return view('app.admin.edit-category', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $category)
    {
        $request->validate([
            'namaKategori' => 'required|string|min:3|max:15|unique:kategoris,namaKategori,' . $category->id,
            'status' => 'required|boolean',
            'deskripsi' => 'required|string'
        ]);

        $category->update($request->all());

        return redirect('/category')->with('success', 'Kategori berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
