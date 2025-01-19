@extends('layouts.main')
@section('title')
    Show Category
@endsection
@section('content')
    <div class="container">
        <div class="row my-5 justify-content-center">
            <div class="col-md-10">
                <div class="shadow rounded p-5">
                    <h5 class="text-center mb-3">{{ $category->namaKategori }}</h5>
                    <p class="mb-4">
                        {{ $category->deskripsi }}
                    </p>
                    <p>{{ $category->status == 1 ? 'Active' : 'Non Active' }}</p>
                    <div class="row">
                        <div class="col-md mb-2">
                            <a href="{{ url('/category') }}" class="btn btn-primary border-0"
                                style="background-color: #FFD460; width:100%">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
