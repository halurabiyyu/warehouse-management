<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/img/logorw03.jpg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Warehouse Management</title>
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
            <h5 class="fw-bold">Welcome, Warehouse Management</h5>
            <p>Platform untuk mencatat gudang dan pengelolaan barang perusahaan</p>
        </div>
        <div class="text-center mb-4">
            <a href="{{ route('login') }}" class="btn btn-primary px-4">Login</a>
        </div>
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
</body>

</html>