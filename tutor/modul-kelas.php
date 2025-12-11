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

<!-- MODAL: CREATE MODULE -->
<div class="modal fade" id="modalCreateModule" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold">Buat Modul Kelas Baru</h5>
                    <p class="text-muted small mb-0">Isi informasi dasar untuk template kelas Anda.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form>
                    <div class="row g-3">
                        <!-- Left Column: Basic Info -->
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">Judul Modul</label>
                                <input type="text" class="form-control" placeholder="Contoh: Digital Marketing Masterclass">
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label class="form-label small fw-semibold text-muted">Kode Modul</label>
                                    <input type="text" class="form-control text-uppercase" placeholder="MOD-..." value="MOD-NEW-01">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-semibold text-muted">Kategori</label>
                                    <select class="form-select">
                                        <option selected disabled>Pilih...</option>
                                        <option>Office & Admin</option>
                                        <option>Digital Marketing</option>
                                        <option>Programming</option>
                                        <option>Design</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">Deskripsi Singkat</label>
                                <textarea class="form-control" rows="4" placeholder="Jelaskan apa yang akan dipelajari siswa..."></textarea>
                            </div>
                        </div>

                        <!-- Right Column: Details & Stats -->
                        <div class="col-md-5">
                            <div class="p-3 bg-light rounded-3 h-100 border border-light">
                                <h6 class="fw-bold small mb-3 text-primary"><i class="bi bi-sliders me-2"></i>Pengaturan Awal</h6>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-muted">Level Kesulitan</label>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="form-check card-radio">
                                            <input class="form-check-input" type="radio" name="level" id="lvlBasic" checked>
                                            <label class="form-check-label small w-100" for="lvlBasic">
                                                <div class="fw-medium">Basic / Pemula</div>
                                                <div class="text-muted extra-small">Untuk yang baru belajar dari nol.</div>
                                            </label>
                                        </div>
                                        <div class="form-check card-radio">
                                            <input class="form-check-input" type="radio" name="level" id="lvlInter">
                                            <label class="form-check-label small w-100" for="lvlInter">
                                                <div class="fw-medium">Intermediate / Lanjutan</div>
                                                <div class="text-muted extra-small">Butuh pengetahuan dasar sebelumnya.</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label extra-small fw-semibold text-muted">Est. Sesi</label>
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control" value="8">
                                            <span class="input-group-text">Sesi</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label extra-small fw-semibold text-muted">Est. Jam</label>
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control" value="16">
                                            <span class="input-group-text">Jam</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-check-lg me-1"></i> Buat Modul
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.card-radio {
    position: relative;
    padding: 0;
    margin: 0;
}
.card-radio .form-check-input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
    z-index: 2;
}
.card-radio .form-check-label {
    display: block;
    padding: 0.75rem;
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    background-color: #fff;
    transition: all 0.2s;
}
.card-radio .form-check-input:checked + .form-check-label {
    border-color: var(--bs-primary);
    background-color: var(--bs-primary-bg-subtle);
    color: var(--bs-primary);
}
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