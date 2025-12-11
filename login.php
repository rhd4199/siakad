<?php
require_once __DIR__ . '/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (attempt_login($email, $password)) {
        $user = current_user();
        switch ($user['role']) {
            case 'superadmin':
                header('Location: /siakad/superadmin/index.php');
                break;
            case 'admin':
                header('Location: /siakad/admin/index.php');
                break;
            case 'tutor':
                header('Location: /siakad/tutor/index.php');
                break;
            case 'peserta':
                header('Location: /siakad/peserta/index.php');
                break;
            default:
                header('Location: /siakad/index.php');
        }
        exit;
    } else {
        $error = 'Email atau password salah.';
    }
}

if (current_user()) {
    header('Location: /siakad/index.php');
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login - SIAKAD LPK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.4);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            --primary-color: #4e73df;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            overflow: hidden;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating Shapes */
        .shape {
            position: absolute;
            filter: blur(50px);
            z-index: 0;
            animation: float 20s infinite;
        }
        .shape-1 {
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
        }
        .shape-2 {
            bottom: -10%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation-delay: -5s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(20px, 20px) rotate(10deg); }
            100% { transform: translate(0, 0) rotate(0deg); }
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
            border-radius: 24px;
            width: 100%;
            max-width: 420px;
            padding: 3rem 2.5rem;
            position: relative;
            z-index: 1;
            transform: translateY(0);
            transition: transform 0.3s;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: white;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 20px rgba(78, 115, 223, 0.3);
        }

        .form-floating .form-control {
            border-radius: 12px;
            border: 1px solid rgba(0,0,0,0.1);
            background: rgba(255,255,255,0.5);
        }
        .form-floating .form-control:focus {
            background: white;
            box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.15);
            border-color: #4e73df;
        }

        .btn-login {
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
            box-shadow: 0 10px 20px rgba(78, 115, 223, 0.2);
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(78, 115, 223, 0.3);
            background: linear-gradient(135deg, #224abe 0%, #1a3a9c 100%);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: #6c757d;
            font-size: 0.85rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        .divider::before { margin-right: .5em; }
        .divider::after { margin-left: .5em; }

        .demo-accounts {
            background: rgba(255,255,255,0.5);
            border-radius: 12px;
            padding: 1rem;
            font-size: 0.8rem;
            border: 1px dashed rgba(0,0,0,0.1);
        }
        
        .role-badge {
            font-size: 0.65rem;
            padding: 2px 6px;
            border-radius: 4px;
            background: #e9ecef;
            color: #495057;
            font-weight: 600;
            margin-right: 5px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="login-card fade-in-up">
        <div class="d-flex flex-column align-items-center text-center">
            <div class="brand-logo">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h4 class="fw-bold text-dark mb-1">Selamat Datang</h4>
            <p class="text-muted small mb-4">Silakan masuk untuk melanjutkan akses ke SIAKAD LPK.</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center p-3 mb-4">
                <i class="bi bi-exclamation-circle-fill fs-5 me-2"></i>
                <div class="small"><?= htmlspecialchars($error) ?></div>
            </div>
        <?php endif; ?>

        <form method="post" autocomplete="off">
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                <label for="floatingInput">Alamat Email</label>
            </div>
            <div class="form-floating mb-4">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label small text-muted" for="rememberMe">
                        Ingat Saya
                    </label>
                </div>
                <a href="#" class="text-decoration-none small fw-semibold text-primary">Lupa Password?</a>
            </div>

            <button type="submit" class="btn btn-primary btn-login w-100 mb-3">
                Masuk Sekarang
            </button>
        </form>

        <div class="divider">Demo Accounts</div>

        <div class="demo-accounts">
            <div class="d-flex justify-content-between mb-2">
                <div><span class="role-badge">Super</span> superadmin@lpk.test</div>
                <div class="text-muted">super123</div>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <div><span class="role-badge">Admin</span> admin@lpk.test</div>
                <div class="text-muted">admin123</div>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <div><span class="role-badge">Tutor</span> tutor@lpk.test</div>
                <div class="text-muted">tutor123</div>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <div><span class="role-badge">Peserta</span> peserta@lpk.test</div>
                <div class="text-muted">peserta123</div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <p class="extra-small text-muted mb-0">&copy; <?= date('Y') ?> Depati Akademi LPK System</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
