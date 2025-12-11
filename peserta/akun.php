<?php
require_once __DIR__ . '/../config.php';
require_login(['peserta']);

$user = current_user();

// Initialize extended profile data in session if not exists
if (!isset($_SESSION['user']['phone'])) {
    $_SESSION['user']['phone'] = '0812-3456-7890';
}
if (!isset($_SESSION['user']['address'])) {
    $_SESSION['user']['address'] = 'Jl. Jendral Sudirman No. 45, Jakarta Selatan, DKI Jakarta 12190';
}
if (!isset($_SESSION['user']['avatar'])) {
    // Default avatar
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
            $newFileName = 'avatar_' . time() . '_' . rand(1000, 9999) . '.' . $fileExt;
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
        
        if (!empty($name) && !empty($phone)) {
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['phone'] = $phone;
            $_SESSION['user']['address'] = $address;
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
            // In a real app, verify $old_pass with DB
            $success_msg = 'Password berhasil diubah (Simulasi).';
        } else {
            $error_msg = 'Konfirmasi password tidak cocok.';
        }
    }
    
    // Refresh user data from session
    $user = $_SESSION['user'];
}

$title        = 'Pengaturan Akun';
$currentPage  = 'akun';
$roleBasePath = '/peserta';
$baseUrl      = '/siakad';

ob_start();
?>
<style>
    .profile-cover {
        height: 180px;
        background: linear-gradient(120deg, #2563eb, #06b6d4);
        border-radius: 1rem;
        position: relative;
        overflow: hidden;
    }
    .profile-cover::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 80px;
        background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
    }
    .profile-avatar-container {
        margin-top: -60px;
        padding: 0 2rem;
        position: relative;
        z-index: 2;
    }
    .profile-avatar {
        width: 120px;
        height: 120px;
        border: 4px solid #fff;
        background-color: #fff;
        object-fit: cover;
    }
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }
    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        cursor: pointer;
    }
</style>

