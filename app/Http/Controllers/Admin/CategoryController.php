<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

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
            'deskripsi' => 'required|string|max:300|min:3'
        ], 
        [
            'namaKategori.required' => 'nama kategori harus diisi',
            'namaKategori.string' => 'nama kategori harus string',
            'namaKategori.min' => 'panjang nama kategori minimal 3',
            'namaKategori.max' => 'panjang nama kategori maximal 15',
            'namaKategori.unique' => 'nama kategori sudah ada',
            'status.required' => 'status harus diisi',
            'status.boolean' => 'status harus boolean',
            'deskripsi.required' => 'deskripsi harus diisi',
            'deskripsi.string' => 'deskripsi harus string',
            'deskripsi.max' => 'panjang deskripsi maximal 300',
            'deskripsi.min' => 'panjang deskripsi minimal 3',
        ]
        );

        $slug = Str::slug($request->namaKategori);
        $request->merge(['slug' => $slug]);
        Kategori::create($request->all());
        return redirect('/category')->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $category = DB::table('kategoris')->select('namaKategori', 'status', 'deskripsi')
        ->where('slug', $slug)->first();
        // dd($category);
        return view('app.admin.show-category', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $category = Kategori::where('slug', $slug)->first();
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
            'deskripsi' => 'required|string|max:300|min:3'
        ],
        [
            'namaKategori.required' => 'nama kategori harus diisi',
            'namaKategori.string' => 'nama kategori harus string',
            'namaKategori.min' => 'panjang nama kategori minimal 3',
            'namaKategori.max' => 'panjang nama kategori maximal 15',
            'namaKategori.unique' => 'nama kategori sudah ada',
            'status.required' => 'status harus diisi',
            'status.boolean' => 'status harus boolean',
            'deskripsi.required' => 'deskripsi harus diisi',
            'deskripsi.string' => 'deskripsi harus string',
            'deskripsi.max' => 'panjang deskripsi maximal 300',
            'deskripsi.min' => 'panjang deskripsi minimal 3',
        ]);

        $slug = Str::slug($request->namaKategori);
        $request->merge(['slug' => $slug]);
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
