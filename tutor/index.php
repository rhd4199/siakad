<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user          = current_user();
$title         = 'Dashboard Tutor';
$currentPage   = 'dashboard';
$roleBasePath  = '/tutor';
$baseUrl       = '/siakad';
ob_start();
?>

<style>
    .hover-scale {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-scale:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .bg-gradient-primary-custom {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }
    .card-icon-bg {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    .extra-small {
        font-size: 0.75rem;
    }
</style>

<!-- Greeting Section -->
<div class="row mb-4 align-items-end">
    <div class="col-md-8">
        <h4 class="fw-bold mb-1">Selamat Datang, <?= htmlspecialchars($user['name']) ?>! 👋</h4>
        <p class="text-muted mb-0">
            Semangat mengajar! Berikut adalah ringkasan aktivitas Anda hari ini, <?= date('d M Y') ?>.
        </p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="<?= $roleBasePath ?>/kelas-detail.php" class="btn btn-primary shadow-sm hover-scale">
            <i class="bi bi-plus-lg me-1"></i> Buat Materi Baru
        </a>
    </div>
</div>

<!-- Stats Overview -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 hover-scale border-start border-4 border-primary">
            <div class="card-body p-3">
                <div class="d-flex align-items-center mb-2">
                    <div class="card-icon-bg bg-primary-subtle text-primary me-3">
                        <i class="bi bi-easel fs-5"></i>
                    </div>
                    <span class="text-muted small fw-medium">Kelas Aktif</span>
                </div>
                <h3 class="fw-bold mb-0">3</h3>
                <div class="text-success extra-small mt-1">
                    <i class="bi bi-arrow-up-short"></i> 2 Hari ini
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 hover-scale border-start border-4 border-success">
            <div class="card-body p-3">
                <div class="d-flex align-items-center mb-2">
                    <div class="card-icon-bg bg-success-subtle text-success me-3">
                        <i class="bi bi-people fs-5"></i>
                    </div>
                    <span class="text-muted small fw-medium">Total Siswa</span>
                </div>
                <h3 class="fw-bold mb-0">45</h3>
                <div class="text-muted extra-small mt-1">
                    Tersebar di 3 Kelas
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 hover-scale border-start border-4 border-warning">
            <div class="card-body p-3">
                <div class="d-flex align-items-center mb-2">
                    <div class="card-icon-bg bg-warning-subtle text-warning me-3">
                        <i class="bi bi-file-earmark-text fs-5"></i>
                    </div>
                    <span class="text-muted small fw-medium">Perlu Diperiksa</span>
                </div>
                <h3 class="fw-bold mb-0">12</h3>
                <div class="text-danger extra-small mt-1">
                    <i class="bi bi-exclamation-circle"></i> Tugas baru
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 hover-scale border-start border-4 border-danger">
            <div class="card-body p-3">
                <div class="d-flex align-items-center mb-2">
                    <div class="card-icon-bg bg-danger-subtle text-danger me-3">
                        <i class="bi bi-clock-history fs-5"></i>
                    </div>
                    <span class="text-muted small fw-medium">Ujian Aktif</span>
                </div>
                <h3 class="fw-bold mb-0">2</h3>
                <div class="text-muted extra-small mt-1">
                    Sedang berlangsung
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Schedule & Activity -->
    <div class="col-lg-8">
        
        <!-- Jadwal Mengajar -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">📅 Jadwal Mengajar Hari Ini</h6>
                <a href="<?= $roleBasePath ?>/jadwal" class="text-decoration-none small text-primary fw-medium">Lihat Semua</a>
            </div>
            <div class="card-body pt-0">
                <div class="timeline-list">
                    <!-- Item 1: Done -->
                    <div class="d-flex gap-3 mb-4">
                        <div class="d-flex flex-column align-items-center">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; z-index: 1;">
                                <i class="bi bi-check-lg small"></i>
                            </div>
                            <div class="h-100 bg-light border-start border-2 my-1" style="width: 2px;"></div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="card border bg-light opacity-75">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="badge bg-white text-muted border">08:00 - 10:00</span>
                                        <span class="badge bg-success-subtle text-success">Selesai</span>
                                    </div>
                                    <h6 class="fw-semibold mb-1">Operator Komputer (OM-01)</h6>
                                    <div class="text-muted small"><i class="bi bi-geo-alt me-1"></i> Lab Komputer 1</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Item 2: Active -->
                    <div class="d-flex gap-3 mb-4">
                        <div class="d-flex flex-column align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px; z-index: 1;">
                                <div class="spinner-grow spinner-grow-sm" role="status"></div>
                            </div>
                            <div class="h-100 bg-light border-start border-2 my-1" style="width: 2px;"></div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="card border-primary shadow-sm border-start-4 border-start-primary hover-scale">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="badge bg-primary text-white">10:30 - 12:30</span>
                                        <span class="badge bg-primary-subtle text-primary fw-bold">Sedang Berlangsung</span>
                                    </div>
                                    <h6 class="fw-bold mb-1 text-primary">Digital Marketing (DM-02)</h6>
                                    <div class="text-muted small mb-2"><i class="bi bi-geo-alt me-1"></i> Lab Multimedia</div>
                                    <div class="d-flex gap-2">
                                        <a href="<?= $roleBasePath ?>/ujian-aktif.php" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-camera-video me-1"></i> Pantau Ujian
                                        </a>
                                        <a href="<?= $roleBasePath ?>/kelas-detail.php" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="bi bi-journal-text me-1"></i> Materi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Item 3: Upcoming -->
                    <div class="d-flex gap-3">
                        <div class="d-flex flex-column align-items-center">
                            <div class="rounded-circle bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; z-index: 1;">
                                <i class="bi bi-clock small"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="card border-0 bg-light hover-scale">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="badge bg-white text-muted border">13:30 - 15:30</span>
                                        <span class="badge bg-secondary-subtle text-secondary">Akan Datang</span>
                                    </div>
                                    <h6 class="fw-semibold mb-1 text-muted">Barista Dasar (BRS-01)</h6>
                                    <div class="text-muted small"><i class="bi bi-geo-alt me-1"></i> Workshop Kopi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tugas Terbaru -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">📝 Tugas Masuk Terbaru</h6>
                <span class="badge bg-warning-subtle text-warning">12 Belum Dinilai</span>
            </div>
            <div class="list-group list-group-flush">
                <div class="list-group-item px-3 py-3 border-0 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-sm bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                            BS
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0 small fw-bold">Budi Santoso</h6>
                                <small class="text-muted extra-small">10 menit lalu</small>
                            </div>
                            <p class="mb-0 extra-small text-muted">Mengumpulkan tugas: <strong>Analisis SEO Website</strong></p>
                        </div>
                        <button class="btn btn-sm btn-light text-primary rounded-circle"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
                <div class="list-group-item px-3 py-3 border-0 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-sm bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                            AD
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0 small fw-bold">Andi Darmawan</h6>
                                <small class="text-muted extra-small">25 menit lalu</small>
                            </div>
                            <p class="mb-0 extra-small text-muted">Mengumpulkan tugas: <strong>Laporan Praktik Excel</strong></p>
                        </div>
                        <button class="btn btn-sm btn-light text-primary rounded-circle"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
                <div class="list-group-item px-3 py-3 border-0">
                    <div class="text-center">
                        <a href="#" class="text-decoration-none small fw-medium">Lihat Semua Tugas</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Right Column: Quick Actions & Info -->
    <div class="col-lg-4">
        
        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm mb-4 bg-gradient-primary-custom text-white overflow-hidden">
            <!-- Decorative circle -->
            <div class="position-absolute top-0 end-0 p-3 opacity-10">
                <i class="bi bi-grid-fill" style="font-size: 5rem; transform: rotate(15deg);"></i>
            </div>
            
            <div class="card-body p-4 position-relative">
                <h5 class="fw-bold mb-1">Akses Cepat</h5>
                <p class="small opacity-75 mb-4">Pintasan untuk produktivitas Anda.</p>
                
                <div class="row g-2">
                    <div class="col-6">
                        <div class="d-grid">
                            <a href="<?= $roleBasePath ?>/kelas-detail.php" class="btn btn-light text-primary border-0 shadow-sm py-2 text-start hover-scale">
                                <i class="bi bi-plus-circle-fill me-2"></i> Buat Tugas
                            </a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-grid">
                            <a href="<?= $roleBasePath ?>/ujian-aktif.php" class="btn btn-light text-primary border-0 shadow-sm py-2 text-start hover-scale">
                                <i class="bi bi-lightning-fill me-2"></i> Buat Ujian
                            </a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-grid">
                            <a href="#" class="btn btn-white text-white border border-white border-opacity-25 py-2 text-start bg-transparent hover-scale">
                                <i class="bi bi-pencil-square me-2"></i> Input Nilai
                            </a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-grid">
                            <a href="#" class="btn btn-white text-white border border-white border-opacity-25 py-2 text-start bg-transparent hover-scale">
                                <i class="bi bi-qr-code-scan me-2"></i> Absensi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kalender / Pengumuman -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0">📢 Pengumuman Akademik</h6>
            </div>
            <div class="card-body p-0">
                <div class="alert alert-info border-0 rounded-0 mb-0 d-flex align-items-start gap-2 bg-info-subtle text-info-emphasis">
                    <i class="bi bi-info-circle-fill mt-1"></i>
                    <div>
                        <strong>Rapat Evaluasi Tutor</strong>
                        <div class="small mt-1">Jumat, 15 Des 2024 - 13:00 WIB di Ruang Meeting Utama.</div>
                    </div>
                </div>
                <div class="p-3 border-bottom hover-bg-light">
                    <div class="small text-muted mb-1">10 Desember 2024</div>
                    <h6 class="mb-1 text-dark fw-medium">Batas Input Nilai UAS</h6>
                    <p class="mb-0 extra-small text-muted">Mohon segera melengkapi nilai sebelum tanggal 20 Des.</p>
                </div>
                <div class="p-3 hover-bg-light">
                    <div class="small text-muted mb-1">08 Desember 2024</div>
                    <h6 class="mb-1 text-dark fw-medium">Maintenance Server</h6>
                    <p class="mb-0 extra-small text-muted">Sistem akan down sementara pada hari Minggu pukul 00:00 - 04:00.</p>
                </div>
            </div>
            <div class="card-footer bg-white border-0 text-center py-3">
                <a href="#" class="text-decoration-none small fw-medium">Lihat Arsip Pengumuman</a>
            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
