<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - InvenSync</title>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            padding: 1.5rem;
            color: #1e293b;
        }
        .login-card {
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 380px;
            padding: 2rem;
        }
        .brand-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 8px;
            background: #2563eb;
            color: #ffffff;
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }
        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #334155;
            margin-bottom: 0.35rem;
        }
        .form-control {
            border-radius: 6px;
            border-color: #cbd5e1;
            font-size: 0.9rem;
            padding: 0.6rem 0.75rem;
        }
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }
        .btn-submit {
            background-color: #2563eb;
            border: none;
            color: #ffffff;
            border-radius: 6px;
            padding: 0.65rem;
            font-weight: 500;
            font-size: 0.9rem;
            transition: background 0.15s ease;
        }
        .btn-submit:hover {
            background-color: #1d4ed8;
            color: #ffffff;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <div class="brand-logo">
            <i class="bi bi-box-seam"></i>
        </div>
        <h5 class="fw-bold mb-1 text-dark">InvenSync</h5>
        <p class="text-muted small mb-0">Masuk ke akun Anda</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-2 px-3 small d-flex align-items-center mb-3 rounded-2" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            <div>{{ $errors->first() }}</div>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus autocomplete="username">
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required autocomplete="current-password">
        </div>

        <button type="submit" class="btn btn-submit w-100">
            Masuk
        </button>
    </form>
</div>

</body>
</html>
