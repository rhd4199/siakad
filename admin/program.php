<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$user         = current_user();
$title        = 'Program & Modul';
$currentPage  = 'program';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

// Simulated Data
$programs = [
    [
        'id' => 1,
        'code' => 'DM-01',
        'name' => 'Digital Marketing Mastery',
        'level' => 'Intermediate',
        'duration' => '3 Bulan',
        'modules_count' => 12,
        'students' => 145,
        'rating' => 4.8,
        'status' => 'active',
        'price' => 'Rp 2.500.000',
        'tags' => ['Marketing', 'SEO', 'Ads'],
        'image_color' => 'primary', // for gradient placeholder
        'modules_list' => [
            ['title' => 'Pengenalan Digital Marketing', 'duration' => '2 Jam'],
            ['title' => 'SEO Fundamentals', 'duration' => '4 Jam'],
            ['title' => 'Social Media Strategy', 'duration' => '3 Jam'],
            ['title' => 'Google Ads Basic', 'duration' => '5 Jam']
        ]
    ],
    [
        'id' => 2,
        'code' => 'WD-01',
        'name' => 'Web Development Bootcamp',
        'level' => 'Advanced',
        'duration' => '6 Bulan',
        'modules_count' => 24,
        'students' => 89,
        'rating' => 4.9,
        'status' => 'active',
        'price' => 'Rp 5.000.000',
        'tags' => ['Coding', 'React', 'NodeJS'],
        'image_color' => 'success',
        'modules_list' => [
            ['title' => 'HTML & CSS Dasar', 'duration' => '6 Jam'],
            ['title' => 'JavaScript Modern', 'duration' => '8 Jam'],
            ['title' => 'React JS Framework', 'duration' => '12 Jam'],
            ['title' => 'Backend dengan Node.js', 'duration' => '10 Jam']
        ]
    ],
    [
        'id' => 3,
        'code' => 'GD-01',
        'name' => 'Graphic Design Fundamentals',
        'level' => 'Beginner',
        'duration' => '2 Bulan',
        'modules_count' => 8,
        'students' => 210,
        'rating' => 4.7,
        'status' => 'active',
        'price' => 'Rp 1.500.000',
        'tags' => ['Design', 'Adobe', 'Creative'],
        'image_color' => 'info',
        'modules_list' => [
            ['title' => 'Prinsip Desain Grafis', 'duration' => '3 Jam'],
            ['title' => 'Adobe Photoshop Dasar', 'duration' => '5 Jam'],
            ['title' => 'Adobe Illustrator Dasar', 'duration' => '5 Jam'],
            ['title' => 'Project: Logo Design', 'duration' => '4 Jam']
        ]
    ],
    [
        'id' => 4,
        'code' => 'DS-01',
        'name' => 'Data Science for Business',
        'level' => 'Advanced',
        'duration' => '4 Bulan',
        'modules_count' => 16,
        'students' => 45,
        'rating' => 4.6,
        'status' => 'draft',
        'price' => 'Rp 4.000.000',
        'tags' => ['Data', 'Python', 'Analytics'],
        'image_color' => 'warning',
        'modules_list' => [
            ['title' => 'Introduction to Data Science', 'duration' => '2 Jam'],
            ['title' => 'Python for Data Analysis', 'duration' => '8 Jam'],
            ['title' => 'Data Visualization', 'duration' => '4 Jam'],
            ['title' => 'Machine Learning Basics', 'duration' => '6 Jam']
        ]
    ]
];

ob_start();
?>