<!-- Header & Cover -->
<div class="mb-5">
    <?php if ($success_msg): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> <?= $success_msg ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if ($error_msg): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $error_msg ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="profile-cover shadow-sm mb-3">
        <div class="position-absolute top-0 end-0 p-3 text-white-50 small">
            <i class="bi bi-shield-check me-1"></i> Akun Terverifikasi
        </div>
    </div>
    
    <div class="d-flex align-items-end profile-avatar-container gap-4">
        <div class="position-relative group-hover-avatar">
            <img src="<?= htmlspecialchars($user['avatar']) ?>" 
                 class="rounded-circle profile-avatar shadow-sm" 
                 alt="Avatar">
            
            <form action="" method="POST" enctype="multipart/form-data" class="position-absolute bottom-0 end-0">
                <div class="upload-btn-wrapper">
                    <button class="btn btn-light btn-sm rounded-circle shadow-sm border" type="button" title="Ganti Foto">
                        <i class="bi bi-camera-fill text-dark"></i>
                    </button>
                    <input type="file" name="avatar" onchange="this.form.submit()" accept="image/*" />
                </div>
            </form>
        </div>
        
        <div class="mb-2 flex-grow-1">
            <h3 class="fw-bold mb-1"><?= htmlspecialchars($user['name']) ?></h3>
            <div class="d-flex align-items-center gap-3 text-muted small">
                <span><i class="bi bi-envelope me-1"></i> <?= htmlspecialchars($user['email']) ?></span>
                <span class="d-none d-md-inline">•</span>
                <span class="d-none d-md-inline"><i class="bi bi-upc-scan me-1"></i> DA-NIP-2025-0001</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Navigation -->
    <div class="col-lg-3">
        <div class="card border-0 shadow-sm sticky-top" style="top: 2rem; z-index: 1;">
            <div class="list-group list-group-flush rounded-3 p-2">
                <a href="#info-pribadi" class="list-group-item list-group-item-action active border-0 rounded-2 mb-1 d-flex align-items-center gap-3 py-2">
                    <i class="bi bi-person-badge fs-5"></i>
                    <div>
                        <div class="fw-medium">Data Pribadi</div>
                        <div class="extra-small opacity-75">Nama, Alamat, Kontak</div>
                    </div>
                </a>
                <a href="#keamanan" class="list-group-item list-group-item-action border-0 rounded-2 mb-1 d-flex align-items-center gap-3 py-2">
                    <i class="bi bi-shield-lock fs-5 text-muted"></i>
                    <div>
                        <div class="fw-medium text-dark">Login & Keamanan</div>
                        <div class="extra-small text-muted">Password, PIN Absen</div>
                    </div>
                </a>
                <a href="#notifikasi" class="list-group-item list-group-item-action border-0 rounded-2 d-flex align-items-center gap-3 py-2">
                    <i class="bi bi-bell fs-5 text-muted"></i>
                    <div>
                        <div class="fw-medium text-dark">Preferensi</div>
                        <div class="extra-small text-muted">Notifikasi & Tampilan</div>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-body p-3">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-success-subtle text-success p-2 rounded">
                        <i class="bi bi-activity"></i>
                    </div>
                    <div>
                        <div class="small fw-bold">Status Keaktifan</div>
                        <div class="badge bg-success">Aktif</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary-subtle text-primary p-2 rounded">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div>
                        <div class="small fw-bold">Bergabung Sejak</div>
                        <div class="extra-small text-muted">10 Jan 2025</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Content -->
    <div class="col-lg-9">
        
        <!-- Section: Data Pribadi -->
        <div class="card border-0 shadow-sm mb-4" id="info-pribadi">
            <div class="card-header bg-white py-3 border-bottom-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Informasi Pribadi</h6>
                </div>
            </div>
            <div class="card-body pt-0">
                <form action="" method="POST">
                    <input type="hidden" name="action" value="update_profile">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Nomor Induk Peserta (NIP)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-upc-scan text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" value="DA-NIP-2025-0001" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Email Terdaftar</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">No. Handphone</label>
                            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Alamat Domisili</label>
                            <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($user['address']) ?></textarea>
                        </div>
                        <div class="col-12 text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
                
                <div class="alert alert-light border mt-4 mb-0 d-flex gap-3 align-items-start">
                    <i class="bi bi-info-circle text-primary mt-1"></i>
                    <div class="small text-muted">
                        Data identitas utama (NIP & Email) dikelola oleh admin. Hubungi akademik untuk perubahan data sensitif.
                    </div>
                </div>
            </div>
        </div>

        <!-- Section: Keamanan -->
        <div class="card border-0 shadow-sm mb-4" id="keamanan">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h6 class="fw-bold mb-0">Login & Keamanan</h6>
            </div>
            <div class="card-body pt-0">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light h-100">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="fw-medium small"><i class="bi bi-key me-2"></i>Password Login</div>
                                <span class="badge bg-success-subtle text-success">Aman</span>
                            </div>
                            <form action="" method="POST">
                                <input type="hidden" name="action" value="update_password">
                                <div class="mb-2">
                                    <input type="password" name="old_password" class="form-control form-control-sm" placeholder="Password Lama" required>
                                </div>
                                <div class="mb-2">
                                    <input type="password" name="new_password" class="form-control form-control-sm" placeholder="Password Baru" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="confirm_password" class="form-control form-control-sm" placeholder="Konfirmasi Password" required>
                                </div>
                                <button type="submit" class="btn btn-outline-secondary btn-sm w-100">Ubah Password</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light h-100">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="fw-medium small"><i class="bi bi-grid-3x3-gap me-2"></i>PIN Absensi</div>
                                <span class="badge bg-warning-subtle text-warning">Wajib</span>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control form-control-sm" value="123456" disabled>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm w-100">Reset PIN</button>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6 class="fw-bold small mb-3">Riwayat Login Terakhir</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover small">
                            <thead class="table-light">
                                <tr>
                                    <th>Perangkat</th>
                                    <th>Lokasi</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="bi bi-laptop me-2"></i>Chrome on Windows</td>
                                    <td>Jakarta, ID</td>
                                    <td>Baru saja</td>
                                    <td><span class="text-success fw-bold">Active</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-phone me-2"></i>Safari on iPhone</td>
                                    <td>Bandung, ID</td>
                                    <td>Kemarin, 14:30</td>
                                    <td><span class="text-muted">Selesai</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
