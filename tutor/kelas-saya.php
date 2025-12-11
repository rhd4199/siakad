<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$title        = 'Kelas & Absen';
$currentPage  = 'kelas-saya';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

ob_start();
?>
<div class="row mb-3">
    <div class="col-lg-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <h4 class="fw-semibold mb-0">Kelas & Absen Saya</h4>
            <span class="badge rounded-pill bg-light text-muted extra-small">
                <i class="bi bi-person-video3 me-1"></i> Panel Tutor (Demo)
            </span>
        </div>
        <p class="text-muted small mb-0">
            Lihat kelas yang Anda ampu, buka absen dengan QR & PIN, dan kelola materi per pertemuan.
            Semua data masih dummy, tapi layout sudah disiapkan untuk versi produksi.
        </p>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-primary-subtle text-primary">
                <i class="bi bi-collection"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Total kelas</div>
                <div class="fs-4 fw-semibold">3</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-success-subtle text-success">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Peserta aktif</div>
                <div class="fs-4 fw-semibold">50</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-info-subtle text-info">
                <i class="bi bi-calendar-week"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Sesi hari ini</div>
                <div class="fs-4 fw-semibold">3</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-warning-subtle text-warning">
                <i class="bi bi-check2-square"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Absen terbuka</div>
                <div class="fs-4 fw-semibold">1</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- KOLOM KIRI: LIST KELAS -->
    <div class="col-lg-7">
        <div class="row g-3">
            <!-- Kelas 1 -->
            <div class="col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body small">
                        <div class="d-flex justify-content-between mb-1">
                            <div>
                                <span class="badge bg-primary-subtle text-primary extra-small me-1">OM-01</span>
                                <span class="badge bg-light text-muted extra-small">Pagi • Lab 1</span>
                            </div>
                            <span class="extra-small text-muted">Gelombang Jan</span>
                        </div>
                        <h6 class="fw-semibold mb-1">Operator Komputer – Gelombang Jan</h6>
                        <p class="extra-small text-muted mb-2">
                            Pengenalan komputer & Ms Office dasar untuk pemula yang mau kerja kantoran.
                        </p>

                        <div class="row extra-small mb-2">
                            <div class="col-6">
                                <div class="mb-1">
                                    <i class="bi bi-calendar-week me-1"></i>Senin & Rabu, 08.00–10.00
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-people me-1"></i>Peserta aktif: <strong>20</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-1">
                                    <i class="bi bi-bar-chart-line me-1"></i>PR menunggu nilai: <strong>3</strong>
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-journal-check me-1"></i>Pertemuan: <strong>7 / 10</strong>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-2">
                            <div class="extra-small text-muted">
                                Materi & video per pertemuan bisa diatur dari halaman <strong>Kelola Kelas</strong>.
                            </div>
                            <div class="btn-group btn-group-sm">
                                <a href="<?= $baseUrl . $roleBasePath ?>/kelas-detail.php?kode=OM-01"
                                   class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-sliders me-1"></i> Kelola Kelas
                                </a>
                                <button class="btn btn-outline-primary btn-sm"
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalBukaAbsenOM01">
                                    <i class="bi bi-qr-code me-1"></i> Buka Absen
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" type="button" disabled>
                                    <i class="bi bi-clipboard-data me-1"></i> Rekap Absen
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kelas 2 -->
            <div class="col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body small">
                        <div class="d-flex justify-content-between mb-1">
                            <div>
                                <span class="badge bg-info-subtle text-info extra-small me-1">DM-02</span>
                                <span class="badge bg-light text-muted extra-small">Sore • Ruang 2</span>
                            </div>
                            <span class="extra-small text-muted">Batch Sore</span>
                        </div>
                        <h6 class="fw-semibold mb-1">Digital Marketing – Batch Sore</h6>
                        <p class="extra-small text-muted mb-2">
                            Sosial media, konten, dan iklan dasar untuk bisnis kecil & UMKM.
                        </p>

                        <div class="row extra-small mb-2">
                            <div class="col-6">
                                <div class="mb-1">
                                    <i class="bi bi-calendar-week me-1"></i>Selasa & Kamis, 13.00–15.00
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-people me-1"></i>Peserta aktif: <strong>18</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-1">
                                    <i class="bi bi-bar-chart-line me-1"></i>PR menunggu nilai: <strong>4</strong>
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-journal-check me-1"></i>Pertemuan: <strong>4 / 8</strong>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-2">
                            <div class="extra-small text-muted">
                                Absen disarankan dibuka 5 menit sebelum kelas mulai.
                            </div>
                            <div class="btn-group btn-group-sm">
                                <a href="<?= $baseUrl . $roleBasePath ?>/kelas-detail.php?kode=DM-02"
                                   class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-sliders me-1"></i> Kelola Kelas
                                </a>
                                <button class="btn btn-success btn-sm" type="button" disabled>
                                    <i class="bi bi-unlock me-1"></i> Buka Absen (Demo)
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" type="button" disabled>
                                    <i class="bi bi-clipboard-data me-1"></i> Rekap Absen
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kelas 3 -->
            <div class="col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body small">
                        <div class="d-flex justify-content-between mb-1">
                            <div>
                                <span class="badge bg-warning-subtle text-warning extra-small me-1">BRS-01</span>
                                <span class="badge bg-light text-muted extra-small">Intensif • Ruang 3</span>
                            </div>
                            <span class="extra-small text-muted">Kelas Intensif</span>
                        </div>
                        <h6 class="fw-semibold mb-1">Barista Dasar – Kelas Intensif</h6>
                        <p class="extra-small text-muted mb-2">
                            Basic coffee, penggunaan alat, dan servis customer di coffee shop.
                        </p>

                        <div class="row extra-small mb-2">
                            <div class="col-6">
                                <div class="mb-1">
                                    <i class="bi bi-calendar-week me-1"></i>Jumat & Sabtu, 09.00–11.00
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-people me-1"></i>Peserta aktif: <strong>12</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-1">
                                    <i class="bi bi-bar-chart-line me-1"></i>PR menunggu nilai: <strong>0</strong>
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-journal-check me-1"></i>Pertemuan: <strong>5 / 6</strong>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-2">
                            <div class="extra-small text-muted">
                                Rekap absen & nilai praktik akan masuk ke rapor Barista Dasar.
                            </div>
                            <div class="btn-group btn-group-sm">
                                <a href="<?= $baseUrl . $roleBasePath ?>/kelas-detail.php?kode=BRS-01"
                                   class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-sliders me-1"></i> Kelola Kelas
                                </a>
                                <button class="btn btn-outline-secondary btn-sm" type="button" disabled>
                                    <i class="bi bi-qr-code me-1"></i> Buka Absen
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" type="button" disabled>
                                    <i class="bi bi-clipboard-data me-1"></i> Rekap Absen
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: SESI HARI INI & ABSEN -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body small">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-semibold mb-0">Sesi Hari Ini & Absen</h6>
                    <span class="extra-small text-muted">
                        Fokus ke jadwal hari ini saja, biar tutor nggak pusing.
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light extra-small text-muted">
                            <tr>
                                <th>Jam</th>
                                <th>Kelas</th>
                                <th class="text-center">Peserta</th>
                                <th>Status</th>
                                <th style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="extra-small">
                            <tr>
                                <td>08.00 – 10.00</td>
                                <td>
                                    <div class="fw-semibold small">OM-01</div>
                                    <div class="text-muted">Operator Komputer</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary-subtle text-primary">20</span>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success">
                                        <i class="bi bi-check2-square me-1"></i>Absen dibuka
                                    </span>
                                    <div class="text-muted">
                                        Hadir: 16 • Izin: 2
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-outline-secondary btn-sm w-100" disabled>
                                        <i class="bi bi-eye me-1"></i> Lihat Rekap
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>10.15 – 12.00</td>
                                <td>
                                    <div class="fw-semibold small">DM-02</div>
                                    <div class="text-muted">Digital Marketing</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary-subtle text-primary">18</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning-subtle text-warning">
                                        <i class="bi bi-clock-history me-1"></i>Belum dibuka
                                    </span>
                                    <div class="text-muted">
                                        Buka absen 5 menit sebelum mulai
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-success btn-sm w-100" disabled>
                                        <i class="bi bi-unlock me-1"></i> Buka Absen
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>13.00 – 15.00</td>
                                <td>
                                    <div class="fw-semibold small">BRS-01</div>
                                    <div class="text-muted">Barista Dasar</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary-subtle text-primary">12</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        <i class="bi bi-clipboard-check me-1"></i>Selesai
                                    </span>
                                    <div class="text-muted">
                                        Hadir: 11 • Alfa: 1
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-outline-secondary btn-sm w-100" disabled>
                                        <i class="bi bi-clipboard-data me-1"></i> Rekap
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body small">
                <h6 class="fw-semibold mb-2">Flow Absen dengan QR & PIN</h6>
                <ol class="extra-small mb-2">
                    <li>Tutor klik <strong>Buka Absen</strong> di kelas yang sesuai.</li>
                    <li>Sistem generate <strong>QR code + link khusus</strong> untuk pertemuan itu.</li>
                    <li>Peserta scan QR / buka link → muncul halaman tanpa login berisi:
                        nama kelas, input NIP & PIN.
                    </li>
                    <li>Jika NIP + PIN valid, status kehadiran tersimpan otomatis.</li>
                </ol>
                <p class="extra-small text-muted mb-0">
                    Di versi ini masih demo. Nanti backend tinggal isi token, validasi NIP & PIN,
                    dan hubungkan ke raport.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- MODAL BUKA ABSEN: OM-01 -->
