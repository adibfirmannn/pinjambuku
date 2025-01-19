@extends('layouts.main')
@section('title')
    History
@endsection
@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="text-center mb-4">History Peminjaman</h3>
                        <hr>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($histories as $history)
                                    <tr>
                                        <td>{{ $history->judul }}</td>
                                        <td>{{ $history->tanggalPeminjaman }}</td>
                                        <td>{{ $history->tanggalPengembalian == null ? 'Belum Konfirmasi' : $history->tanggalPengembalian }}
                                        </td>
                                        <td style="color: {{ $history->status == 1 ? 'green' : 'red' }}">
                                            {{ $history->status == 1 ? 'Sudah Dikembalikan' : 'Belum Dikembalikan' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak Ada Data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
