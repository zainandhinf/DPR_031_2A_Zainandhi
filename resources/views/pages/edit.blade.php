@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0">Edit Data {{ $title }}</h4>
                    </div>
                    <div class="card-body">

                        {{-- FORM EDIT ANGGOTA --}}
                        @if ($title == 'Anggota')
                            <form method="POST" action="{{ route('anggotas.update', $item->id_anggota) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Nama Depan</label>
                                    <input type="text" name="nama_depan" value="{{ old('nama_depan',$item->nama_depan) }}"
                                        class="form-control @error('nama_depan') is-invalid @enderror" required>
                                    @error('nama_depan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Belakang</label>
                                    <input type="text" name="nama_belakang" value="{{ old('nama_belakang', $item->nama_belakang) }}"
                                        class="form-control @error('nama_belakang') is-invalid @enderror" required>
                                    @error('nama_belakang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gelar Depan</label>
                                    <input type="text" name="gelar_depan" value="{{ old('gelar_depan', $item->gelar_depan) }}"
                                        class="form-control @error('gelar_depan') is-invalid @enderror" required>
                                    @error('gelar_depan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gelar Belakang</label>
                                    <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang', $item->gelar_belakang) }}"
                                        class="form-control @error('gelar_belakang') is-invalid @enderror" required>
                                    @error('gelar_belakang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jabatan</label>
                                    <select name="jabatan"
                                        class="{{ $errors->has('jabatan') ? 'border-red' : '' }} form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="ketua" {{ old('ketua') == 'ketua' ? 'selected' : '' }}>Ketua
                                        </option>
                                        <option value="wakil_ketua"
                                            {{ old('wakil_ketua') == 'wakil_ketua' ? 'selected' : '' }}>Wakil Ketua
                                        </option>
                                        <option value="anggota" {{ old('anggota') == 'anggota' ? 'selected' : '' }}>Anggota
                                        </option>
                                    </select>
                                    @error('jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status Pernikahan</label>
                                    <select name="status_pernikahan"
                                        class="{{ $errors->has('status_pernikahan') ? 'border-red' : '' }} form-control"
                                        required>
                                        <option value="">-- Pilih --</option>
                                        <option value="kawin" {{ old('kawin') == 'kawin' ? 'selected' : '' }}>Kawin
                                        </option>
                                        <option value="belum_kawin"
                                            {{ old('belum_kawin') == 'belum_kawin' ? 'selected' : '' }}>Belum Kawin
                                        </option>
                                    </select>
                                    @error('status_pernikahan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('anggotas.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
