@extends('layouts.main')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4 text-center">View {{ $title }}</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @if ($title == 'Detail Anggota')
                            <p class="card-text"><strong>ID Anggota:</strong> {{ $item->id_anggota }}</p>
                            <p class="card-text"><strong>Nama Depan:</strong> {{ $item->nama_depan }}</p>
                            <p class="card-text"><strong>Nama Belakang:</strong> {{ $item->nama_belakang }}</p>
                            <p class="card-text"><strong>Gelar Depan:</strong> {{ $item->gelar_depan }}</p>
                            <p class="card-text"><strong>Gelar Belakang:</strong> {{ $item->gelar_belakang }}</p>
                            <p class="card-text"><strong>Jabatan:</strong> {{ $item->jabatan == 'ketua' ? 'Ketua' : ($item->jabatan == 'wakil_ketua' ? 'Wakil Ketua' : 'Anggota') }}</p>
                            <p class="card-text"><strong>Status Pernikahan</strong> {{ $item->status_pernikahan == 'kawin' ? 'Kawin' : 'Belum Kawin' }}</p>
                            <p class="card-text"><strong>Jumlah Anak:</strong> {{ $item->jml_anak }}</p>
                            <a href="{{ route('anggotas.index') }}" class="btn btn-secondary mt-3">Back</a>
                        @elseif($title == 'Detail Komponen Gaji')
                            <p class="card-text"><strong>ID Komponen Gaji:</strong> {{ $item->id_komponen_gaji }}</p>
                            <p class="card-text"><strong>Nama Komponen:</strong> {{ $item->nama_komponen }}</p>
                            <p class="card-text"><strong>Kategori:</strong>
                                {{ $item->kategori == 'gaji_pokok' ? 'Gaji Pokok' : ($item->kategori == 'tunjangan_melekat' ? 'Tunjangan Melekat' : 'Tunjangan Lain') }}
                            </p>
                            <p class="card-text"><strong>Jabatan:</strong>
                                {{ $item->jabatan == 'ketua' ? 'Ketua' : ($item->jabatan == 'wakil_ketua' ? 'Wakil Ketua' : ($item->jabatan == 'anggota' ? 'Anggota' : 'Semua')) }}
                            </p>
                            <p class="card-text"><strong>Nominal:</strong> Rp{{ number_format($item->nominal, 0, ',', '.') }}</p>
                            <p class="card-text"><strong>Satuan</strong>
                                {{ $item->satuan == 'bulan' ? 'Bulan' : 'Periode' }}</p>
                            <a href="{{ route('komponen_gajis.index') }}" class="btn btn-secondary mt-3">Back</a>
                        @elseif($title == 'Detail Penggajian')
                            <div class="container mt-4">
                                <h2>Detail Penggajian</h2>
                                <div class="mb-3">
                                    <label class="form-label">ID Anggota</label>
                                    <input type="text" class="form-control" value="{{ $anggota->id_anggota }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control"
                                        value="{{ $anggota->nama_depan }} {{ $anggota->nama_belakang }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jabatan</label>
                                    <input type="text" class="form-control"
                                        value="{{ $anggota->jabatan == 'ketua' ? 'Ketua' : ($anggota->jabatan == 'wakil_ketua' ? 'Wakil Ketua' : 'Anggota') }}"
                                        readonly>
                                </div>
                                <h4 class="mt-4">Daftar Komponen Gaji</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama Komponen</th>
                                            <th>Nominal</th>
                                            <th>Satuan</th>
                                            @if (session('role') === 'admin')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($komponenGaji as $item)
                                            <tr>
                                                <td>{{ $item->nama_komponen }}</td>
                                                <td>Rp{{ number_format($item->nominal * $anggota->jml_anak, 0, ',', '.') }}</td>
                                                <td>{{ ucfirst($item->satuan) }}</td>
                                                @if (session('role') === 'admin')
                                                    <td>
                                                        <a href="{{ route('penggajians.edit', ['id_anggota' => $anggota->id_anggota, 'id_komponen_gaji' => $item->id_komponen_gaji]) }}"
                                                            class="btn btn-warning btn-sm">Edit</a>
                                                        <form
                                                            action="{{ route('penggajians.destroy', ['id_anggota' => $anggota->id_anggota, 'id_komponen_gaji' => $item->id_komponen_gaji]) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure you want to delete this data?')">Delete</button>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-4">
                                    <h5>Total Take Home Pay</h5>
                                    <p><strong>Bulan:</strong> Rp{{ number_format($totalBulanan, 0, ',', '.') }}</p>
                                    <p><strong>Periode:</strong> Rp{{ number_format($totalPeriode, 0, ',', '.') }}</p>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('penggajians.index') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
