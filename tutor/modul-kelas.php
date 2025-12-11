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
<div class="row mb-3">
    <div class="col-lg-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <h4 class="fw-semibold mb-0">Modul Kelas</h4>
            <span class="badge rounded-pill bg-light text-muted extra-small">
                <i class="bi bi-easel3 me-1"></i> Template Kelas & Pembelajaran
            </span>
        </div>
        <p class="text-muted small mb-0">
            Di sini tutor menyusun <strong>template kelas</strong>: struktur sesi, materi, dan video.
            Nanti admin tinggal memilih modul ini untuk dijadikan kelas aktif & dijadwalkan.
        </p>
    </div>
    <div class="col-lg-4 mt-3 mt-lg-0 text-lg-end">
        <!-- TOMBOL SUDAH AKTIF & BUKA MODAL -->
        <button class="btn btn-primary btn-sm"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#modalCreateModule">
            <i class="bi bi-plus-lg me-1"></i> Buat Modul Baru
        </button>
    </div>
</div>

<!-- SUMMARY -->
<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-primary-subtle text-primary">
                <i class="bi bi-easel3"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Total modul</div>
                <div class="fs-4 fw-semibold">5</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-success-subtle text-success">
                <i class="bi bi-check-circle"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Siap dipakai</div>
                <div class="fs-4 fw-semibold">3</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-warning-subtle text-warning">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Draft</div>
                <div class="fs-4 fw-semibold">2</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-info-subtle text-info">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Rata2 sesi/modul</div>
                <div class="fs-4 fw-semibold">8</div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER & SEARCH -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body small">
        <div class="row g-2 align-items-center">
            <div class="col-md-4">
                <label class="form-label extra-small text-muted mb-1">Cari modul</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control border-0"
                           placeholder="Contoh: Operator Komputer, Barista, Digital Marketing" disabled>
                </div>
            </div>
            <div class="col-md-8">
                <label class="form-label extra-small text-muted mb-1">Filter cepat</label>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-light btn-xs extra-small border-0 px-2 py-1" disabled>
                        <i class="bi bi-list-ul me-1"></i> Semua program
                    </button>
                    <button class="btn btn-outline-secondary btn-xs extra-small px-2 py-1" disabled>
                        Office & Operator Komputer
                    </button>
                    <button class="btn btn-outline-secondary btn-xs extra-small px-2 py-1" disabled>
                        Digital Marketing
                    </button>
                    <button class="btn btn-outline-secondary btn-xs extra-small px-2 py-1" disabled>
                        Barista & F&B
                    </button>
                    <button class="btn btn-outline-secondary btn-xs extra-small px-2 py-1" disabled>
                        Status: Draft saja
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LIST MODUL -->
<div class="row g-3">
    <!-- Modul 1 -->
    <div class="col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body small">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div>
                        <div class="mb-1">
                            <span class="badge bg-primary-subtle text-primary extra-small me-1">MOD-OM-01</span>
                            <span class="badge bg-light text-muted extra-small me-1">Program: Office</span>
                            <span class="badge bg-success-subtle text-success extra-small">Status: Siap dipakai</span>
                        </div>
                        <h6 class="fw-semibold mb-1">Operator Komputer Dasar</h6>
                        <p class="extra-small text-muted mb-2">
                            Template kelas untuk peserta pemula yang ingin menguasai dasar komputer & Ms Office
                            sebelum masuk kerja kantoran.
                        </p>
                    </div>
                    <div class="text-end extra-small text-muted">
                        <div><i class="bi bi-collection me-1"></i>Dipakai di kelas aktif: <strong>2</strong></div>
                        <div><i class="bi bi-bar-chart-steps me-1"></i>Jumlah sesi: <strong>10</strong></div>
                        <div><i class="bi bi-clock me-1"></i>Estimasi durasi: <strong>20 jam</strong></div>
                    </div>
                </div>

                <div class="row extra-small mb-2">
                    <div class="col-md-6">
                        <div class="mb-1">
                            <i class="bi bi-play-circle me-1"></i>Materi & video: <strong>15 item</strong>
                        </div>
                        <div class="mb-1">
                            <i class="bi bi-mortarboard me-1"></i>Level: <strong>Basic</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-1">
                            <i class="bi bi-flag me-1"></i>Outcome: peserta siap kerja admin dasar
                        </div>
                        <div class="mb-1">
                            <i class="bi bi-person-video3 me-1"></i>Tutor rekomendasi: <strong>2 orang</strong> (dummy)
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-2">
                    <div class="extra-small text-muted">
                        Struktur sesi diatur di <strong>Kelola Modul</strong>. Saat admin buka kelas baru,
                        sistem akan menyalin semua sesi & materi dari modul ini.
                    </div>
                    <div class="btn-group btn-group-sm">
                        <a href="<?= $baseUrl . $roleBasePath ?>/modul-kelas-detail.php?kode=MOD-OM-01"
                           class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-sliders me-1"></i> Kelola Modul
                        </a>
                        <button class="btn btn-outline-secondary btn-sm" type="button" disabled>
                            <i class="bi bi-files me-1"></i> Duplikasi (Demo)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modul 2 -->
    <div class="col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body small">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div>
                        <div class="mb-1">
                            <span class="badge bg-info-subtle text-info extra-small me-1">MOD-DM-01</span>
                            <span class="badge bg-light text-muted extra-small me-1">Program: Digital Marketing</span>
                            <span class="badge bg-success-subtle text-success extra-small">Status: Siap dipakai</span>
                        </div>
                        <h6 class="fw-semibold mb-1">Digital Marketing Pemula</h6>
                        <p class="extra-small text-muted mb-2">
                            Template kelas untuk pengenalan social media, konten, dan iklan dasar untuk UMKM.
                        </p>
                    </div>
                    <div class="text-end extra-small text-muted">
                        <div><i class="bi bi-collection me-1"></i>Dipakai di kelas aktif: <strong>1</strong></div>
                        <div><i class="bi bi-bar-chart-steps me-1"></i>Jumlah sesi: <strong>8</strong></div>
                        <div><i class="bi bi-clock me-1"></i>Estimasi durasi: <strong>16 jam</strong></div>
                    </div>
                </div>

                <div class="row extra-small mb-2">
                    <div class="col-md-6">
                        <div class="mb-1">
                            <i class="bi bi-play-circle me-1"></i>Materi & video: <strong>10 item</strong>
                        </div>
                        <div class="mb-1">
                            <i class="bi bi-mortarboard me-1"></i>Level: <strong>Basic - Intermediate</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-1">
                            <i class="bi bi-flag me-1"></i>Outcome: peserta paham funnel & konten
                        </div>
                        <div class="mb-1">
                            <i class="bi bi-hash me-1"></i>Fokus: IG, TikTok, WA Bisnis
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-2">
                    <div class="extra-small text-muted">
                        Bisa dipakai untuk batch pagi/sore tanpa mengubah modul. Jadwal diatur di menu
                        <strong>Kelas Aktif</strong>.
                    </div>
                    <div class="btn-group btn-group-sm">
                        <a href="<?= $baseUrl . $roleBasePath ?>/modul-kelas-detail.php?kode=MOD-DM-01"
                           class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-sliders me-1"></i> Kelola Modul
                        </a>
                        <button class="btn btn-outline-secondary btn-sm" type="button" disabled>
                            <i class="bi bi-files me-1"></i> Duplikasi (Demo)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modul 3 (Draft) -->
    <div class="col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body small">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div>
                        <div class="mb-1">
                            <span class="badge bg-warning-subtle text-warning extra-small me-1">MOD-BRS-01</span>
                            <span class="badge bg-light text-muted extra-small me-1">Program: Barista</span>
                            <span class="badge bg-secondary-subtle text-secondary extra-small">Status: Draft</span>
                        </div>
                        <h6 class="fw-semibold mb-1">Barista Dasar</h6>
                        <p class="extra-small text-muted mb-2">
                            Modul untuk kelas barista basic: basic coffee, alat, dan servis customer.
                            Masih draft, beberapa sesi belum lengkap.
                        </p>
                    </div>
                    <div class="text-end extra-small text-muted">
                        <div><i class="bi bi-collection me-1"></i>Dipakai di kelas aktif: <strong>0</strong></div>
                        <div><i class="bi bi-bar-chart-steps me-1"></i>Jumlah sesi: <strong>6</strong></div>
                        <div><i class="bi bi-clock me-1"></i>Estimasi durasi: <strong>12 jam</strong></div>
                    </div>
                </div>

                <div class="row extra-small mb-2">
                    <div class="col-md-6">
                        <div class="mb-1">
                            <i class="bi bi-play-circle me-1"></i>Materi & video: <strong>4 item</strong>
                        </div>
                        <div class="mb-1">
                            <i class="bi bi-mortarboard me-1"></i>Level: <strong>Basic</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-1 text-warning">
                            <i class="bi bi-exclamation-triangle me-1"></i>3 sesi belum diisi detail
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-2">
                    <div class="extra-small text-muted">
                        Lengkapi dulu struktur sesi & materi sebelum modul ini bisa ditandai sebagai
                        <strong>Siap dipakai</strong>.
                    </div>
                    <div class="btn-group btn-group-sm">
                        <a href="<?= $baseUrl . $roleBasePath ?>/modul-kelas-detail.php?kode=MOD-BRS-01"
                           class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-sliders me-1"></i> Kelola Modul
                        </a>
                        <button class="btn btn-outline-secondary btn-sm" type="button" disabled>
                            <i class="bi bi-files me-1"></i> Duplikasi (Demo)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: BUAT MODUL BARU -->