<div class="modal fade" id="modalBukaAbsenOM01" tabindex="-1" aria-labelledby="modalBukaAbsenOM01Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h6 class="modal-title small fw-semibold" id="modalBukaAbsenOM01Label">
                        Buka Absen – Operator Komputer (OM-01)
                    </h6>
                    <p class="extra-small text-muted mb-0">
                        Tampilan ini mensimulasikan saat tutor membuka absen: QR code + link khusus
                        untuk pertemuan hari ini.
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small pt-3">
                <div class="row g-3">
                    <div class="col-md-5">
                        <div class="border rounded-3 p-3 h-100 d-flex flex-column align-items-center justify-content-center bg-light-subtle">
                            <div class="mb-2">
                                <i class="bi bi-qr-code" style="font-size: 3rem;"></i>
                            </div>
                            <div class="extra-small text-muted text-center">
                                Di versi final: QR code asli akan muncul di sini.
                                Peserta cukup scan untuk membuka halaman absen.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="border rounded-3 p-3 h-100">
                            <h6 class="fw-semibold extra-small mb-2">Link Absen untuk Peserta</h6>
                            <div class="mb-2">
                                <label class="form-label extra-small text-muted mb-1">URL Absen (contoh)</label>
                                <div class="input-group input-group-sm">
                                    <input type="text"
                                           class="form-control"
                                           value="<?= $baseUrl ?>/absen-kelas.php?token=DEMO-OM01-123"
                                           readonly>
                                    <button class="btn btn-outline-secondary" type="button" disabled>
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                                <div class="form-text extra-small">
                                    Link ini bisa dikirim ke grup WA kelas kalau perlu.
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label extra-small text-muted mb-1">Contoh tampilan di HP peserta</label>
                                <div class="border rounded-3 p-2 bg-light-subtle">
                                    <div class="extra-small mb-1"><strong>Absen Kelas: OM-01 – Operator Komputer</strong></div>
                                    <div class="extra-small text-muted mb-1">
                                        Masukkan NIP dan PIN absen yang kamu terima dari LPK.
                                    </div>
                                    <div class="mb-1 extra-small">
                                        <div class="mb-1">NIP Peserta</div>
                                        <div class="form-control form-control-sm disabled bg-white-50 border-dashed">
                                            DA-NIP-2025-00xx
                                        </div>
                                    </div>
                                    <div class="mb-1 extra-small">
                                        <div class="mb-1">PIN Absen</div>
                                        <div class="form-control form-control-sm disabled bg-white-50 border-dashed">
                                            ••••
                                        </div>
                                    </div>
                                    <div class="d-grid mt-2">
                                        <button class="btn btn-success btn-sm" disabled>
                                            <i class="bi bi-check2-circle me-1"></i> Absen (Demo)
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-light border extra-small mb-0">
                                <i class="bi bi-info-circle me-1"></i>
                                Validasi sebenarnya nanti dilakukan di backend:
                                token pertemuan + NIP + PIN → jika cocok, status kehadiran disimpan dan
                                terkunci untuk pertemuan ini.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button type="button" class="btn btn-success btn-sm" disabled>
                    <i class="bi bi-unlock me-1"></i> Buka Absen (Demo)
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
