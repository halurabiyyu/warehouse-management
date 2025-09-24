<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/img/logorw03.jpg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0d6efd">
    <!-- iOS support -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Warehouse">

    <!-- Android support -->
    <meta name="mobile-web-app-capable" content="yes">
    <style>
        body {
            background-color: #1F2937;
            /* dark mode feel */
        }

        .card {
            background: #fff;
            border-radius: 1.5rem;
        }

        .mobile-first {
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 100%;
            max-width: 448px;
            margin: auto;
        }
    </style>
</head>

<body class="bg-body-tertiary d-flex align-items-center justify-content-center min-vh-100">
    <div class="mobile-first bg-white shadow rounded p-4" style="height: 100vh;">
        <div class="text-center mb-4">
            <img src="{{ asset('icons/icon.png') }}" alt="Logo" class="rounded-circle mb-2" width="80">
            <h3 class="fw-bold">LOGIN</h3>
        </div>

        @error('login_gagal')
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <span><strong>Warning!</strong> {{ $message }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror

        <form method="POST" action="{{ route('login-proses') }}">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    placeholder="Email" value="{{ old('email') }}">
                <label for="email">Email</label>
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" placeholder="Password">
                <label for="password">Password</label>
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- <div class="d-grid gap-2 mt-3">
                <button type="submit" class="btn btn-primary fw-bold">Login</button>
                <a href="{{ route('welcome2') }}" class="btn btn-outline-danger">Kembali</a>
            </div> --}}
            <div class="d-grid gap-2 mt-3">
                <button type="submit" id="loginBtn" class="btn btn-primary fw-bold">
                    <span class="btn-text">Login</span>
                    <span class="btn-spinner d-none">
                        <i class="fa-solid fa-spinner fa-spin"></i> Loading...
                    </span>
                </button>
                <a href="{{ route('welcome2') }}" class="btn btn-outline-danger">Kembali</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script>
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", function () {
                navigator.serviceWorker.register("{{ asset('serviceworker.js') }}")
                    .then(function (reg) {
                        console.log("Service Worker registered:", reg.scope);
                    })
                    .catch(function (err) {
                        console.log("Service Worker registration failed:", err);
                    });
            });
        }
    </script>
    <script>
        const loginBtn = document.getElementById("loginBtn");
        const form = loginBtn.closest("form");

        form.addEventListener("submit", function () {
            // disable button
            loginBtn.disabled = true;

            // toggle text <-> spinner
            loginBtn.querySelector(".btn-text").classList.add("d-none");
            loginBtn.querySelector(".btn-spinner").classList.remove("d-none");
        });
    </script>
</body>
</html>