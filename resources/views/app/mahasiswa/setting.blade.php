@extends('layouts.main')
@section('title')
    Setting Mahasiswa
@endsection
@section('content')
    <div class="container">
        <div class="row my-5 justify-content-center">
            <div class="col-md-10">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="shadow rounded p-5">
                    <h5 class="text-center mb-4">Edit Profil Mahasiswa</h5>
                    <form action="{{ route('mahasiswa.setting.update', $mahasiswa->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 d-flex flex-column align-items-center mb-3">
                                <img src="{{ asset('img/' . $mahasiswa->fotoProfil) }}" alt="Profil" id="preview"
                                    class="img-fluid mb-2">
                                <input type="file" class="form-control" id="fotoProfil" name="fotoProfil"
                                    style="width: 75%" onchange="previewImage()">
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('namaLengkap') is-invalid @enderror"
                                        id="namaLengkap" name="namaLengkap"
                                        value="{{ old('namaLengkap', $mahasiswa->namaLengkap) }}">
                                    @error('namaLengkap')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nim" class="form-label">Nim</label>
                                    <input type="number" class="form-control @error('nim') is-invalid @enderror"
                                        id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}">
                                    @error('nim')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $mahasiswa->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Nohp</label>
                                    <input type="tel" class="form-control @error('nohp') is-invalid @enderror"
                                        id="nohp" name="nohp" value="{{ old('nohp', $mahasiswa->noHp) }}">
                                    @error('nohp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="angkatan" class="form-label">Angkatan</label>
                                    <select class="form-control @error('angkatan') is-invalid @enderror" id="angkatan"
                                        name="angkatan">
                                        <option value="" disabled selected>Pilih Angkatan</option>
                                        @for ($year = 2015; $year <= date('Y'); $year++)
                                            <option value="{{ $year }}"
                                                {{ old('angkatan', $mahasiswa->angkatan) == $year ? 'selected' : '' }}>
                                                {{ $year }}</option>
                                        @endfor
                                    </select>
                                    @error('angkatan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('mahasiswa.formChangePassword') }}" class="btn btn-primary border-0"
                                    style="background-color: #FFD460; width:100%">Change Password</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary border-0"
                                    style="background-color: #F07B3F; width:100%">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage() {
            const file = document.getElementById('fotoProfil').files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush
