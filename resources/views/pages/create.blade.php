@extends('layouts.main')

@section('content')
    <h1>Add {{ $title }} Data</h1>

    {{-- FORM ANGGOTA --}}
    @if ($title == 'Anggota')
        <form method="POST" action="{{ route('anggotas.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">ID Anggota</label>
                <input type="text" name="id_anggota" value="{{ old('id_anggota', $nextId) }}"
                    class="form-control @error('id_anggota') is-invalid @enderror" required>
                @error('id_anggota')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
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
                <select name="status_pernikahan"
                    class="{{ $errors->has('status_pernikahan') ? 'border-red' : '' }} form-control" required>
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
    {{-- FORM KOMPONEN GAJI --}}
    @elseif($title == 'Komponen Gaji')
        <form method="POST" action="{{ route('komponen_gajis.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">ID Komponen Gaji</label>
                <input type="text" name="id_komponen_gaji" value="{{ old('id_komponen_gaji', $nextId) }}"
                    class="form-control @error('id_komponen_gaji') is-invalid @enderror" required>
                @error('id_komponen_gaji')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Komponen</label>
                <input type="text" name="nama_komponen" value="{{ old('nama_komponen') }}"
                    class="form-control @error('nama_komponen') is-invalid @enderror" required>
                @error('nama_komponen')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="{{ $errors->has('kategori') ? 'border-red' : '' }} form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="gaji_pokok" {{ old('gaji_pokok') == 'gaji_pokok' ? 'selected' : '' }}>Gaji Pokok
                    </option>
                    <option value="tunjangan_melekat"
                        {{ old('tunjangan_melekat') == 'tunjangan_melekat' ? 'selected' : '' }}>Tunjangan Melekat</option>
                    <option value="tunjangan_lain" {{ old('tunjangan_lain') == 'tunjangan_lain' ? 'selected' : '' }}>
                        Tunjangan Lain</option>
                </select>
                @error('kategori')
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
                    <option value="semua" {{ old('semua') == 'semua' ? 'selected' : '' }}>Semua</option>
                </select>
                @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Nominal</label>
                <input type="number" name="nominal" value="{{ old('nominal') }}"
                    class="form-control @error('nominal') is-invalid @enderror" required>
                @error('nominal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Satuan</label>
                <select name="satuan" class="{{ $errors->has('satuan') ? 'border-red' : '' }} form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="bulan" {{ old('bulan') == 'bulan' ? 'selected' : '' }}>Bulan</option>
                    <option value="periode" {{ old('periode') == 'periode' ? 'selected' : '' }}>Periode</option>
                </select>
                @error('satuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('komponen_gajis.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    @endif
@endsection
