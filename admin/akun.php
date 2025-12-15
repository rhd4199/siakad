<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$user = current_user();

// Initialize extended profile data in session if not exists
if (!isset($_SESSION['user']['phone'])) {
    $_SESSION['user']['phone'] = '0812-9999-8888';
}
if (!isset($_SESSION['user']['address'])) {
    $_SESSION['user']['address'] = 'Jl. Administrasi No. 1, Jakarta Pusat';
}
if (!isset($_SESSION['user']['bio'])) {
    $_SESSION['user']['bio'] = 'Administrator Sistem Akademik. Bertanggung jawab atas pengelolaan data akademik, jadwal, dan administrasi umum.';
}
if (!isset($_SESSION['user']['avatar'])) {
    $_SESSION['user']['avatar'] = 'https://ui-avatars.com/api/?name=' . urlencode($user['name']) . '&background=random&size=128';
}

$success_msg = '';
$error_msg   = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Handle Avatar Upload
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileExt = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($fileExt, $allowed)) {
            $newFileName = 'avatar_admin_' . time() . '_' . rand(1000, 9999) . '.' . $fileExt;
            $destPath = $uploadDir . $newFileName;
            
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destPath)) {
                $_SESSION['user']['avatar'] = '/siakad/uploads/avatars/' . $newFileName;
                $success_msg = 'Foto profil berhasil diperbarui.';
            } else {
                $error_msg = 'Gagal mengunggah foto.';
            }
        } else {
            $error_msg = 'Format file tidak didukung (Gunakan JPG, PNG, GIF).';
        }
    }
    
    // 2. Handle Profile Info Update
    if (isset($_POST['action']) && $_POST['action'] === 'update_profile') {
        $name = trim($_POST['name']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $bio = trim($_POST['bio']);
        
        if (!empty($name) && !empty($phone)) {
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['phone'] = $phone;
            $_SESSION['user']['address'] = $address;
            $_SESSION['user']['bio'] = $bio;
            $success_msg = 'Data profil berhasil disimpan.';
        } else {
            $error_msg = 'Nama dan No. Handphone wajib diisi.';
        }
    }
    
    // 3. Handle Password Update (Simulation)
    if (isset($_POST['action']) && $_POST['action'] === 'update_password') {
        $old_pass = $_POST['old_password'];
        $new_pass = $_POST['new_password'];
        $confirm_pass = $_POST['confirm_password'];
        
        if ($new_pass === $confirm_pass) {
            $success_msg = 'Password berhasil diubah (Simulasi).';
        } else {
            $error_msg = 'Konfirmasi password tidak cocok.';
        }
    }
    
    $user = $_SESSION['user'];
}

$title        = 'Pengaturan Akun';
$currentPage  = 'akun';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