<div class="modal fade" id="modalCreateModule" tabindex="-1" aria-labelledby="modalCreateModuleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0">
            <!-- HEADER DIBUAT LEBIH KEREN SEDIKIT -->
            <div class="modal-header border-0 pb-0">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge rounded-pill bg-primary-subtle text-primary extra-small">
                            <i class="bi bi-easel3 me-1"></i> Modul Baru
                        </span>
                        <span class="badge rounded-pill bg-light text-muted extra-small">
                            Template kelas & sesi pembelajaran
                        </span>
                    </div>
                    <h5 class="modal-title small fw-semibold mb-1" id="modalCreateModuleLabel">
                        Buat Modul Kelas Baru
                    </h5>
                    <p class="extra-small text-muted mb-0">
                        Isi informasi dasar modul. Di langkah berikutnya (halaman kelola modul) Anda bisa menyusun
                        struktur <strong>sesi per pertemuan</strong> dan menambah materi & video.
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body small pt-3">
                <div class="row g-3">
                    <!-- KOLOM KIRI: FORM UTAMA -->
                    <div class="col-lg-7">
                        <div class="border rounded-3 p-3 h-100 bg-white">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label extra-small text-muted mb-1">Kode Modul</label>
                                    <input type="text" class="form-control form-control-sm"
                                           placeholder="Contoh: MOD-OM-02">
                                    <div class="form-text extra-small">
                                        Gunakan pola singkat, misal: MOD-<strong>Program</strong>-<strong>Urutan</strong>.
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label extra-small text-muted mb-1">Nama Modul</label>
                                    <input type="text" class="form-control form-control-sm"
                                           placeholder="Contoh: Operator Komputer Lanjutan">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label extra-small text-muted mb-1">Program / Kategori</label>
                                    <select class="form-select form-select-sm">
                                        <option selected>Office & Operator Komputer</option>
                                        <option>Digital Marketing</option>
                                        <option>Barista & F&B</option>
                                        <option>Desain Grafis</option>
                                        <option>Program Lainnya...</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label extra-small text-muted mb-1">Level</label>
                                    <select class="form-select form-select-sm">
                                        <option selected>Basic</option>
                                        <option>Intermediate</option>
                                        <option>Advanced</option>
                                        <option>Campuran (Basic - Intermediate)</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label extra-small text-muted mb-1">Perkiraan jumlah sesi</label>
                                    <input type="number" class="form-control form-control-sm" min="1" max="30"
                                           value="10">
                                    <div class="form-text extra-small">
                                        Contoh: 8–12 sesi untuk program 1–2 bulan.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label extra-small text-muted mb-1">Estimasi durasi total</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" class="form-control form-control-sm" value="20">
                                        <span class="input-group-text">jam</span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label extra-small text-muted mb-1">Deskripsi singkat</label>
                                    <textarea class="form-control form-control-sm" rows="2"
                                              placeholder="Gambaran umum modul, cocok untuk siapa, dan fokus utama pembelajaran."></textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label extra-small text-muted mb-1">Tujuan akhir (learning outcome)</label>
                                    <textarea class="form-control form-control-sm" rows="3"
                                              placeholder="Setelah menyelesaikan modul ini, peserta diharapkan mampu..."></textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label extra-small text-muted mb-1">Prasyarat (opsional)</label>
                                    <textarea class="form-control form-control-sm" rows="2"
                                              placeholder="Contoh: sudah pernah ikut Operator Komputer Dasar, bisa mengetik 10 jari, dll."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: PREVIEW & CATATAN -->
                    <div class="col-lg-5">
                        <div class="border rounded-3 p-3 mb-3 bg-light-subtle h-100">
                            <h6 class="fw-semibold extra-small mb-2">
                                <i class="bi bi-eye me-1"></i> Preview Modul (Ringkasan)
                            </h6>
                            <div class="border rounded-3 p-2 bg-white mb-2">
                                <div class="extra-small text-muted mb-1">Contoh tampilan kartu modul:</div>
                                <div class="mb-1">
                                    <span class="badge bg-primary-subtle text-primary extra-small me-1">MOD-XXX</span>
                                    <span class="badge bg-light text-muted extra-small me-1">Program: Program Terpilih</span>
                                    <span class="badge bg-secondary-subtle text-secondary extra-small">Status: Draft</span>
                                </div>
                                <div class="fw-semibold small mb-1">
                                    Nama Modul yang Anda isi
                                </div>
                                <p class="extra-small text-muted mb-2">
                                    Deskripsi modul singkat akan muncul di sini. Buat 1–2 kalimat yang mudah dipahami
                                    admin & tutor lain saat memilih modul.
                                </p>
                                <div class="row extra-small">
                                    <div class="col-6">
                                        <div class="mb-1">
                                            <i class="bi bi-bar-chart-steps me-1"></i>
                                            Sesi: <strong>10</strong>
                                        </div>
                                        <div class="mb-1">
                                            <i class="bi bi-clock me-1"></i>
                                            Durasi: <strong>20 jam</strong>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-1">
                                            <i class="bi bi-mortarboard me-1"></i>
                                            Level: <strong>Basic</strong>
                                        </div>
                                        <div class="mb-1">
                                            <i class="bi bi-play-circle me-1"></i>
                                            Materi: <strong>0</strong> (awal)
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-light border extra-small mb-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Setelah modul disimpan, Anda akan diarahkan ke halaman
                                <strong>Kelola Modul</strong> untuk menyusun sesi dan menambah materi & video.
                                Saat ini masih demo, jadi tombol simpan belum benar-benar menyimpan data.
                            </div>

                            <ul class="extra-small mb-0">
                                <li>Modul baru otomatis berstatus <strong>Draft</strong>.</li>
                                <li>Admin bisa mengubah status menjadi <strong>Siap dipakai</strong> setelah struktur sesi lengkap.</li>
                                <li>1 modul bisa dipakai oleh banyak kelas aktif (batch pagi/sore, gelombang berbeda).</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="button" class="btn btn-primary btn-sm" disabled>
                    <i class="bi bi-check2-circle me-1"></i> Simpan Modul (Demo)
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
