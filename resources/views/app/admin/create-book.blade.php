@extends('layouts.main')
@section('title')
    Create Book
@endsection
@section('styles')
    <style>
        .category-tag {
            display: inline-block;
            background-color: #F07B3F;
            color: white;
            padding: 5px 10px;
            margin: 2px;
            border-radius: 4px;
        }

        .category-tag .remove-category {
            cursor: pointer;
            margin-left: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row my-5 justify-content-center">
            <div class="col-md-10">
                <div class="shadow rounded p-5">
                    <h5 class="text-center">Create Book</h5>
                    <form action="{{ route('admin.store.book') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul</label>
                                    <input type="text" class="form-control  @error('judul') is-invalid @enderror"
                                        id="judul" name="judul" value="{{ old('judul') }}">
                                    @error('judul')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="pengarang" class="form-label">Pengarang</label>
                                    <input type="text" class="form-control @error('pengarang') is-invalid @enderror"
                                        id="pengarang" name="pengarang" value="{{ old('pengarang') }}">
                                    @error('pengarang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi"
                                        style="height: 100px;">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                        id="jumlah" name="jumlah" value="{{ old('jumlah') }}">
                                    @error('jumlah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status">
                                        <option value="" {{ old('status', '') == '' ? 'selected' : '' }}>Pilih Status
                                        </option>
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Non Active
                                        </option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="kategoriSelect" class="form-label">Kategori</label>
                                    <select class="form-select @error('kategori') is-invalid @enderror" id="kategoriSelect">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->namaKategori }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="mt-2" id="selectedCategories">
                                        <!-- Selected categories will be added here -->
                                    </div>
                                    <input type="hidden" name="kategori" id="kategoriInput">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <img src="{{ url('/img/no-image.png') }}" alt="" width="85%" height="85%">
                                </div>
                                <div class="mb-3">
                                    <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                        id="gambar" name="gambar">
                                    @error('gambar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary border-0"
                                    style="background-color: #FFD460; width:100%">Back</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary border-0"
                                    style="background-color: #F07B3F; width:100%">Create</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Mendapatkan elemen-elemen DOM yang dibutuhkan
            const kategoriSelect = $('#kategoriSelect');
            const selectedCategories = $('#selectedCategories');
            const kategoriInput = $('#kategoriInput');
            let selectedKategoriIds = [];

            // Event listener untuk perubahan pada dropdown select kategori
            kategoriSelect.change(function() {
                // Mendapatkan opsi yang dipilih
                const selectedOption = $(this).find('option:selected');
                const selectedOptionValue = selectedOption.val();

                // Menambahkan opsi yang dipilih ke array selectedKategoriIds jika belum ada di array
                if (!selectedKategoriIds.includes(selectedOptionValue)) {
                    selectedKategoriIds.push(selectedOptionValue);
                    updateSelectedCategories(); // Memperbarui tampilan kategori yang dipilih
                }
            });

            // Fungsi untuk memperbarui tampilan kategori yang dipilih
            function updateSelectedCategories() {
                // Menghapus semua elemen di dalam div selectedCategories
                selectedCategories.empty();

                // Mengulangi setiap ID kategori yang dipilih untuk membuat elemen tag
                selectedKategoriIds.forEach(id => {
                    // Mendapatkan nama kategori berdasarkan ID dari dropdown select
                    const categoryName = kategoriSelect.find(`option[value="${id}"]`).text();
                    // Membuat elemen div untuk tag kategori dengan tombol silang untuk menghapus
                    const categoryDiv = $(`
                <div class="category-tag">
                    ${categoryName} <span class="remove-category" data-id="${id}">&times;</span>
                </div>
            `);
                    // Menambahkan elemen tag kategori ke dalam div selectedCategories
                    selectedCategories.append(categoryDiv);
                });
                // Memperbarui nilai input hidden dengan ID kategori yang dipilih, dipisahkan oleh koma
                kategoriInput.val(selectedKategoriIds.join(','));
            }

            // Event listener untuk menghapus kategori yang dipilih ketika tombol silang diklik
            selectedCategories.on('click', '.remove-category', function() {
                // Mendapatkan ID kategori yang akan dihapus
                const id = $(this).data('id');
                // Menghapus ID kategori dari array selectedKategoriIds
                selectedKategoriIds = selectedKategoriIds.filter(kategoriId => kategoriId !== id
                    .toString());
                updateSelectedCategories(); // Memperbarui tampilan kategori yang dipilih
            });
        });
    </script>
@endsection
