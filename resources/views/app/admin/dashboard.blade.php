@extends('layouts.main')
@section('title')
    Dashboard Admin
@endsection
@section('styles')
    <style>
        #search-addon {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-6 mt-3">
                <a href="{{ route('admin.create') }}" class="btn btn-primary py-2 px-5"
                    style="background-color: #2D4059">Create</a>
            </div>
            <div class="col-md-3 mt-3">
                <div class="input-group rounded">
                    <form action="{{ route('admin.dashboard') }}" method="GET" id="searchForm">
                        <div class="input-group rounded">
                            <input type="search" name="query" class="form-control rounded" placeholder="Search"
                                aria-label="Search" aria-describedby="search-addon"
                                value="{{ request()->input('query') }}" />
                            <span class="input-group-text border-0" id="search-addon" style="background-color: #2D4059"
                                onclick="document.getElementById('searchForm').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white"
                                    class="bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                </svg>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row mt-3">
            @forelse ($books as $book)
                <div class="col-md-6 mb-2">
                    <div class="card">
                        <div class="card-body shadow">
                            <div class="row">
                                <div class="col-md-6 flex align-content-center">
                                        <a href="{{ route('admin.show', $book->slug) }}">
                                        <img src="{{ asset('img/buku/' . $book->gambar) }}" alt="{{ $book->judul }}"
                                            class="img-fluid" style="height: 200px">
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="card-title mt-3">{{ Str::limit($book->judul, 20, '...') }}</h5>
                                    <p class="card-subtitle mb-2 text-muted mt-3">
                                        {{ Str::limit($book->pengarang, 20, '...') }}</p>
                                    <p class="card-text mt-3">{{ $book->namaKategori }}</p>
                                    <p class="card-text mt-3">{{ Str::limit($book->deskripsi, 20, '...') }}</p>
                                    <button class="btn {{ $book->status ? 'btn-success' : 'btn-danger' }} mb-3">
                                        {{ $book->status ? 'Active' : 'Non Active' }}
                                    </button>
                                    <a href="{{ route('admin.edit', $book->slug) }}"
                                        class="btn btn-primary border border-white"
                                        style="background-color: #F07B3F; width:100%">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center mt-3">Tidak Ada</p>
            @endforelse
        </div>

    </div>
@endsection
