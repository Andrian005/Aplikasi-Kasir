<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-primary">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row bg-white rounded shadow overflow-hidden" style="max-width: 800px; width: 100%;">

            <div class="col-md-6 d-none d-md-flex justify-content-center align-items-center bg-light">
                <img src="{{ asset('images/kasir.png') }}" alt="Cashier Illustration" class="img-fluid">
            </div>

            <div class="col-md-6 p-4">
                <div class="text-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid mb-3 w-25">
                    <h2 class="h5">Web Kasir</h2>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger fade show" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('auth') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                            placeholder="Masukkan email">
                        @error('email')
                            <div class="text-danger">
                                *{{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            value="{{ old('password') }}" placeholder="Masukkan password">
                        @error('password')
                            <div class="text-danger">
                                *{{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <div class="text-center text-muted mt-3">
                    <small>&copy; 2025 Kasir</small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
