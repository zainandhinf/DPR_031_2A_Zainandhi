@extends('layouts.main')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4 text-center">View {{ $title }}</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @if ($title == 'Detail Anggota')
                            <p class="card-text"><strong>Nama Depan:</strong> {{ $item->nama_depan }}</p>
                            <p class="card-text"><strong>Nama Belakang:</strong> {{ $item->nama_belakang }}</p>
                            <p class="card-text"><strong>Gelar Depan:</strong> {{ $item->gelar_depan }}</p>
                            <p class="card-text"><strong>Gelar Belakang:</strong> {{ $item->gelar_belakang }}</p>
                            <p class="card-text"><strong>Jabatan:</strong> {{ $item->jabatan }}</p>
                            <p class="card-text"><strong>Status Pernikahan</strong> {{ $item->status_pernikahan }}</p>
                            <a href="{{ route('anggotas.index') }}" class="btn btn-secondary mt-3">Back</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
