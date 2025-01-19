@extends('layouts.main')
@section('title')
    Edit Borrowing
@endsection
@section('content')
    <div class="container">
        <div class="row my-5 justify-content-center">
            <div class="col-md-10">
                <div class="shadow rounded p-5">
                    <h5 class="text-center">Borrowing</h5>
                    <form action="{{ route('admin.borrowing-update', $peminjaman->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="namaPeminjam" class="form-label">Nama Peminjam</label>
                                    <input type="text" class="form-control" id="namaPeminjam" name="namaPeminjam"
                                        value="{{ $peminjaman->namaLengkap }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="judulBuku" class="form-label">Judul Buku</label>
                                    <input type="text" class="form-control" id="judulBuku" name="judulBuku"
                                        value="{{ $peminjaman->judul }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggalPeminjaman" class="form-label">Tanggal Peminjaman</label>
                                    <input type="date" class="form-control" id="tanggalPeminjaman"
                                        name="tanggalPeminjaman" value="{{ $peminjaman->tanggalPeminjaman }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggalPengembalian" class="form-label">Tanggal Pengembalian</label>
                                    <input type="date"
                                        class="form-control @error('tanggalPengembalian') is-invalid @enderror"
                                        id="tanggalPengembalian" name="tanggalPengembalian"
                                        value="{{ $peminjaman->tanggalPengembalian }}">
                                    @error('tanggalPengembalian')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row">
                                    @foreach ($books as $key => $book)
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="status{{ $key }}" class="form-label">Status
                                                    {{ $book }}</label>
                                                <select class="form-select @error('status') is-invalid @enderror"
                                                    id="status{{ $key }}" name="status[]">
                                                    <option value="0" {{ $statuses[$key] == 0 ? 'selected' : '' }}>
                                                        Belum Dikembalikan</option>
                                                    <option value="1" {{ $statuses[$key] == 1 ? 'selected' : '' }}>
                                                        Sudah Dikembalikan</option>
                                                </select>
                                                @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach
                                </div>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.borrowing') }}" class="btn btn-primary border-0"
                                    style="background-color: #FFD460; width:100%">Back</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary border-0"
                                    style="background-color: #F07B3F; width:100%">Edit</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
