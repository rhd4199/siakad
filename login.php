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
    <title>Masuk - SIAKAD LPK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
            background-color: #fff;
        }

        .login-container {
            min-height: 100vh;
        }

        /* Left Side - Visual */
        .visual-side {
            background: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%);
            position: relative;
            overflow: hidden;
        }

        .visual-content {
            position: relative;
            z-index: 2;
            padding: 4rem;
            color: white;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Abstract Shapes Background */
        .shape-blob {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(40px);
            z-index: 1;
            animation: float-blob 20s infinite ease-in-out;
        }
        .blob-1 { width: 400px; height: 400px; top: -100px; right: -100px; }
        .blob-2 { width: 300px; height: 300px; bottom: -50px; left: -50px; animation-delay: -5s; }
        .blob-3 { width: 200px; height: 200px; top: 40%; left: 40%; animation-delay: -10s; background: rgba(72, 149, 239, 0.2); }

        @keyframes float-blob {
            0%, 100% { transform: translate(0, 0); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 2rem;
            margin-top: auto;
        }

        /* Right Side - Form */
        .form-side {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background-color: #ffffff;
        }

        .form-wrapper {
            width: 100%;
            max-width: 450px;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            background: var(--primary-color);
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }

        .form-control {
            padding: 0.8rem 1rem;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            background-color: #f8f9fa;
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        .form-control:focus {
            background-color: #fff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.8rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }

        .social-btn {
            border: 1px solid #e0e0e0;
            background: #fff;
            color: #333;
            font-weight: 500;
            padding: 0.7rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s;
            text-decoration: none;
        }
        .social-btn:hover {
            background: #f8f9fa;
            border-color: #ccc;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #adb5bd;
            margin: 1.5rem 0;
            font-size: 0.85rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }
        .divider::before { margin-right: .5em; }
        .divider::after { margin-left: .5em; }

        .demo-box {
            background: #f8f9fa;
            border: 1px dashed #dee2e6;
            border-radius: 12px;
            padding: 1rem;
            font-size: 0.85rem;
        }

        .role-tag {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            background: #e9ecef;
            color: #495057;
            margin-right: 8px;
        }

        /* Animation */
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 991px) {
            .visual-side {
                display: none;
            }
            .form-side {
                background: #fff;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0 login-container">
        <!-- Left Side: Visual -->
        <div class="col-lg-6 visual-side d-none d-lg-block">
            <div class="shape-blob blob-1"></div>
            <div class="shape-blob blob-2"></div>
            <div class="shape-blob blob-3"></div>
            
            <div class="visual-content">
                <div>
                    <h3 class="fw-bold mb-2"><i class="bi bi-mortarboard-fill me-2"></i>SIAKAD LPK</h3>
                    <p class="text-white-50">Sistem Informasi Akademik Terintegrasi</p>
                </div>
                
                <div class="glass-card mb-5">
                    <div class="d-flex mb-3 text-warning">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill ms-1"></i>
                        <i class="bi bi-star-fill ms-1"></i>
                        <i class="bi bi-star-fill ms-1"></i>
                        <i class="bi bi-star-fill ms-1"></i>
                    </div>
                    <p class="mb-3 fs-5">"Platform ini sangat membantu saya dalam mengelola jadwal belajar dan memantau progress materi secara real-time. UI-nya sangat modern dan mudah digunakan!"</p>
                    <div class="d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name=Sarah+Putri&background=random&size=40" class="rounded-circle me-3" alt="User">
                        <div>
                            <div class="fw-bold">Sarah Putri</div>
                            <div class="small text-white-50">Peserta Web Development</div>
                        </div>
                    </div>
                </div>

                <div class="small text-white-50">
                    &copy; <?= date('Y') ?> Depati Akademi. All rights reserved.
                </div>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="col-lg-6 form-side">
            <div class="form-wrapper fade-in">
                <div class="d-lg-none mb-4 text-center">
                    <div class="brand-icon mx-auto mb-3">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <h3 class="fw-bold">SIAKAD LPK</h3>
                </div>

                <div class="mb-5">
                    <h2 class="fw-bold mb-2">Selamat Datang Kembali! 👋</h2>
                    <p class="text-muted">Silakan masukkan detail akun Anda untuk memulai.</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger border-0 d-flex align-items-center mb-4 rounded-3 bg-danger-subtle text-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div><?= htmlspecialchars($error) ?></div>
                    </div>
                <?php endif; ?>

                <form method="post" autocomplete="off">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted ps-3"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control border-start-0 ps-2" placeholder="nama@email.com" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-muted text-uppercase">Password</label>
                            <a href="#" class="text-decoration-none small fw-semibold text-primary">Lupa Password?</a>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted ps-3"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control border-start-0 ps-2" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="remember">
                        <label class="form-check-label text-muted small" for="remember">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-4 shadow-sm">
                        Masuk ke Akun
                    </button>
                    
                    <!-- Social Login (Visual Only) -->
                    <div class="divider">Atau masuk dengan</div>
                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <a href="#" class="social-btn">
                                <i class="bi bi-google text-danger"></i> Google
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="social-btn">
                                <i class="bi bi-microsoft text-primary"></i> Microsoft
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Demo Accounts Section -->
                <div class="mt-5">
                    <p class="text-center small text-muted mb-3">Akun Demo (Klik untuk menyalin)</p>
                    <div class="demo-box">
                        <div class="row g-2">
                            <div class="col-6 cursor-pointer" onclick="fillLogin('peserta@lpk.test', 'peserta123')">
                                <div class="d-flex align-items-center p-2 border rounded bg-white h-100 hover-shadow transition-all">
                                    <span class="role-tag">PESERTA</span>
                                    <div class="small text-truncate">peserta@lpk.test</div>
                                </div>
                            </div>
                            <div class="col-6 cursor-pointer" onclick="fillLogin('tutor@lpk.test', 'tutor123')">
                                <div class="d-flex align-items-center p-2 border rounded bg-white h-100 hover-shadow transition-all">
                                    <span class="role-tag">TUTOR</span>
                                    <div class="small text-truncate">tutor@lpk.test</div>
                                </div>
                            </div>
                            <div class="col-6 cursor-pointer" onclick="fillLogin('admin@lpk.test', 'admin123')">
                                <div class="d-flex align-items-center p-2 border rounded bg-white h-100 hover-shadow transition-all">
                                    <span class="role-tag">ADMIN</span>
                                    <div class="small text-truncate">admin@lpk.test</div>
                                </div>
                            </div>
                            <div class="col-6 cursor-pointer" onclick="fillLogin('superadmin@lpk.test', 'super123')">
                                <div class="d-flex align-items-center p-2 border rounded bg-white h-100 hover-shadow transition-all">
                                    <span class="role-tag">SUPER</span>
                                    <div class="small text-truncate">super...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function fillLogin(email, password) {
        document.querySelector('input[name="email"]').value = email;
        document.querySelector('input[name="password"]').value = password;
        
        // Visual feedback
        const btn = document.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Siap Masuk!';
        btn.classList.replace('btn-primary', 'btn-success');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.replace('btn-success', 'btn-primary');
        }, 1500);
    }
</script>
</body>
</html>
