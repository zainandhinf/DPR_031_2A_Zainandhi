@extends('layouts.main')

@section('content')
    <h1>Add {{ $title }} Data</h1>

    {{-- FORM ANGGOTA --}}
    @if ($title == 'Anggota')
        <form method="POST" action="{{ route('anggotas.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Depan</label>
                <input type="text" name="nama_depan" value="{{ old('nama_depan') }}"
                    class="form-control @error('nama_depan') is-invalid @enderror" required>
                @error('nama_depan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Belakang</label>
                <input type="text" name="nama_belakang" value="{{ old('nama_belakang') }}"
                    class="form-control @error('nama_belakang') is-invalid @enderror" required>
                @error('nama_belakang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Gelar Depan</label>
                <input type="text" name="gelar_depan" value="{{ old('gelar_depan') }}"
                    class="form-control @error('gelar_depan') is-invalid @enderror" required>
                @error('gelar_depan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Gelar Belakang</label>
                <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang') }}"
                    class="form-control @error('gelar_belakang') is-invalid @enderror" required>
                @error('gelar_belakang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <select name="jabatan" class="{{ $errors->has('jabatan') ? 'border-red' : '' }} form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="ketua" {{ old('ketua') == 'ketua' ? 'selected' : '' }}>Ketua</option>
                    <option value="wakil_ketua" {{ old('wakil_ketua') == 'wakil_ketua' ? 'selected' : '' }}>Wakil Ketua
                    </option>
                    <option value="anggota" {{ old('anggota') == 'anggota' ? 'selected' : '' }}>Anggota</option>
                </select>
                @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Status Pernikahan</label>
                <select name="status_pernikahan" class="{{ $errors->has('status_pernikahan') ? 'border-red' : '' }} form-control"
                    required>
                    <option value="">-- Pilih --</option>
                    <option value="kawin" {{ old('kawin') == 'kawin' ? 'selected' : '' }}>Kawin</option>
                    <option value="belum_kawin" {{ old('belum_kawin') == 'belum_kawin' ? 'selected' : '' }}>Belum Kawin
                    </option>
                </select>
                @error('status_pernikahan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('anggotas.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    @endif
@endsection
