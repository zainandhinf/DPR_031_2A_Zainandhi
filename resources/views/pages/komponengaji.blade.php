@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Data Komponen Gaji</h2>
            <a href="{{ route('komponen_gajis.create') }}" class="btn btn-primary">Add Data</a>
        </div>

        <form method="GET" action="{{ url()->current() }}" class="d-flex mb-3">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2"
                placeholder="Search...">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID Komponen Gaji</th>
                        <th>Nama Komponen</th>
                        <th>Kategori</th>
                        <th>Jabatan</th>
                        <th>Nominal</th>
                        <th>Satuan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let items = @json($items);
        let tbody = document.getElementById("tableBody");

        if (items.length === 0) {
            tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-muted text-center">Data not found</td>
            </tr>
        `;
        } else {
            items.forEach(item => {
                let showUrl = "{{ route('komponen_gajis.show', ':id') }}".replace(':id', item.id_komponen_gaji);
                let editUrl = "{{ route('komponen_gajis.edit', ':id') }}".replace(':id', item.id_komponen_gaji);
                let destroyUrl = "{{ route('komponen_gajis.destroy', ':id') }}".replace(':id', item.id_komponen_gaji);

                let actions = `
                <a href="${showUrl}" class="btn btn-info btn-sm me-1">View</a>
                <a href="${editUrl}" class="btn btn-warning btn-sm me-1">Edit</a>
                <form action="${destroyUrl}" method="POST" class="d-inline deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            `;

                let row = `
                <tr>
                    <td>${ item.id_komponen_gaji }</td>
                    <td>${ item.nama_komponen }</td>
                    <td>${ item.kategori == 'gaji_pokok' ? 'Gaji Pokok' : (item.kategori == 'tunjangan_melekat' ? 'Tunjangan Melekat' : 'Tunjangan Lain') }</td>
                    <td>${ item.jabatan == 'ketua' ? 'Ketua' : (item.jabatan == 'wakil_ketua' ? 'Wakil Ketua' : ( item.jabatan == 'anggota' ? 'Anggota' : 'Semua')) }</td>
                    <td>${ item.nominal }</td>
                    <td>${ item.satuan == 'bulan' ? 'Bulan' : 'Periode' }</td>
                    <td>${ actions }</td>
                </tr>
            `;

                tbody.innerHTML += row;
            });
        }

        document.addEventListener("submit", function(e) {
            if (e.target.classList.contains("deleteForm")) {
                if (!confirm("Are you sure you want to delete this data?")) {
                    e.preventDefault();
                }
            }
        });
    </script>
@endsection
