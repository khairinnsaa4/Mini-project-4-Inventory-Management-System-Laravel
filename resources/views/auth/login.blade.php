<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akses Atelier | Maison Sole</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --rouge-primary: #8B1538;
            --rouge-hover: #700F2B;
            --rouge-light: #FDF2F4;
            --gold-accent: #C5A059;
            --bg-body: #FBF9F7;
            --border-soft: #EFE7E2;
            --text-dark: #1C1917;
            --text-muted: #78716C;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-body);
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(139, 21, 56, 0.04) 0%, transparent 45%),
                radial-gradient(circle at 85% 85%, rgba(197, 160, 89, 0.05) 0%, transparent 45%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            color: var(--text-dark);
            padding: 1.5rem;
            margin: 0;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #FFFFFF;
            border: 1px solid var(--border-soft);
            border-radius: 16px;
            box-shadow: 0 12px 36px rgba(28, 25, 23, 0.05);
            padding: 2.75rem 2.25rem;
        }

        .brand-emblem {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, var(--rouge-primary), #A61A43);
            color: #FFFFFF;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin: 0 auto 1.25rem auto;
            box-shadow: 0 8px 20px rgba(139, 21, 56, 0.22);
        }

        .brand-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.01em;
            margin-bottom: 0.25rem;
        }

        .brand-subtitle {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 2rem;
        }

        .form-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: #44403C;
            margin-bottom: 0.4rem;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group-custom .input-icon {
            position: absolute;
            left: 14px;
            color: #A8A29E;
            font-size: 1rem;
            pointer-events: none;
            transition: color 0.2s ease;
            z-index: 5;
        }

        .input-group-custom .form-control {
            border: 1px solid #E7DFD9;
            border-radius: 10px;
            padding: 0.72rem 1rem 0.72rem 2.6rem;
            font-size: 0.92rem;
            color: var(--text-dark);
            background-color: #FCFBFB;
            transition: all 0.2s ease;
            width: 100%;
        }

        .input-group-custom .form-control:focus {
            background-color: #FFFFFF;
            border-color: var(--rouge-primary);
            box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.1);
            outline: none;
        }

        .input-group-custom .toggle-password {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: #A8A29E;
            cursor: pointer;
            padding: 4px;
            font-size: 1.05rem;
            z-index: 5;
        }

        .input-group-custom .toggle-password:hover {
            color: var(--text-dark);
        }

        .btn-atelier {
            background-color: var(--rouge-primary);
            border: none;
            color: #FFFFFF;
            font-size: 0.92rem;
            font-weight: 600;
            padding: 0.82rem;
            border-radius: 10px;
            width: 100%;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(139, 21, 56, 0.22);
            margin-top: 0.75rem;
        }

        .btn-atelier:hover {
            background-color: var(--rouge-hover);
            box-shadow: 0 6px 18px rgba(139, 21, 56, 0.32);
            color: #FFFFFF;
        }

        .login-footer {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #F5EFEB;
            text-align: center;
            font-size: 0.75rem;
            color: #A8A29E;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center">
        <div class="brand-emblem">
            <i class="bi bi-gem"></i>
        </div>
        <h1 class="brand-title">Maison Sole</h1>
        <p class="brand-subtitle">Haute Heels Atelier</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger py-2 px-3 small d-flex align-items-center mb-3 rounded-2 border-0 shadow-sm" style="background-color: #FEF2F2; color: #991B1B;">
            <i class="bi bi-exclamation-circle-fill me-2 fs-6"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <form method="POST" action="{{ route('login.proses') }}">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <div class="input-group-custom">
                <i class="bi bi-person input-icon"></i>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" placeholder="Masukkan username" required autofocus autocomplete="username">
            </div>
            @error('username')
                <small class="text-danger mt-1 d-block">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Kata Sandi</label>
            <div class="input-group-custom">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan kata sandi" required autocomplete="current-password" style="padding-right: 2.5rem;">
                <button type="button" class="toggle-password" onclick="togglePasswordVisibility()" title="Tampilkan sandi">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </button>
            </div>
            @error('password')
                <small class="text-danger mt-1 d-block">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-atelier">
            Masuk ke Atelier
        </button>
    </form>

    <div class="login-footer">
        <span>Sistem Inventaris Persediaan Butik Resmi</span>
    </div>
</div>

<script>
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    }
}
</script>

</body>
</html>
