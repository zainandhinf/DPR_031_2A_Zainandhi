@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Data Penggajian</h2>
            <a href="{{ route('penggajians.create') }}" class="btn btn-primary">Add Data</a>
        </div>

        <form method="GET" action="{{ url()->current() }}" class="d-flex mb-3">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2"
                placeholder="Search...">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
@endsection
