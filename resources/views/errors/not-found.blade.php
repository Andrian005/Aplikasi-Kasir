<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body class="d-flex align-items-center" style="min-height: 100vh;">
    <div class="container text-center">
        <img src="{{ asset('images/not-found.png') }}" alt="404 Not Found" class="img-fluid mb-4"
            style="max-width: 300px;">
        <h1 class="display-4">Halaman Tidak Ditemukan</h1>
        <p class="lead">Maaf, halaman yang Anda cari tidak ada.</p>
        <a href="{{ route('dashboard.dashboard') }}" class="btn btn-primary mt-3">Kembali ke Beranda</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
