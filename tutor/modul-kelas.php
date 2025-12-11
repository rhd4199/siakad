<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

// NOTE: Data masih dummy, fokus ke layout frontend
$user         = current_user();
$title        = 'Modul Kelas';
$currentPage  = 'modul-kelas';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

ob_start();
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Modul Kelas</h4>
        <p class="text-muted small mb-0">Kelola template kurikulum dan materi pembelajaran.</p>
    </div>
    <button class="btn btn-primary rounded-pill px-4 shadow-sm"
            type="button"
            data-bs-toggle="modal"
            data-bs-target="#modalCreateModule">
        <i class="bi bi-plus-lg me-2"></i>Buat Modul
    </button>
</div>

<!-- SEARCH & FILTER -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-4">
        <div class="input-group bg-white rounded-pill shadow-sm border p-1">
            <span class="input-group-text border-0 bg-transparent ps-3 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" class="form-control border-0 bg-transparent" placeholder="Cari modul...">
        </div>
    </div>
    <div class="col-md-6 col-lg-8 text-md-end">
        <div class="d-inline-flex bg-white rounded-pill shadow-sm border p-1">
            <button class="btn btn-sm btn-light rounded-pill px-3 fw-medium">Semua</button>
            <button class="btn btn-sm btn-white text-muted rounded-pill px-3">Office</button>
            <button class="btn btn-sm btn-white text-muted rounded-pill px-3">Marketing</button>
            <button class="btn btn-sm btn-white text-muted rounded-pill px-3">Draft</button>
        </div>
    </div>
</div>

<!-- GRID MODUL -->
<div class="row g-4">
    <!-- Card 1 -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 card-hover-uplift overflow-hidden">
            <div class="position-relative" style="height: 160px; background: linear-gradient(45deg, #4e73df, #224abe);">
                <div class="position-absolute top-0 end-0 p-3">
                    <span class="badge bg-white/20 backdrop-blur text-white border border-white/20">Siap Dipakai</span>
                </div>
                <div class="position-absolute bottom-0 start-0 p-3 w-100 bg-gradient-to-t">
                    <h5 class="text-white fw-bold mb-0 text-shadow">Operator Komputer Dasar</h5>
                    <div class="text-white-50 small">Program: Office</div>
                </div>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3 line-clamp-2">
                    Template kelas untuk peserta pemula yang ingin menguasai dasar komputer & Ms Office.
                </p>
                <div class="d-flex align-items-center gap-3 text-muted extra-small mb-3">
                    <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-journal-text text-primary"></i>
                        <span>10 Sesi</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-clock text-info"></i>
                        <span>20 Jam</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-people text-success"></i>
                        <span>2 Kelas Aktif</span>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0 pt-0 pb-3">
                <div class="d-grid">
                    <a href="<?= $baseUrl . $roleBasePath ?>/modul-kelas-detail.php?kode=MOD-OM-01" 
                       class="btn btn-outline-primary btn-sm rounded-pill">
                        Kelola Kurikulum
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 card-hover-uplift overflow-hidden">
            <div class="position-relative" style="height: 160px; background: linear-gradient(45deg, #1cc88a, #13855c);">
                <div class="position-absolute top-0 end-0 p-3">
                    <span class="badge bg-white/20 backdrop-blur text-white border border-white/20">Siap Dipakai</span>
                </div>
                <div class="position-absolute bottom-0 start-0 p-3 w-100 bg-gradient-to-t">
                    <h5 class="text-white fw-bold mb-0 text-shadow">Digital Marketing Pemula</h5>
                    <div class="text-white-50 small">Program: Digital Marketing</div>
                </div>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3 line-clamp-2">
                    Panduan lengkap social media marketing, SEO dasar, dan content planning.
                </p>
                <div class="d-flex align-items-center gap-3 text-muted extra-small mb-3">
                    <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-journal-text text-primary"></i>
                        <span>8 Sesi</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-clock text-info"></i>
                        <span>16 Jam</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-people text-success"></i>
                        <span>1 Kelas Aktif</span>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0 pt-0 pb-3">
                <div class="d-grid">
                    <a href="<?= $baseUrl . $roleBasePath ?>/modul-kelas-detail.php?kode=MOD-DM-01" 
                       class="btn btn-outline-primary btn-sm rounded-pill">
                        Kelola Kurikulum
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3 (Draft) -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 card-hover-uplift overflow-hidden">
            <div class="position-relative" style="height: 160px; background: linear-gradient(45deg, #858796, #5a5c69);">
                <div class="position-absolute top-0 end-0 p-3">
                    <span class="badge bg-white/20 backdrop-blur text-white border border-white/20">Draft</span>
                </div>
                <div class="position-absolute bottom-0 start-0 p-3 w-100 bg-gradient-to-t">
                    <h5 class="text-white fw-bold mb-0 text-shadow">Barista Basic</h5>
                    <div class="text-white-50 small">Program: F&B Service</div>
                </div>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3 line-clamp-2">
                    Teknik dasar brewing kopi, pengenalan alat, dan customer service cafe.
                </p>
                <div class="d-flex align-items-center gap-3 text-muted extra-small mb-3">
                    <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-journal-text text-primary"></i>
                        <span>12 Sesi</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-clock text-info"></i>
                        <span>24 Jam</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-people text-success"></i>
                        <span>0 Kelas</span>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0 pt-0 pb-3">
                <div class="d-grid">
                    <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill">
                        Lanjutkan Draft
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-hover-uplift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card-hover-uplift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
.bg-white\/20 {
    background-color: rgba(255, 255, 255, 0.2);
}
.backdrop-blur {
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}
.text-shadow {
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>