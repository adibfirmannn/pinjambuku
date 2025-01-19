@extends('layouts.main')
@section('title')
    Category
@endsection
@section('styles')
    <style>
        /* responsive mobile and web */
        @media (max-width: 768px) {
            .table-web {
                display: none
            }
        }

        @media(min-width: 768px) {
            .table-mobile {
                display: none;
            }
        }

        /* style pagination */
        .pagination .page-link {
            color: black;
        }

        .pagination .page-item.active .page-link {
            background-color: #2D4059;
            border-color: #2D4059;
            color: white;

        }

        .pagination .page-link:hover {
            background-color: #3E4B61;
            color: white;

        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 my-3">
                <a href="{{ url('/category/create') }}" class="btn btn-primary py-2 px-5"
                    style="background-color: #2D4059">Create</a>
            </div>
            <div class="col-md-3 mt-3">
                <form>
                    <div class="input-group rounded">
                        <input type="search" id="search-input" class="form-control rounded" placeholder="Search"
                            aria-label="Search" aria-describedby="search-addon" name="search"
                            value="{{ request('search') }}" />
                        <span class="input-group-text border-0" id="search-addon" style="background-color: #2D4059">
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
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row justify-content-center my-4">
            <div class="col-md">
                <table class="table shadow" style="border-radius: 5px;">
                    <thead>
                        <tr>
                            <th scope="col" class="p-3">#</th>
                            <th scope="col" class="p-3">Nama Kategori</th>
                            <th scope="col" class="p-3">Deskripsi</th>
                            <th scope="col" class="p-3">Status</th>
                            <th scope="col" class="p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="searchable">
                        @include('app.admin.category-table')
                    </tbody>
                </table>
                {!! $categories->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Event input pada input pencarian
            $('#search-input').on('input', function() {
                var query = $(this).val().toLowerCase();

                // Kirim permintaan AJAX ke server
                $.ajax({
                    url: '{{ route('category.index') }}', // Sesuaikan dengan rute pencarian di Laravel
                    method: 'GET',
                    data: {
                        search: query
                    },
                    success: function(response) {
                        $('.searchable').html(
                            response); // Mengganti isi tabel dengan hasil pencarian
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + ' - ' + error);
                    }
                });
            });
        });
    </script>
@endsection
