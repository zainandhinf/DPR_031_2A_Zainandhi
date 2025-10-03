@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Data Anggota</h2>
            @if (session('role') === 'admin')
                <a href="{{ route('anggotas.create') }}" class="btn btn-primary">Add Data</a>
            @endif
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
                        <th>ID Anggota</th>
                        <th>Nama Depan</th>
                        <th>Nama Belakang</th>
                        <th>Gelar Depan</th>
                        <th>Gelar Belakang</th>
                        <th>Jabatan</th>
                        <th>Status Pernikahan</th>
                        @if (session('role') === 'admin')
                            <th>Action</th>
                        @endif
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
        let role = "{{ session('role') }}";
        let tbody = document.getElementById("tableBody");

        if (items.length === 0) {
            tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-muted text-center">Data not found</td>
            </tr>
        `;
        } else {
            items.forEach(item => {
                let showUrl = "{{ route('anggotas.show', ':id') }}".replace(':id', item.id_anggota);
                let editUrl = "{{ route('anggotas.edit', ':id') }}".replace(':id', item.id_anggota);
                let destroyUrl = "{{ route('anggotas.destroy', ':id') }}".replace(':id', item.id_anggota);

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
                    <td>${ item.id_anggota }</td>
                    <td>${ item.nama_depan }</td>
                    <td>${ item.nama_belakang }</td>
                    <td>${ item.gelar_depan }</td>
                    <td>${ item.gelar_belakang }</td>
                    <td>${ item.jabatan == 'ketua' ? 'Ketua' : (item.jabatan == 'wakil_ketua' ? 'Wakil Ketua' : 'Anggota') }</td>
                    <td>${ item.status_pernikahan == 'kawin' ? 'Kawin' : 'Belum Kawin' }</td>
                    <td>${ role === 'admin' ? actions : '' }</td>
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
