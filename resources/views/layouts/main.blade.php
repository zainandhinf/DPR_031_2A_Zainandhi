<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .menu a.active {
            background-color: #0d6efd;
            color: white !important;
            border-radius: 6px;
        }

        input.border-red,
        select.border-red {
            border: 2px solid red !important;
            background-color: #ffecec;
        }

        .error-message {
            color: red;
            font-size: 0.85em;
            margin-top: 4px;
        }

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 250px;
        }
    </style>
</head>

<body class="bg-light">

    <!-- Header -->
    <header class="bg-primary text-white text-center py-3">
        <h2>APLIKASI PENGHITUNGAN & TRANSPARANSI GAJI DPR</h2>
        <h5>Welcome {{ auth()->user()->username }}</h5>
    </header>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="/home">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse menu" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ $title == 'Anggota' ? 'active' : '' }}"
                            href="{{ route('anggotas.index') }}">Anggota</a>
                    </li>
                    @if (session('role') == 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ $title == 'Pengguna' ? 'active' : '' }}"
                                href="{{ route('penggunas.index') }}">Pengguna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $title == 'Komponen Gaji' ? 'active' : '' }}"
                                href="{{ route('komponen_gajis.index') }}">Komponen Gaji</a>
                        </li>
                    @endif
                </ul>

                <!-- Logout -->
                <form action="/logout" method="POST" class="d-flex">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="container mb-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center py-3 border-top">
        <b>Bandung - Jawa Barat</b>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Alert auto-dismiss -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const successMsg = @json(session('success'));
            const errorMsg = @json(session('error'));

            if (successMsg) showAlert('success', successMsg);
            if (errorMsg) showAlert('danger', errorMsg);

            function showAlert(type, message) {
                const div = document.createElement('div');
                div.classList.add('alert', `alert-${type}`, 'fade', 'show');
                div.setAttribute('role', 'alert');
                div.textContent = message;

                document.body.appendChild(div);

                setTimeout(() => {
                    div.classList.remove('show');
                    div.classList.add('hide');
                    setTimeout(() => div.remove(), 500);
                }, 3000);
            }
        });
    </script>

    @yield('script')
</body>

</html>
