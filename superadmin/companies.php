<?php
require_once __DIR__ . '/../config.php';
require_login(['superadmin']);

$user         = current_user();
$title        = 'Manajemen LPK';
$currentPage  = 'companies';
$roleBasePath = '/superadmin';
$baseUrl      = '/siakad';

// Dummy Data LPK
$companies = [
    [
        'id' => 1,
        'name' => 'Depati Akademi',
        'code' => 'DEPATI',
        'pic' => 'Rifki',
        'phone' => '081234567890',
        'status' => 'active',
        'users_count' => 12,
        'valid_until' => '2025-12-31'
    ],
    [
        'id' => 2,
        'name' => 'Smart Course Sungai Penuh',
        'code' => 'SMART',
        'pic' => 'Budi',
        'phone' => '08987654321',
        'status' => 'trial',
        'users_count' => 5,
        'valid_until' => '2025-01-20'
    ],
    [
        'id' => 3,
        'name' => 'LPK Karya Mandiri',
        'code' => 'KARYA',
        'pic' => 'Siti',
        'phone' => '081122334455',
        'status' => 'inactive',
        'users_count' => 2,
        'valid_until' => '2024-11-30'
    ]
];

ob_start();
?>

<style>
    :root {
        --super-gradient: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%);
    }
    .fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
        transform: translateY(15px);
    }
    @keyframes fadeInUp {
        to { opacity: 1; transform: translateY(0); }
    }
    
    .lpk-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .lpk-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        border-color: rgba(76, 161, 175, 0.3);
    }
    
    .status-dot {
        height: 10px;
        width: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }
    .status-active { background-color: #198754; box-shadow: 0 0 0 2px rgba(25, 135, 84, 0.2); }
    .status-trial { background-color: #ffc107; box-shadow: 0 0 0 2px rgba(255, 193, 7, 0.2); }
    .status-inactive { background-color: #dc3545; box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.2); }
</style>

<div class="row mb-4 fade-in-up">
    <div class="col-md-8">
        <h4 class="fw-bold text-primary mb-1">Manajemen Perusahaan (LPK)</h4>
        <p class="text-muted small">Kelola lisensi, status aktif, dan data perusahaan mitra.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCreateCompany">
            <i class="bi bi-plus-lg me-1"></i> Tambah LPK Baru
        </button>
    </div>
</div>

<!-- Search & Filter -->
<div class="card border-0 shadow-sm mb-4 fade-in-up" style="animation-delay: 0.1s;">
    <div class="card-body p-3">
        <div class="row g-2">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="Cari nama LPK atau kode...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option value="">Semua Status</option>
                    <option value="active">Active</option>
                    <option value="trial">Trial</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option value="">Urutkan Tanggal</option>
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-light w-100 text-primary border"><i class="bi bi-filter"></i> Filter</button>
            </div>
        </div>
    </div>
</div>

<!-- LPK Grid List -->
<div class="row g-4">
    <?php foreach ($companies as $idx => $comp): 
        $delay = ($idx + 2) * 0.1;
        $statusClass = 'status-' . $comp['status'];
        $badgeClass = match($comp['status']) {
            'active' => 'bg-success-subtle text-success',
            'trial' => 'bg-warning-subtle text-warning',
            'inactive' => 'bg-danger-subtle text-danger',
        };
        $statusLabel = ucfirst($comp['status']);
    ?>
    <div class="col-md-6 col-lg-4 fade-in-up" style="animation-delay: <?= $delay ?>s;">
        <div class="card h-100 border-0 shadow-sm lpk-card rounded-4 overflow-hidden position-relative">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-5 shadow-sm" style="width: 50px; height: 50px;">
                            <?= substr($comp['code'], 0, 1) ?>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark"><?= $comp['name'] ?></h6>
                            <span class="badge bg-light text-secondary border mt-1"><?= $comp['code'] ?></span>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2 text-warning"></i> Edit Data</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-shield-lock me-2 text-info"></i> Atur Lisensi</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i> Hapus</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted">Status Layanan</span>
                        <span class="badge <?= $badgeClass ?> rounded-pill px-3"><?= $statusLabel ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted">Berlaku Sampai</span>
                        <span class="small fw-semibold"><?= date('d M Y', strtotime($comp['valid_until'])) ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small text-muted">Total User</span>
                        <span class="small fw-semibold"><?= $comp['users_count'] ?> User</span>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 pt-3 border-top">
                    <div class="small text-muted">PIC: <span class="fw-semibold text-dark"><?= $comp['pic'] ?></span></div>
                    <div class="ms-auto">
                        <a href="https://wa.me/<?= $comp['phone'] ?>" target="_blank" class="btn btn-sm btn-success rounded-circle" title="Hubungi WA">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="mailto:email@dummy.com" class="btn btn-sm btn-light border rounded-circle" title="Email">
                            <i class="bi bi-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Status Bar Indicator -->
            <div class="position-absolute bottom-0 start-0 w-100" style="height: 4px; background-color: var(--bs-<?= match($comp['status']){ 'active'=>'success', 'trial'=>'warning', 'inactive'=>'danger'} ?>);"></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Modal Create Company -->
<div class="modal fade" id="modalCreateCompany" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-bold text-primary"><i class="bi bi-building-add me-2"></i>Registrasi LPK Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formCreateCompany">
                    <div class="row g-3">
                        <div class="col-12">
                            <h6 class="text-uppercase text-muted extra-small fw-bold letter-spacing-1 mb-3">Informasi Perusahaan</h6>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold">Nama LPK / Perusahaan</label>
                            <input type="text" class="form-control" placeholder="Contoh: Depati Akademi">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Kode Unik (Prefix)</label>
                            <input type="text" class="form-control text-uppercase" placeholder="Contoh: DEPATI">
                            <div class="form-text extra-small">Digunakan untuk ID sistem.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Alamat Lengkap</label>
                            <textarea class="form-control" rows="2" placeholder="Alamat kantor pusat..."></textarea>
                        </div>

                        <div class="col-12 mt-4">
                            <h6 class="text-uppercase text-muted extra-small fw-bold letter-spacing-1 mb-3">Penanggung Jawab (PIC)</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nama PIC</label>
                            <input type="text" class="form-control" placeholder="Nama lengkap kontak person">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nomor WhatsApp</label>
                            <input type="text" class="form-control" placeholder="08...">
                        </div>

                        <div class="col-12 mt-4">
                            <h6 class="text-uppercase text-muted extra-small fw-bold letter-spacing-1 mb-3">Konfigurasi Layanan</h6>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Paket Langganan</label>
                            <select class="form-select">
                                <option value="starter">Starter (Max 50 User)</option>
                                <option value="pro">Pro (Max 200 User)</option>
                                <option value="enterprise">Enterprise (Unlimited)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Status Awal</label>
                            <select class="form-select">
                                <option value="active">Langsung Aktif</option>
                                <option value="trial">Trial 14 Hari</option>
                                <option value="inactive">Nonaktif (Setup Only)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Berlaku Sampai</label>
                            <input type="date" class="form-control" value="<?= date('Y-12-31') ?>">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-light rounded-bottom-4">
                <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary px-4 rounded-pill" onclick="alert('Data berhasil disimpan (Simulasi)')">
                    <i class="bi bi-save me-1"></i> Simpan LPK
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
