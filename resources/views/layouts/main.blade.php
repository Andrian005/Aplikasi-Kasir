<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: #fff;
        }

        .sidebar a {
            color: #ddd;
            text-decoration: none;
        }

        .sidebar a:hover {
            color: #fff;
        }

        .topbar {
            background-color: #007bff;
            color: white;
        }

        .topbar .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .content-wrapper {
            padding: 20px;
        }

        .card-placeholder {
            height: 120px;
            background-color: #ddd;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 sidebar d-flex flex-column p-3">
            <h5 class="text-center mb-4">Kasir Kita</h5>
            <div class="text-center mb-4">
                <div class="rounded-circle bg-light mx-auto" style="width: 60px; height: 60px;"></div>
                <p class="mt-2">Andrian</p>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link">
                        <i class="bi bi-bar-chart"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link">
                        <i class="bi bi-box"></i> Product
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link">
                        <i class="bi bi-people"></i> Pelanggan
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link">
                        <i class="bi bi-cart"></i> Transaksi
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-gear"></i> Settings
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="col-md-10">
            <!-- Topbar -->
            <div class="topbar d-flex justify-content-between align-items-center p-3">
                <button class="btn btn-light d-md-none">
                    <i class="bi bi-list"></i>
                </button>
                <h6 class="m-0">Dashboard</h6>
                <div class="profile">
                    <span>Andrian</span>
                    <div class="rounded-circle bg-light" style="width: 40px; height: 40px;"></div>
                </div>
            </div>

            @yield('content')

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
