@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Data Penggajian</h2>
            @if (session('role') === 'admin')
                <a href="{{ route('penggajians.create') }}" class="btn btn-primary">Add Data</a>
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
                        <th>Gelar Depan</th>
                        <th>Nama Depan</th>
                        <th>Nama Belakang</th>
                        <th>Gelar Belakang</th>
                        <th>Jabatan</th>
                        <th>Take Home Pay (Bulan)</th>
                        <th>Take Home Pay (Periode)</th>
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
        let role = "{{ session('role') }}";
        let tbody = document.getElementById("tableBody");

        const formatRupiah = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });


        if (items.length === 0) {
            tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-muted text-center">Data not found</td>
            </tr>
        `;
        } else {
            items.forEach(item => {
                let showUrl = "{{ route('penggajians.show', ':id') }}".replace(':id', item.id_anggota);

                let actions = `
                <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="${showUrl}" class="btn btn-info btn-sm">View</a>
                </div>
            `;

                let row = `
                <tr>
                    <td>${ item.id_anggota }</td>
                    <td>${ item.gelar_depan }</td>
                    <td>${ item.nama_depan }</td>
                    <td>${ item.nama_belakang }</td>
                    <td>${ item.gelar_belakang }</td>
                    <td>${ item.jabatan == 'ketua' ? 'Ketua' : (item.jabatan == 'wakil_ketua' ? 'Wakil Ketua' : 'Anggota') }</td>
                    <td>${ formatRupiah.format(item.take_home_pay_per_bulan) }</td>
                    <td>${ formatRupiah.format(item.take_home_pay_per_periode) }</td>
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
