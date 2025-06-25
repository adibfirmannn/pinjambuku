@extends('layouts.main')
@section('title')
    Show Book
@endsection
@section('content')
    <div class="container">
        <div class="row my-5 justify-content-center">
            <div class="col-md-10">
                <div class="shadow rounded">
                    <div class="row">
                        <div class="col-lg-5">
                            <img src="{{ asset('/img/buku/' . $book[0]->gambar) }}" alt="{{ $book[0]->judul }}"
                                class="img-fluid" style="object-fit: cover;">
                        </div>
                        <div class="col-lg-6 p-5">
                            <h5 class="text-center">{{ $book[0]->judul }}</h5>
                            <p class="text-muted mt-4">{{ $book[0]->pengarang }}</p>
                            <p class="mt-4">{{ $book[0]->namaKategori }}</p>
                            <p class="mt-4">{{ $book[0]->deskripsi }}</p>
                            <p class="mt-4">{{ $book[0]->status == 1 ? 'Active' : 'Non Active' }}</p>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary border-0 mt-4"
                                style="background-color: #FFD460; width:100%">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