<style>
    .program-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .program-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        border-color: var(--bs-primary-border-subtle);
    }
    .card-img-placeholder {
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        font-weight: bold;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: relative;
    }
    .card-img-placeholder::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50%;
        background: linear-gradient(to top, rgba(0,0,0,0.2), transparent);
    }
    .program-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
    }
    .price-tag {
        font-weight: 700;
        color: var(--bs-primary);
        font-size: 1.1rem;
    }
    .meta-item {
        font-size: 0.85rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    .accordion-button:not(.collapsed) {
        background-color: var(--bs-primary-bg-subtle);
        color: var(--bs-primary);
    }
    .module-item {
        border-left: 3px solid transparent;
        transition: border-color 0.2s;
    }
    .module-item:hover {
        border-left-color: var(--bs-primary);
        background-color: var(--bs-light);
    }
</style>

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1">Program & Kurikulum</h4>
        <p class="text-muted small mb-0">
            Kelola katalog program pelatihan dan struktur modul pembelajaran.
        </p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <div class="d-flex justify-content-md-end gap-2">
            <div class="input-group input-group-sm w-auto">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0 bg-white" placeholder="Cari program...">
            </div>
            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCreateProgram">
                <i class="bi bi-plus-lg me-1"></i> Program Baru
            </button>
        </div>
    </div>
</div>

<!-- Program Stats -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 bg-primary-subtle text-primary me-3">
                    <i class="bi bi-journal-album fs-4"></i>
                </div>
                <div>
                    <div class="small text-muted">Total Program</div>
                    <div class="fw-bold fs-5"><?= count($programs) ?> Program</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 bg-success-subtle text-success me-3">
                    <i class="bi bi-people fs-4"></i>
                </div>
                <div>
                    <div class="small text-muted">Total Peserta</div>
                    <div class="fw-bold fs-5"><?= array_sum(array_column($programs, 'students')) ?> Siswa</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 bg-info-subtle text-info me-3">
                    <i class="bi bi-clock-history fs-4"></i>
                </div>
                <div>
                    <div class="small text-muted">Total Modul</div>
                    <div class="fw-bold fs-5"><?= array_sum(array_column($programs, 'modules_count')) ?> Modul</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 bg-warning-subtle text-warning me-3">
                    <i class="bi bi-star fs-4"></i>
                </div>
                <div>
                    <div class="small text-muted">Rating Rata-rata</div>
                    <div class="fw-bold fs-5">4.8</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Programs Grid -->
<div class="row g-4">
    <?php foreach ($programs as $index => $prog): ?>
    <div class="col-md-6 col-xl-4">
        <div class="card program-card border-0 shadow-sm h-100 rounded-3">
            <!-- Card Image Placeholder -->
            <div class="card-img-placeholder bg-gradient bg-<?= $prog['image_color'] ?>">
                <?= substr($prog['code'], 0, 2) ?>
                
                <div class="program-badge">
                    <?php if ($prog['status'] == 'active'): ?>
                        <span class="badge bg-white text-success shadow-sm rounded-pill">
                            <i class="bi bi-check-circle-fill me-1"></i>Aktif
                        </span>
                    <?php else: ?>
                        <span class="badge bg-white text-secondary shadow-sm rounded-pill">
                            <i class="bi bi-pencil-fill me-1"></i>Draft
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="small text-uppercase text-muted fw-bold tracking-wide"><?= $prog['code'] ?></div>
                    <div class="d-flex text-warning small">
                        <?php for($i=0; $i<5; $i++): ?>
                            <i class="bi bi-star<?= $i < round($prog['rating']) ? '-fill' : '' ?>"></i>
                        <?php endfor; ?>
                        <span class="ms-1 text-muted">(<?= $prog['rating'] ?>)</span>
                    </div>
                </div>
                
                <h5 class="card-title fw-bold mb-2 text-truncate" title="<?= $prog['name'] ?>"><?= $prog['name'] ?></h5>
                
                <div class="mb-3">
                    <?php foreach ($prog['tags'] as $tag): ?>
                        <span class="badge bg-light text-secondary border fw-normal me-1 mb-1"><?= $tag ?></span>
                    <?php endforeach; ?>
                </div>
                
                <div class="row g-2 mb-4 text-muted small">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-bar-chart-fill me-2 text-primary"></i>
                            <span><?= $prog['level'] ?></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock-fill me-2 text-primary"></i>
                            <span><?= $prog['duration'] ?></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-journal-text me-2 text-primary"></i>
                            <span><?= $prog['modules_count'] ?> Modul</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-people-fill me-2 text-primary"></i>
                            <span><?= $prog['students'] ?> Siswa</span>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <div class="price-tag"><?= $prog['price'] ?></div>
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit Program</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-people me-2"></i>Lihat Peserta</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Hapus</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Accordion Trigger -->
                <button class="btn btn-outline-primary w-100 mt-3 btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseModule<?= $index ?>" aria-expanded="false">
                    <i class="bi bi-list-nested me-1"></i> Lihat Kurikulum
                </button>
            </div>
            
            <!-- Collapsible Modules Section -->
            <div class="collapse" id="collapseModule<?= $index ?>">
                <div class="card-footer bg-light border-top p-0">
                    <div class="list-group list-group-flush small">
                        <div class="list-group-item bg-light fw-bold text-muted text-uppercase py-2 px-4" style="font-size: 0.75rem;">
                            Daftar Modul (Preview)
                        </div>
                        <?php foreach ($prog['modules_list'] as $mod): ?>
                        <div class="list-group-item module-item px-4 py-2 d-flex justify-content-between align-items-center bg-light border-bottom-0">
                            <span><i class="bi bi-play-circle me-2 text-muted"></i><?= $mod['title'] ?></span>
                            <span class="text-muted" style="font-size: 0.75rem;"><?= $mod['duration'] ?></span>
                        </div>
                        <?php endforeach; ?>
                        <a href="#" class="list-group-item list-group-item-action text-center text-primary py-2 bg-light border-bottom-0 small">
                            Lihat Semua Modul <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    
    <!-- Add New Card -->
    <div class="col-md-6 col-xl-4">
        <button class="card border-2 border-dashed shadow-none h-100 w-100 d-flex flex-column align-items-center justify-content-center p-5 text-muted bg-transparent program-card" 
                style="min-height: 400px; border-color: #dee2e6 !important;"
                data-bs-toggle="modal" data-bs-target="#modalCreateProgram">
            <div class="rounded-circle bg-light p-4 mb-3 text-secondary">
                <i class="bi bi-plus-lg fs-1"></i>
            </div>
            <h5 class="fw-bold">Buat Program Baru</h5>
            <p class="small text-center mb-0">Tambahkan program pelatihan baru ke katalog</p>
        </button>
    </div>
</div>

<!-- Modal Create Program -->
<div class="modal fade" id="modalCreateProgram" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Buat Program Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Nama Program</label>
                            <input type="text" class="form-control" placeholder="Contoh: Digital Marketing Mastery">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kode</label>
                            <input type="text" class="form-control" placeholder="DM-01">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tingkat Kesulitan</label>
                            <select class="form-select">
                                <option>Beginner</option>
                                <option>Intermediate</option>
                                <option>Advanced</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estimasi Durasi</label>
                            <input type="text" class="form-control" placeholder="Contoh: 3 Bulan">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control" placeholder="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Singkat</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan Program</button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
