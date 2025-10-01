@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Data Pengguna</h2>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Nama Depan</th>
                    <th>Nama Belakang</th>
                    <th>Role</th>
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
                <td colspan="4" class="text-center text-muted">Data not found</td>
            </tr>
        `;
    } else {
        items.forEach(item => {
            let showUrl = "{{ route('penggunas.show', ':id') }}".replace(':id', item.id);
            let destroyUrl = "{{ route('penggunas.destroy', ':id') }}".replace(':id', item.id);

            let actions = `
                <a href="${showUrl}" class="btn btn-info btn-sm me-1">View</a>
                <form action="${destroyUrl}" method="POST" class="d-inline deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            `;

            let row = `
                <tr>
                    <td>${ item.username }</td>
                    <td>${ item.email }</td>
                    <td>${ item.nama_depan }</td>
                    <td>${ item.nama_belakang }</td>
                    <td><span class="badge bg-primary">${ item.role }</span></td>
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
