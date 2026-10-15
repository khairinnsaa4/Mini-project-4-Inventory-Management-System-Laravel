<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique Access | Maison Sole Atelier</title>
    <!-- Google Fonts: Playfair Display & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --rouge-primary: #8B1538;
            --rouge-hover: #720E2C;
            --bg-lux: #FAF7F5;
            --card-border: #EFE7E2;
            --obsidian: #18181B;
        }

        body {
            background-color: var(--bg-lux);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            padding: 1.5rem;
            color: #27272A;
            background-image: radial-gradient(circle at 10% 20%, rgba(139, 21, 56, 0.04) 0%, transparent 40%),
                              radial-gradient(circle at 90% 80%, rgba(197, 160, 89, 0.06) 0%, transparent 40%);
        }

        .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: #FFFFFF;
            border: 1px solid var(--card-border);
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(139, 21, 56, 0.06);
            overflow: hidden;
        }

        .login-brand-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--rouge-primary), #B31B47);
            color: #FFFFFF;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1rem auto;
            box-shadow: 0 6px 18px rgba(139, 21, 56, 0.25);
        }

        .form-control {
            border-radius: 8px;
            border-color: #E4DCD7;
            padding: 0.65rem 0.95rem;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: var(--rouge-primary);
            box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.12);
        }

        .btn-primary {
            background-color: var(--rouge-primary);
            border-color: var(--rouge-primary);
            color: #FFFFFF;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 8px;
            letter-spacing: 0.3px;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--rouge-hover);
            border-color: var(--rouge-hover);
            box-shadow: 0 4px 14px rgba(139, 21, 56, 0.3);
        }

        .test-badge {
            cursor: pointer;
            transition: background-color 0.15s ease;
        }

        .test-badge:hover {
            background-color: #FDF2F4 !important;
            border-color: var(--rouge-primary) !important;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="p-4 p-sm-5">
        <div class="text-center mb-4">
            <div class="login-brand-icon">
                <i class="bi bi-gem"></i>
            </div>
            <h4 class="fw-bold mb-1 font-serif text-dark" style="letter-spacing: 0.02em;">Maison Sole</h4>
            <p class="text-muted small mb-0 text-uppercase" style="letter-spacing: 1.5px; font-size: 0.72rem;">Haute Heels Boutique Atelier (Laravel)</p>
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
                <label for="username" class="form-label small fw-semibold text-muted">Username Pengguna</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #E4DCD7;"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control border-start-0 @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" placeholder="Contoh: admin atau staff" required autofocus autocomplete="username">
                </div>
                @error('username')
                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label small fw-semibold text-muted">Kata Sandi (Password)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #E4DCD7;"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password Anda" required autocomplete="current-password">
                </div>
                @error('password')
                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 shadow-sm mb-3">
                Masuk ke Atelier
            </button>
        </form>

        <div class="border-top pt-3 mt-4 text-center">
            <p class="text-muted small mb-2 fw-semibold" style="font-size: 0.75rem;">Akun Uji Coba Cepat (Klik untuk isi):</p>
            <div class="d-flex justify-content-center gap-2">
                <span class="badge bg-light text-dark border p-2 test-badge" onclick="fillLogin('admin', 'password123')">
                    <i class="bi bi-shield-lock-fill text-danger me-1"></i> Admin: <strong>admin</strong>
                </span>
                <span class="badge bg-light text-dark border p-2 test-badge" onclick="fillLogin('staff', 'password123')">
                    <i class="bi bi-person-badge text-secondary me-1"></i> Staff: <strong>staff</strong>
                </span>
            </div>
            <div class="text-muted mt-2" style="font-size: 0.7rem;">Password: <code>password123</code></div>
        </div>
    </div>
</div>

<script>
function fillLogin(user, pass) {
    document.getElementById('username').value = user;
    document.getElementById('password').value = pass;
}
</script>

</body>
</html>
