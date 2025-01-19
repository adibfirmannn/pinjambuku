@extends('layouts.main')
@section('title')
    Cart
@endsection
@section('content')
    <div class="container">
        <div class="row mt-4 justify-content-center">
            <div class="col-md-8">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Cart</h3>
                        <hr>
                        @if ($cartItems->isNotEmpty())
                            @foreach ($cartItems as $item)
                                <div class="row justify-content-evenly align-items-center mb-3">
                                    <div class="col-lg-2 mb-2">
                                        <img src="{{ asset('img/' . $item->gambar) }}" alt="{{ $item->judul }}"
                                            class="img-fluid" style="max-height: 100px;">
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <p><strong>{{ $item->judul }}</strong></p>
                                        <p>{{ $item->pengarang }}</p>
                                    </div>
                                    <div class="col-lg-2 mb-2">
                                        <p>{{ now()->format('d/m/Y') }}</p>
                                    </div>
                                    <!-- Tombol hapus dari cart -->
                                    <div class="col-lg-2 mb-2">
                                        <a href="#" class="text-danger" data-bs-toggle="modal"
                                            data-bs-target="#confirmDeleteModal"
                                            onclick="setDeleteUrl('{{ route('mahasiswa.cart.remove', $item->id) }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                <path
                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                            <hr>
                            <div class="row justify-content-center mb-3">
                                <div class="col-6">
                                    <p class="text-center">Total Peminjaman</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-center">{{ $cartItems->count() }}</p>
                                </div>
                            </div>
                            <hr>
                            <form action="{{ route('mahasiswa.borrow') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary border-0"
                                    style="background-color: #F07B3F; width:100%">Pinjam</button>
                            </form>
                        @else
                            <p class="text-center">Your cart is empty.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus item ini dari cart?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="confirmDeleteButton" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setDeleteUrl(url) {
            document.getElementById('confirmDeleteButton').setAttribute('href', url);
        }
    </script>
@endsection
