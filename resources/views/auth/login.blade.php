<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
        background: url("{{ asset('assets/background.jpg') }}") no-repeat center center fixed;
        background-size: cover;
    }
        .bg-overlay {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px
            padding: 20px;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">

    <div class="card" style="width: 400px;">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">Login</h5>
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <p style="text-align: center;">
                Akses Demo
            </p>
            <p style="text-align: center;">
                Email: test@example.com
                Password: 12345
            </p>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>
</body>
</html>
