@extends('layouts.main')
@section('title')
    Borrow
@endsection
@section('content')
    <div class="container">
        <div class="row my-5 justify-content-center">
            <div class="col-md-10">
                <div class="shadow rounded">
                    <div class="row">
                        <div class="col-lg-5">
                            <img src="{{ asset('/img/buku/' . $buku->gambar) }}" alt="Book" class="img-fluid"
                                style="object-fit: cover;">
                        </div>
                        <div class="col-lg-6 p-5">
                            <div class="mb-3">
                                <label for="judulBuku" class="form-label">Judul Buku</label>
                                <input type="text" class="form-control" id="judulBuku" name="judulBuku"
                                    value="{{ $buku->judul }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="namaLengkap" name="namaLengkap"
                                    value="{{ session('namaLengkap') }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="tanggalPeminjaman" class="form-label">Tanggal Peminjaman</label>
                                <input type="date" class="form-control" id="tanggalPeminjaman" name="tanggalPeminjaman"
                                    value="{{ now()->format('Y-m-d') }}" disabled>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-6 mb-2">
                                    <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-primary border-0"
                                        style="background-color: #FFD460; width:100%">Back</a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('mahasiswa.cart', $buku->id) }}" class="btn btn-primary border-0"
                                        style="background-color: #F07B3F; width:100%">Borrow <svg
                                            xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                            <path
                                                d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z" />
                                            <path
                                                d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                        </svg></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
