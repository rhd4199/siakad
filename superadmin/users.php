<?php
require_once __DIR__ . '/../config.php';
require_login(['superadmin']);

$user         = current_user();
$title        = 'Manajemen User Admin';
$currentPage  = 'users';
$roleBasePath = '/superadmin';
$baseUrl      = '/siakad';

// Dummy Users Data
$users = [
    [
        'id' => 1,
        'name' => 'Admin Depati',
        'email' => 'admin@depati.test',
        'role' => 'Super Admin',
        'lpk' => 'Depati Akademi',
        'status' => 'active',
        'last_login' => 'Baru saja',
        'avatar_color' => 'primary',
        'img' => ''
    ],
    [
        'id' => 2,
        'name' => 'Budi Santoso',
        'email' => 'budi@smart.test',
        'role' => 'Admin LPK',
        'lpk' => 'Smart Course',
        'status' => 'active',
        'last_login' => '2 Jam yang lalu',
        'avatar_color' => 'info',
        'img' => ''
    ],
    [
        'id' => 3,
        'name' => 'Siti Aminah',
        'email' => 'siti@karya.test',
        'role' => 'Admin LPK',
        'lpk' => 'LPK Karya Mandiri',
        'status' => 'inactive',
        'last_login' => '3 Hari yang lalu',
        'avatar_color' => 'warning',
        'img' => ''
    ],
    [
        'id' => 4,
        'name' => 'Rahmat Hidayat',
        'email' => 'rahmat@depati.test',
        'role' => 'Operator',
        'lpk' => 'Depati Akademi',
        'status' => 'active',
        'last_login' => 'Kemarin',
        'avatar_color' => 'success',
        'img' => ''
    ],
    [
        'id' => 5,
        'name' => 'Dewi Persik',
        'email' => 'dewi@smart.test',
        'role' => 'Admin LPK',
        'lpk' => 'Smart Course',
        'status' => 'suspended',
        'last_login' => '1 Minggu lalu',
        'avatar_color' => 'danger',
        'img' => ''
    ]
];

// Calculate Stats
$totalUsers = count($users);
$activeUsers = count(array_filter($users, fn($u) => $u['status'] === 'active'));
$inactiveUsers = count(array_filter($users, fn($u) => $u['status'] !== 'active'));

ob_start();
?>

