<?php
require_once __DIR__ . '/config.php';
require_login(); // Pastikan user login

$user = current_user();
$role = $user['role'];

// Hapus session active_module saat masuk ke portal
if (isset($_SESSION['active_module'])) {
    unset($_SESSION['active_module']);
}

// Logic redirect jika modul dipilih
if (isset($_GET['select_module'])) {
    $module = $_GET['select_module'];
    $validModules = ['sim', 'elearning', 'cbt', 'raport'];
    
    // Validasi Akses Modul per Role
    if ($role === 'peserta' && $module === 'sim') {
        // Peserta tidak boleh akses SIM
        header("Location: portal.php");
        exit;
    }
    if ($role === 'tutor' && $module === 'raport') {
        // Tutor tidak boleh akses Raport
        header("Location: portal.php");
        exit;
    }

    if (in_array($module, $validModules)) {
        $_SESSION['active_module'] = $module;
        $redirectPath = '/siakad/' . $role . '/index.php';
        header("Location: $redirectPath");
        exit;
    }
}

$title = 'Portal Modul LMS';

// Logic Tampilan Modul
$showSim = ($role !== 'peserta');
$showRaport = ($role !== 'tutor');

// Admin tidak punya modul E-Learning dan CBT terpisah (digabung ke SIM)
if ($role === 'admin') {
    $showElearning = false;
    $showCbt = false;
} else {
    $showElearning = true;
    $showCbt = true;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Depati Akademi</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --bg-color: #f0f2f5;
            --glass-bg: rgba(255, 255, 255, 0.65);
            --glass-border: rgba(255, 255, 255, 0.4);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        /* Animated Background */
        .bg-animated {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: 
                radial-gradient(circle at 10% 20%, rgba(67, 97, 238, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(16, 185, 129, 0.15) 0%, transparent 40%),
                linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            background-size: 200% 200%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Dashboard Container - Bento Grid Style */
        .dashboard-container {
            width: 100%;
            max-width: 1200px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 40px;
            box-shadow: var(--glass-shadow);
            overflow: hidden;
            display: grid;
            grid-template-columns: 350px 1fr;
            min-height: 80vh;
        }

        /* Left Panel - Welcome Area */
        .welcome-panel {
            padding: 3rem;
            background: rgba(255, 255, 255, 0.5);
            border-right: 1px solid var(--glass-border);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
            margin-bottom: 2rem;
        }

        .user-profile-card {
            background: white;
            padding: 1.5rem;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            text-align: center;
            margin-top: auto;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 1rem;
            border: 4px solid #f8f9fa;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Right Panel - Modules Grid */
        .modules-panel {
            padding: 3rem;
            overflow-y: auto;
        }

        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        /* --- CARD DESIGN 2.0 (Compact & Modern) --- */
        .module-card {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            text-decoration: none;
            color: #1a1a1a;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 1px solid rgba(0,0,0,0.03);
            box-shadow: 0 10px 20px rgba(0,0,0,0.02);
            display: flex;
            flex-direction: column;
            height: 100%;
            transform-style: preserve-3d;
        }

        .module-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border-color: rgba(0,0,0,0);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            background: var(--theme-light);
            color: var(--theme-color);
            transition: all 0.4s ease;
        }

        .module-card:hover .card-icon {
            background: var(--theme-color);
            color: white;
            transform: scale(1.1) rotate(-5deg);
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .card-desc {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        .card-arrow {
            margin-top: auto;
            align-self: flex-end;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            transition: all 0.3s ease;
        }

        .module-card:hover .card-arrow {
            background: var(--theme-color);
            color: white;
            transform: translateX(5px);
        }

        /* Themes */
        .theme-sim {
            --theme-color: #4361ee;
            --theme-light: #eef2ff;
        }
        .theme-elearning {
            --theme-color: #10b981;
            --theme-light: #ecfdf5;
        }
        .theme-cbt {
            --theme-color: #f59e0b;
            --theme-light: #fffbeb;
        }
        .theme-raport {
            --theme-color: #8b5cf6;
            --theme-light: #f5f3ff;
        }

        /* Mobile Responsive */
        @media (max-width: 992px) {
            .dashboard-container {
                grid-template-columns: 1fr;
                height: auto;
                min-height: auto;
            }
            .welcome-panel {
                padding: 2rem;
                flex-direction: row;
                align-items: center;
                border-right: none;
                border-bottom: 1px solid var(--glass-border);
            }
            .user-profile-card {
                display: none;
            }
            .brand-logo {
                margin-bottom: 0;
            }
            .modules-panel {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>

    <div class="bg-animated"></div>

    <div class="dashboard-container" data-aos="zoom-in" data-aos-duration="800">
        
        <!-- Left Panel -->
        <div class="welcome-panel">
            <div>
                <div class="brand-logo">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h2 class="fw-bold text-dark mb-1">Halo, <?= htmlspecialchars(explode(' ', $user['name'])[0]) ?>!</h2>
                <p class="text-secondary mb-4">Selamat datang kembali di LMS Depati.</p>
                <div class="d-none d-lg-block">
                    <h5 class="fw-bold text-dark mb-3">Quick Stats</h5>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 text-primary">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <div class="small text-muted fw-bold">TERAKHIR LOGIN</div>
                            <div class="fw-bold text-dark" style="font-size: 0.9rem;"><?= date('d M Y, H:i') ?></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 p-2 text-success">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <div class="small text-muted fw-bold">STATUS AKUN</div>
                            <div class="fw-bold text-dark" style="font-size: 0.9rem;">Aktif - <?= ucfirst($role) ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="user-profile-card">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['name']) ?>&background=4361ee&color=fff&bold=true" class="user-avatar">
                <h6 class="fw-bold mb-0 text-truncate"><?= htmlspecialchars($user['name']) ?></h6>
                <small class="text-muted d-block mb-3"><?= strtoupper($role) ?></small>
                <a href="logout.php" class="btn btn-outline-danger btn-sm w-100 rounded-pill fw-bold">
                    <i class="bi bi-box-arrow-right me-1"></i> Keluar
                </a>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="modules-panel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0">Pilih Modul</h3>
                <span class="badge bg-white text-dark border shadow-sm rounded-pill px-3 py-2">
                    <i class="bi bi-grid-fill text-primary me-1"></i> Apps Launcher
                </span>
            </div>

            <div class="modules-grid">
                
                <?php if ($showSim): ?>
                <a href="?select_module=sim" class="module-card theme-sim" data-tilt data-tilt-scale="1.05">
                    <div class="card-icon">
                        <i class="bi bi-building-gear"></i>
                    </div>
                    <h4 class="card-title">SIM Akademik</h4>
                    <p class="card-desc">Pusat data administrasi, jadwal, dan manajemen sivitas akademika.</p>
                    <div class="card-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
                <?php endif; ?>

                <?php if ($showElearning): ?>
                <a href="?select_module=elearning" class="module-card theme-elearning" data-tilt data-tilt-scale="1.05">
                    <div class="card-icon">
                        <i class="bi bi-laptop"></i>
                    </div>
                    <h4 class="card-title">E-Learning</h4>
                    <p class="card-desc">Platform pembelajaran digital, kelas virtual, dan materi online.</p>
                    <div class="card-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
                <?php endif; ?>

                <?php if ($showCbt): ?>
                <a href="?select_module=cbt" class="module-card theme-cbt" data-tilt data-tilt-scale="1.05">
                    <div class="card-icon">
                        <i class="bi bi-trophy"></i>
                    </div>
                    <h4 class="card-title">Ujian CBT</h4>
                    <p class="card-desc">Sistem ujian berbasis komputer yang aman dan terintegrasi.</p>
                    <div class="card-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
                <?php endif; ?>

                <?php if ($showRaport): ?>
                <a href="?select_module=raport" class="module-card theme-raport" data-tilt data-tilt-scale="1.05">
                    <div class="card-icon">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                    </div>
                    <h4 class="card-title">Raport & Hasil</h4>
                    <p class="card-desc">Laporan hasil studi, transkrip nilai, dan cetak sertifikat.</p>
                    <div class="card-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
                <?php endif; ?>

            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>
    
    <script>
        AOS.init();
        VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
            max: 15,
            speed: 400,
            glare: true,
            "max-glare": 0.1,
        });
    </script>
</body>
</html>