ob_start();
?>
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); /* Blue theme for Admin */
        --card-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        --card-hover-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
        background: var(--primary-gradient);
        border-radius: 1.5rem;
        padding: 3rem 2rem;
        position: relative;
        /* overflow: hidden; Removed to allow avatar to overlap */
        color: white;
        margin-bottom: 4rem;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><g fill="%23ffffff" fill-opacity="0.05"><path d="M0 0h20L0 20z"/></g></svg>');
        opacity: 0.3;
        border-radius: 1.5rem;
    }

    .profile-avatar-wrapper {
        position: absolute;
        bottom: -3rem;
        left: 3rem;
        z-index: 10;
    }

    .profile-avatar {
        width: 140px;
        height: 140px;
        border: 5px solid #fff;
        background-color: #fff;
        object-fit: cover;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .profile-avatar:hover {
        transform: scale(1.02);
    }

    .upload-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: white;
        border: none;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .upload-btn:hover {
        background: #f8fafc;
        transform: scale(1.1);
    }

    .settings-nav .nav-link {
        padding: 1rem 1.25rem;
        border-radius: 0.75rem;
        color: #64748b;
        font-weight: 500;
        transition: all 0.2s;
        border: 1px solid transparent;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .settings-nav .nav-link:hover {
        background-color: #f8fafc;
        color: #334155;
    }

    .settings-nav .nav-link.active {
        background-color: #eff6ff; /* Light blue for active */
        color: #2563eb;
        border-color: #dbeafe;
    }

    .settings-nav .nav-link i {
        font-size: 1.25rem;
    }

    .custom-card {
        border: none;
        border-radius: 1rem;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        background: white;
        height: 100%;
    }

    .custom-card:hover {
        box-shadow: var(--card-hover-shadow);
        transform: translateY(-2px);
    }

    .form-floating > .form-control:focus,
    .form-floating > .form-control:not(:placeholder-shown) {
        padding-top: 1.625rem;
        padding-bottom: 0.625rem;
    }

    .form-control {
        border-radius: 0.75rem;
        border-color: #e2e8f0;
        padding: 0.75rem 1rem;
    }

    .form-control:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.1);
    }

    .section-title {
        position: relative;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(to right, #2563eb, #60a5fa);
        border-radius: 3px;
    }
</style>

<div class="container-fluid px-0">
    <!-- Header -->
    <div class="profile-header shadow-sm">
        <div class="row align-items-center">
            <div class="col-lg-8 ms-auto">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <span class="badge bg-white/20 backdrop-blur text-white border border-white/30 px-3 py-2 rounded-pill">
                        <i class="bi bi-shield-check text-warning me-1"></i> Administrator
                    </span>
                    <span class="badge bg-white/20 backdrop-blur text-white border border-white/30 px-3 py-2 rounded-pill">
                        <i class="bi bi-building text-warning me-1"></i> LPK Depati
                    </span>
                </div>
                <h1 class="display-5 fw-bold mb-2"><?= htmlspecialchars($user['name']) ?></h1>
                <p class="lead opacity-90 mb-0 w-75"><?= htmlspecialchars(substr($_SESSION['user']['bio'], 0, 100)) ?>...</p>
            </div>
        </div>
        
        <div class="profile-avatar-wrapper">
            <div class="position-relative">
                <img src="<?= htmlspecialchars($user['avatar']) ?>" class="rounded-circle profile-avatar" alt="Avatar">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label class="upload-btn" title="Ganti Foto">
                        <i class="bi bi-camera-fill text-dark"></i>
                        <input type="file" name="avatar" onchange="this.form.submit()" accept="image/*" class="d-none" />
                    </label>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4" style="margin-top: -2rem;">
        <!-- Left Sidebar Navigation -->
        <div class="col-lg-3">
            <div class="card custom-card sticky-top" style="top: 2rem;">
                <div class="card-body p-3">
                    <nav class="nav flex-column settings-nav">
                        <a class="nav-link active" href="#info-pribadi" data-bs-toggle="list" role="tab">
                            <i class="bi bi-person-badge"></i>
                            <span>Data Admin</span>
                        </a>
                        <a class="nav-link" href="#keamanan" data-bs-toggle="list" role="tab">
                            <i class="bi bi-shield-lock"></i>
                            <span>Keamanan</span>
                        </a>
                        <hr class="my-2 border-light">
                        <a class="nav-link text-danger" href="../logout.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Keluar</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Right Content Area -->
        <div class="col-lg-9">
            
            <?php if ($success_msg): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4 custom-card border-start border-success border-4" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="fs-4 text-success me-3"><i class="bi bi-check-circle-fill"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">Berhasil!</h6>
                            <div class="small text-muted"><?= $success_msg ?></div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="tab-content">
                <!-- Data Pribadi Tab -->
                <div class="tab-pane fade show active" id="info-pribadi">
                    <div class="card custom-card p-4">
                        <h4 class="section-title fw-bold">Informasi Admin</h4>
                        
                        <form action="" method="POST">
                            <input type="hidden" name="action" value="update_profile">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-medium text-muted small text-uppercase ls-1">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-medium text-muted small text-uppercase ls-1">Email</label>
                                        <input type="email" class="form-control bg-light" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-medium text-muted small text-uppercase ls-1">No. Handphone</label>
                                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-medium text-muted small text-uppercase ls-1">Role</label>
                                        <input type="text" class="form-control bg-light" value="Administrator" disabled>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label fw-medium text-muted small text-uppercase ls-1">Deskripsi Singkat</label>
                                        <textarea name="bio" class="form-control" rows="3" placeholder="Deskripsi tugas dan tanggung jawab..."><?= htmlspecialchars($_SESSION['user']['bio'] ?? '') ?></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label fw-medium text-muted small text-uppercase ls-1">Alamat Kantor</label>
                                        <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($user['address']) ?></textarea>
                                    </div>
                                </div>
                                <div class="col-12 text-end pt-3">
                                    <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Keamanan Tab -->
                <div class="tab-pane fade" id="keamanan">
                    <div class="card custom-card p-4">
                        <h4 class="section-title fw-bold">Login & Keamanan</h4>
                        
                        <div class="row">
                            <div class="col-md-7">
                                <form action="" method="POST">
                                    <input type="hidden" name="action" value="update_password">
                                    
                                    <div class="mb-4 p-3 bg-light rounded-3 border border-light">
                                        <div class="d-flex gap-3">
                                            <i class="bi bi-shield-check fs-1 text-primary"></i>
                                            <div>
                                                <h6 class="fw-bold">Keamanan Akun</h6>
                                                <p class="text-muted small mb-0">Kelola password untuk menjaga keamanan akses akun administrator Anda.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label fw-medium text-muted small text-uppercase ls-1">Password Lama</label>
                                        <input type="password" name="old_password" class="form-control" required>
                                    </div>

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label fw-medium text-muted small text-uppercase ls-1">Password Baru</label>
                                                <input type="password" name="new_password" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label fw-medium text-muted small text-uppercase ls-1">Konfirmasi Password</label>
                                                <input type="password" name="confirm_password" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                                            Ganti Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple tab switching logic if bootstrap JS isn't fully handling it or for deep linking
    document.addEventListener('DOMContentLoaded', function() {
        var triggerTabList = [].slice.call(document.querySelectorAll('.settings-nav a'))
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })
    });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