<style>
    /* Modern UI Variables */
    :root {
        --glass-bg: rgba(255, 255, 255, 0.95);
        --glass-border: rgba(255, 255, 255, 0.4);
        --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        --card-hover-transform: translateY(-5px) scale(1.01);
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    body {
        background-color: #f0f2f5;
        background-image: 
            radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
            radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
            radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
        background-attachment: fixed;
    }

    /* Glassmorphism Card */
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        box-shadow: var(--glass-shadow);
        border-radius: 16px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .glass-card:hover {
        transform: var(--card-hover-transform);
        box-shadow: 0 15px 45px rgba(0,0,0,0.1);
        border-color: rgba(255, 255, 255, 0.8);
    }

    /* Avatar Styling */
    .avatar-box {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 700;
        color: white;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        position: relative;
        background-size: 200% 200%;
        animation: gradientBG 5s ease infinite;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Status Badge Pulse */
    .status-badge {
        position: absolute;
        bottom: -5px;
        right: -5px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 3px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .status-pulse {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.2); }
        70% { box-shadow: 0 0 0 6px rgba(0, 0, 0, 0); }
        100% { box-shadow: 0 0 0 0 rgba(0, 0, 0, 0); }
    }

    /* Role Badge */
    .role-badge {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    /* Action Buttons */
    .btn-action {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        border: none;
    }
    .btn-action:hover {
        transform: translateY(-3px);
    }
    
    .btn-action-edit { background: rgba(13, 110, 253, 0.1); color: #0d6efd; }
    .btn-action-edit:hover { background: #0d6efd; color: white; box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3); }
    
    .btn-action-key { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
    .btn-action-key:hover { background: #ffc107; color: white; box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3); }
    
    .btn-action-del { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
    .btn-action-del:hover { background: #dc3545; color: white; box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3); }

    /* Floating Stats */
    .stat-card {
        border: none;
        border-radius: 16px;
        background: white;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        overflow: hidden;
        position: relative;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-card::after {
        content: '';
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.4) 100%);
        pointer-events: none;
    }
</style>

<!-- Stats Row -->
<div class="row g-4 mb-5 fade-in-up">
    <div class="col-md-4">
        <div class="stat-card p-4 h-100 d-flex align-items-center justify-content-between">
            <div>
                <p class="text-muted small fw-bold text-uppercase mb-1">Total Administrator</p>
                <h2 class="display-6 fw-bold text-dark mb-0"><?= $totalUsers ?></h2>
            </div>
            <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary">
                <i class="bi bi-people-fill fs-3"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card p-4 h-100 d-flex align-items-center justify-content-between">
            <div>
                <p class="text-muted small fw-bold text-uppercase mb-1">Akun Aktif</p>
                <h2 class="display-6 fw-bold text-success mb-0"><?= $activeUsers ?></h2>
            </div>
            <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success">
                <i class="bi bi-person-check-fill fs-3"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card p-4 h-100 d-flex align-items-center justify-content-between">
            <div>
                <p class="text-muted small fw-bold text-uppercase mb-1">Non-Aktif / Suspended</p>
                <h2 class="display-6 fw-bold text-danger mb-0"><?= $inactiveUsers ?></h2>
            </div>
            <div class="rounded-circle bg-danger bg-opacity-10 p-3 text-danger">
                <i class="bi bi-person-x-fill fs-3"></i>
            </div>
        </div>
    </div>
</div>

<!-- Header & Actions -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 fade-in-up" style="animation-delay: 0.1s;">
    <div>
        <h3 class="fw-bold text-dark mb-1">Manajemen Pengguna</h3>
        <p class="text-muted">Kelola akses dan perizinan administrator sistem.</p>
    </div>
    <div class="d-flex gap-2">
        <div class="input-group shadow-sm rounded-pill bg-white" style="width: 300px;">
            <span class="input-group-text border-0 bg-transparent ps-3"><i class="bi bi-search text-muted"></i></span>
            <input type="text" class="form-control border-0 bg-transparent focus-ring-none" placeholder="Cari user...">
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-lg btn-hover-scale" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
            <i class="bi bi-plus-lg me-2"></i>Tambah
        </button>
    </div>
</div>

<!-- Grid Layout -->
<div class="row g-4">
    <?php foreach ($users as $idx => $u): 
        $delay = ($idx * 0.1) + 0.2;
        $initial = strtoupper(substr($u['name'], 0, 1));
        
        $statusClass = match($u['status']) {
            'active' => 'bg-success',
            'inactive' => 'bg-secondary',
            'suspended' => 'bg-danger',
            default => 'bg-warning'
        };
        
        $gradientClass = match($u['avatar_color']) {
            'primary' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
            'info' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
            'warning' => 'linear-gradient(135deg, #fddb92 0%, #d1fdff 100%)',
            'success' => 'linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%)',
            'danger' => 'linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%)',
            default => 'linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%)'
        };
    ?>
    <div class="col-md-6 col-lg-4 col-xl-3 fade-in-up" style="animation-delay: <?= $delay ?>s;">
        <div class="glass-card h-100 position-relative p-4 text-center group">
            
            <!-- Context Menu (Top Right) -->
            <div class="position-absolute top-0 end-0 p-3">
                <button class="btn btn-sm btn-link text-muted" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3 overflow-hidden">
                    <li><a class="dropdown-item py-2" href="#"><i class="bi bi-eye me-2"></i>View Details</a></li>
                    <li><a class="dropdown-item py-2" href="#"><i class="bi bi-envelope me-2"></i>Send Email</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2 text-danger" href="#"><i class="bi bi-ban me-2"></i>Suspend User</a></li>
                </ul>
            </div>

            <!-- Avatar -->
            <div class="d-flex justify-content-center mb-4 pt-2">
                <div class="avatar-box" style="background-image: <?= $gradientClass ?>;">
                    <?= $initial ?>
                    <div class="status-badge <?= $statusClass ?>">
                        <?php if($u['status'] === 'active'): ?>
                            <div class="status-pulse <?= $statusClass ?>"></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- User Info -->
            <h5 class="fw-bold text-dark mb-1"><?= $u['name'] ?></h5>
            <div class="role-badge d-inline-block mb-3"><?= $u['role'] ?></div>
            
            <p class="text-muted small mb-4">
                <i class="bi bi-building me-1"></i> <?= $u['lpk'] ?><br>
                <span class="opacity-75"><?= $u['email'] ?></span>
            </p>

            <!-- Metadata -->
            <div class="row g-2 mb-4 border-top border-bottom py-3 bg-light bg-opacity-50 mx-n2 rounded-3">
                <div class="col-6 border-end">
                    <small class="text-muted d-block extra-small text-uppercase">Status</small>
                    <span class="fw-semibold text-<?= $u['status'] === 'active' ? 'success' : 'danger' ?>">
                        <?= ucfirst($u['status']) ?>
                    </span>
                </div>
                <div class="col-6">
                    <small class="text-muted d-block extra-small text-uppercase">Last Login</small>
                    <span class="fw-semibold text-dark small"><?= $u['last_login'] ?></span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-center gap-2">
                <button class="btn-action btn-action-edit" title="Edit">
                    <i class="bi bi-pencil-fill"></i>
                </button>
                <button class="btn-action btn-action-key" title="Reset Password">
                    <i class="bi bi-key-fill"></i>
                </button>
                <button class="btn-action btn-action-del" title="Delete">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </div>

        </div>
    </div>
    <?php endforeach; ?>

    <!-- Add New Card -->
    <div class="col-md-6 col-lg-4 col-xl-3 fade-in-up" style="animation-delay: 0.8s;">
        <div class="glass-card h-100 d-flex flex-column align-items-center justify-content-center p-4 text-center border-2 border-dashed border-primary border-opacity-25 bg-transparent" style="min-height: 380px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
            <div class="rounded-circle bg-light p-4 mb-3 text-primary transition-transform hover-scale">
                <i class="bi bi-plus-lg fs-1"></i>
            </div>
            <h5 class="fw-bold text-primary">Tambah User</h5>
            <p class="text-muted small">Undang administrator baru untuk mengelola LPK.</p>
        </div>
    </div>
</div>

<!-- Modal Create User (Enhanced) -->
<div class="modal fade" id="modalCreateUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 bg-primary text-white px-4 py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-plus-fill me-2"></i>Tambah Administrator</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <form id="formCreateUser">
                    <div class="card border-0 shadow-sm rounded-3 mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3">Informasi Akun</h6>
                            <div class="form-floating mb-3">
                                <select class="form-select border-0 bg-light" id="selectLPK">
                                    <option value="" selected disabled>Pilih LPK...</option>
                                    <option value="1">Depati Akademi</option>
                                    <option value="2">Smart Course</option>
                                    <option value="3">LPK Karya Mandiri</option>
                                </select>
                                <label for="selectLPK">Afiliasi LPK</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control border-0 bg-light" id="inputName" placeholder="Nama">
                                <label for="inputName">Nama Lengkap</label>
                            </div>
                            <div class="form-floating">
                                <input type="email" class="form-control border-0 bg-light" id="inputEmail" placeholder="Email">
                                <label for="inputEmail">Alamat Email</label>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3">Keamanan</h6>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control border-0 bg-light" id="inputPass" value="12345678">
                                <label for="inputPass">Password Sementara</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="checkActive" checked>
                                <label class="form-check-label small" for="checkActive">Aktifkan akun segera</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-white px-4 py-3">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" onclick="alert('User berhasil dibuat!')">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
