<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$title        = 'Arsip Kelas';
$currentPage  = 'arsip-kelas';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

ob_start();
?>
<div class="row mb-3">
    <div class="col-lg-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <h4 class="fw-semibold mb-0">Arsip Kelas</h4>
            <span class="badge rounded-pill bg-secondary-subtle text-secondary extra-small">
                <i class="bi bi-archive me-1"></i> Kelas Selesai
            </span>
        </div>
        <p class="text-muted small mb-0">
            Daftar kelas yang sudah selesai masa pembelajarannya. Anda dapat melihat rekap nilai dan absen.
        </p>
    </div>
</div>

<div class="row g-3">
    <!-- Filter/Search (Optional, visually appealing) -->
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-2">
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control border-start-0 bg-light" placeholder="Cari kelas lama...">
                        </div>
                    </div>
                    <div class="col-auto ms-auto">
                        <select class="form-select form-select-sm border-0 bg-light">
                            <option>Tahun 2024</option>
                            <option>Tahun 2023</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kelas 1 -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 opacity-75">
            <div class="card-body small">
                <div class="d-flex justify-content-between mb-1">
                    <div>
                        <span class="badge bg-secondary-subtle text-secondary extra-small me-1">OM-00-23</span>
                        <span class="badge bg-light text-muted extra-small">Selesai: Des 2023</span>
                    </div>
                    <span class="extra-small text-muted"><i class="bi bi-check-all text-success"></i> Finalized</span>
                </div>
                <h6 class="fw-semibold mb-1 text-muted">Operator Komputer – Batch Akhir Tahun</h6>
                <p class="extra-small text-muted mb-2">
                    Pengenalan komputer dasar untuk batch Desember 2023.
                </p>

                <div class="row extra-small mb-3 text-muted">
                    <div class="col-6">
                        <div class="mb-1">
                            <i class="bi bi-people me-1"></i>Peserta: <strong>25</strong>
                        </div>
                        <div class="mb-1">
                            <i class="bi bi-award me-1"></i>Lulus: <strong>24</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-1">
                            <i class="bi bi-journal-check me-1"></i>Pertemuan: <strong>12/12</strong>
                        </div>
                        <div class="mb-1">
                            <i class="bi bi-star me-1"></i>Rata-rata: <strong>85.5</strong>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalRekapNilai">
                        <i class="bi bi-eye me-1"></i> Lihat Rekap Nilai
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Kelas 2 -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 opacity-75">
            <div class="card-body small">
                <div class="d-flex justify-content-between mb-1">
                    <div>
                        <span class="badge bg-secondary-subtle text-secondary extra-small me-1">DM-01-23</span>
                        <span class="badge bg-light text-muted extra-small">Selesai: Nov 2023</span>
                    </div>
                    <span class="extra-small text-muted"><i class="bi bi-check-all text-success"></i> Finalized</span>
                </div>
                <h6 class="fw-semibold mb-1 text-muted">Digital Marketing – Batch November</h6>
                <p class="extra-small text-muted mb-2">
                    Dasar ads dan content creation.
                </p>

                <div class="row extra-small mb-3 text-muted">
                    <div class="col-6">
                        <div class="mb-1">
                            <i class="bi bi-people me-1"></i>Peserta: <strong>15</strong>
                        </div>
                        <div class="mb-1">
                            <i class="bi bi-award me-1"></i>Lulus: <strong>15</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-1">
                            <i class="bi bi-journal-check me-1"></i>Pertemuan: <strong>8/8</strong>
                        </div>
                        <div class="mb-1">
                            <i class="bi bi-star me-1"></i>Rata-rata: <strong>88.0</strong>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalRekapNilai">
                        <i class="bi bi-eye me-1"></i> Lihat Rekap Nilai
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Kelas 3 -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 opacity-75">
            <div class="card-body small">
                <div class="d-flex justify-content-between mb-1">
                    <div>
                        <span class="badge bg-secondary-subtle text-secondary extra-small me-1">BRS-02-23</span>
                        <span class="badge bg-light text-muted extra-small">Selesai: Okt 2023</span>
                    </div>
                    <span class="extra-small text-muted"><i class="bi bi-check-all text-success"></i> Finalized</span>
                </div>
                <h6 class="fw-semibold mb-1 text-muted">Barista Dasar – Weekend Class</h6>
                <p class="extra-small text-muted mb-2">
                    Kelas khusus weekend untuk karyawan.
                </p>

                <div class="row extra-small mb-3 text-muted">
                    <div class="col-6">
                        <div class="mb-1">
                            <i class="bi bi-people me-1"></i>Peserta: <strong>10</strong>
                        </div>
                        <div class="mb-1">
                            <i class="bi bi-award me-1"></i>Lulus: <strong>10</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-1">
                            <i class="bi bi-journal-check me-1"></i>Pertemuan: <strong>6/6</strong>
                        </div>
                        <div class="mb-1">
                            <i class="bi bi-star me-1"></i>Rata-rata: <strong>90.5</strong>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalRekapNilai">
                        <i class="bi bi-eye me-1"></i> Lihat Rekap Nilai
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Rekap Nilai -->
<div class="modal fade" id="modalRekapNilai" tabindex="-1" aria-labelledby="modalRekapNilaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-semibold" id="modalRekapNilaiLabel">Rekap Nilai Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0 fw-medium">Operator Komputer – Batch Akhir Tahun</h6>
                        <span class="text-muted small">Kode: OM-00-23 | Selesai: Des 2023</span>
                    </div>
                    <button class="btn btn-sm btn-success">
                        <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export Excel
                    </button>
                </div>

                <div class="table-responsive rounded-3 border">
                    <table class="table table-hover table-striped mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>Nama Peserta</th>
                                <th class="text-center">Kehadiran</th>
                                <th class="text-center">Tugas</th>
                                <th class="text-center">Ujian</th>
                                <th class="text-center">Akhir</th>
                                <th class="text-center">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3">1</td>
                                <td>Ahmad Fulan</td>
                                <td class="text-center">100%</td>
                                <td class="text-center">85</td>
                                <td class="text-center">90</td>
                                <td class="text-center fw-bold">88</td>
                                <td class="text-center"><span class="badge bg-success">A</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3">2</td>
                                <td>Budi Santoso</td>
                                <td class="text-center">90%</td>
                                <td class="text-center">80</td>
                                <td class="text-center">85</td>
                                <td class="text-center fw-bold">83</td>
                                <td class="text-center"><span class="badge bg-primary">B+</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3">3</td>
                                <td>Citra Dewi</td>
                                <td class="text-center">95%</td>
                                <td class="text-center">88</td>
                                <td class="text-center">92</td>
                                <td class="text-center fw-bold">90</td>
                                <td class="text-center"><span class="badge bg-success">A</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3">4</td>
                                <td>Doni Pratama</td>
                                <td class="text-center">85%</td>
                                <td class="text-center">75</td>
                                <td class="text-center">78</td>
                                <td class="text-center fw-bold">77</td>
                                <td class="text-center"><span class="badge bg-primary">B</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3">5</td>
                                <td>Eka Saputra</td>
                                <td class="text-center">100%</td>
                                <td class="text-center">90</td>
                                <td class="text-center">95</td>
                                <td class="text-center fw-bold">93</td>
                                <td class="text-center"><span class="badge bg-success">A</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>