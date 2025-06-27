@extends('layouts.main')
@section('title')
    Borrowing
@endsection
@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-3 mt-3">
                <select class="form-select" aria-label="Default select example" name="namaPeminjam">
                    <option selected value="">Pilih Nama Peminjam</option>
                    @foreach ($namaPeminjams as $namaPeminjam)
                        <option value="{{ $namaPeminjam->namaLengkap }}">{{ $namaPeminjam->namaLengkap }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mt-3">
                <select class="form-select" name="tanggalPeminjaman" aria-label="Default select example">
                    <option selected value="">Pilih Tanggal Peminjaman</option>
                    @foreach ($tanggalPeminjamans as $tanggalPeminjaman)
                        <option value="{{ $tanggalPeminjaman->tanggalPeminjaman }}">
                            {{ $tanggalPeminjaman->tanggalPeminjaman }}</option>
                    @endforeach
                </select>
            </div>

        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <table class="table shadow" style="border-radius: 5px;">
                    <thead>
                        <tr>
                            <th scope="col" class="p-3">Nama Peminjam</th>
                            <th scope="col" class="p-3">Judul Buku</th>
                            <th scope="col" class="p-3">Tanggal Peminjaman</th>
                            <th scope="col" class="p-3">Tanggal Pengembalian</th>
                            <th scope="col" class="p-3">Status</th>
                            <th scope="col" class="p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center">Pilih Filter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            function fetchPeminjamans() {
                var namaLengkap = $('select[name="namaPeminjam"]').val();
                var tanggalPeminjaman = $('select[name="tanggalPeminjaman"]').val();

                // Only proceed if both filters have values
                if (namaLengkap !== 'Pilih Nama Peminjam' && tanggalPeminjaman !== 'Pilih Tanggal Peminjaman') {
                    $.ajax({
                        url: "{{ route('admin.borrowing-search') }}",
                        type: "GET",
                        data: {
                            namaLengkap: namaLengkap,
                            tanggalPeminjaman: tanggalPeminjaman
                        },
                        success: function(response) {
                            var rows = '';

                            if (response.peminjamans.length > 0) {
                                $.each(response.peminjamans, function(index, peminjaman) {
                                    rows += '<tr>' +
                                        '<td class="p-3">' + peminjaman.namaLengkap + '</td>' +
                                        '<td class="p-3">' + peminjaman.judul + '</td>' +
                                        '<td class="p-3">' + peminjaman.tanggalPeminjaman +
                                        '</td>' +
                                        '<td class="p-3">' + (peminjaman.tanggalPengembalian ? peminjaman.tanggalPengembalian: 'Belum dikonfirmasi') +
                                        '</td>' +
                                        '<td class="p-3">' + (peminjaman.allReturned ?
                                            'Sudah dikembalikan' : 'Belum dikembalikan') +
                                        '</td>' +
                                        '<td class="p-3">' +
                                        '<a href="/admin/borrowing-edit/' + peminjaman.id +
                                        '">' +
                                        '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-pencil-square mx-3" viewBox="0 0 16 16">' +
                                        '<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>' +
                                        '<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>' +
                                        '</svg>' +
                                        '</a>' +
                                        '</td>' +
                                        '</tr>';
                                });
                            } else {
                                rows = '<tr><td colspan="6" class="text-center">Tidak Ada</td></tr>';
                            }

                            $('table tbody').html(rows);
                        }
                    });
                } else {
                    // Clear the table if no filters are selected
                    $('table tbody').html('<tr><td colspan="6" class="text-center">Pilih Filter</td></tr>');
                }
            }

            // Event listeners for select changes
            $('select[name="namaPeminjam"], select[name="tanggalPeminjaman"]').change(fetchPeminjamans);
        });
    </script>
@endsection
