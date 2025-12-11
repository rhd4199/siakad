<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$title        = 'Arsip Ujian';
$currentPage  = 'arsip-ujian';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

ob_start();
?>
<div class="row mb-3">
    <div class="col-lg-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <h4 class="fw-semibold mb-0">Arsip Ujian</h4>
            <span class="badge rounded-pill bg-secondary-subtle text-secondary extra-small">
                <i class="bi bi-journal-check me-1"></i> Ujian Selesai
            </span>
        </div>
        <p class="text-muted small mb-0">
            Riwayat ujian yang telah selesai dilaksanakan beserta statistik hasilnya.
        </p>
    </div>
</div>

<div class="row g-3">
    <!-- Filter/Search -->
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-2">
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control border-start-0 bg-light" placeholder="Cari arsip ujian...">
                        </div>
                    </div>
                    <div class="col-auto ms-auto">
                        <select class="form-select form-select-sm border-0 bg-light">
                            <option>Semua Kategori</option>
                            <option>UTS</option>
                            <option>UAS</option>
                            <option>Quiz</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ujian 1 -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 opacity-75">
            <div class="card-body small">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge bg-light text-muted border">10 Des 2024</span>
                    <span class="badge bg-success-subtle text-success extra-small"><i class="bi bi-check-circle me-1"></i>Selesai</span>
                </div>
                <h6 class="fw-semibold mb-1 text-dark">Ujian Akhir Semester</h6>
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-secondary-subtle text-secondary extra-small">Digital Marketing</span>
                    <span class="text-muted extra-small">•</span>
                    <span class="text-muted extra-small">DM-02</span>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="p-2 bg-light rounded text-center">
                            <div class="text-muted extra-small mb-1">Peserta</div>
                            <div class="fw-semibold">18/18</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-light rounded text-center">
                            <div class="text-muted extra-small mb-1">Rata-rata</div>
                            <div class="fw-semibold text-success">88.5</div>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetailUjian">
                        <i class="bi bi-file-earmark-text me-1"></i> Detail Ujian
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ujian 2 -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 opacity-75">
            <div class="card-body small">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge bg-light text-muted border">05 Des 2024</span>
                    <span class="badge bg-success-subtle text-success extra-small"><i class="bi bi-check-circle me-1"></i>Selesai</span>
                </div>
                <h6 class="fw-semibold mb-1 text-dark">Quiz Praktik Excel</h6>
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-secondary-subtle text-secondary extra-small">Operator Komputer</span>
                    <span class="text-muted extra-small">•</span>
                    <span class="text-muted extra-small">OM-01</span>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="p-2 bg-light rounded text-center">
                            <div class="text-muted extra-small mb-1">Peserta</div>
                            <div class="fw-semibold">20/20</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-light rounded text-center">
                            <div class="text-muted extra-small mb-1">Rata-rata</div>
                            <div class="fw-semibold text-primary">82.0</div>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetailUjian">
                        <i class="bi bi-file-earmark-text me-1"></i> Detail Ujian
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ujian 3 -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 opacity-75">
            <div class="card-body small">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge bg-light text-muted border">28 Nov 2024</span>
                    <span class="badge bg-success-subtle text-success extra-small"><i class="bi bi-check-circle me-1"></i>Selesai</span>
                </div>
                <h6 class="fw-semibold mb-1 text-dark">Evaluasi Teori Kopi</h6>
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-secondary-subtle text-secondary extra-small">Barista Dasar</span>
                    <span class="text-muted extra-small">•</span>
                    <span class="text-muted extra-small">BRS-01</span>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="p-2 bg-light rounded text-center">
                            <div class="text-muted extra-small mb-1">Peserta</div>
                            <div class="fw-semibold">12/12</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-light rounded text-center">
                            <div class="text-muted extra-small mb-1">Rata-rata</div>
                            <div class="fw-semibold text-success">90.5</div>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetailUjian">
                        <i class="bi bi-file-earmark-text me-1"></i> Detail Ujian
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ujian 4 -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 opacity-75">
            <div class="card-body small">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge bg-light text-muted border">15 Nov 2024</span>
                    <span class="badge bg-success-subtle text-success extra-small"><i class="bi bi-check-circle me-1"></i>Selesai</span>
                </div>
                <h6 class="fw-semibold mb-1 text-dark">Ujian Tengah Semester</h6>
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-secondary-subtle text-secondary extra-small">Operator Komputer</span>
                    <span class="text-muted extra-small">•</span>
                    <span class="text-muted extra-small">OM-01</span>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="p-2 bg-light rounded text-center">
                            <div class="text-muted extra-small mb-1">Peserta</div>
                            <div class="fw-semibold">19/20</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-light rounded text-center">
                            <div class="text-muted extra-small mb-1">Rata-rata</div>
                            <div class="fw-semibold text-warning">76.5</div>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetailUjian">
                        <i class="bi bi-file-earmark-text me-1"></i> Detail Ujian
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Ujian -->
<div class="modal fade" id="modalDetailUjian" tabindex="-1" aria-labelledby="modalDetailUjianLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-semibold" id="modalDetailUjianLabel">Detail Hasil Ujian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0 fw-medium">Ujian Akhir Semester</h6>
                        <span class="text-muted small">Digital Marketing (DM-02) | 10 Des 2024</span>
                    </div>
                    <button class="btn btn-sm btn-outline-success">
                        <i class="bi bi-download me-1"></i> Download Rekap
                    </button>
                </div>

                <!-- Statistik Ringkas di Modal -->
                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <div class="p-2 border rounded bg-light text-center">
                            <small class="text-muted d-block">Tertinggi</small>
                            <span class="fw-bold text-success">98</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 border rounded bg-light text-center">
                            <small class="text-muted d-block">Terendah</small>
                            <span class="fw-bold text-danger">65</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 border rounded bg-light text-center">
                            <small class="text-muted d-block">Rata-rata</small>
                            <span class="fw-bold text-primary">88.5</span>
                        </div>
                    </div>
                </div>

                <div class="table-responsive rounded-3 border">
                    <table class="table table-hover table-striped mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>Nama Peserta</th>
                                <th class="text-center">Waktu</th>
                                <th class="text-center">Benar</th>
                                <th class="text-center">Salah</th>
                                <th class="text-center">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3">1</td>
                                <td>Andi Wijaya</td>
                                <td class="text-center">45m 20s</td>
                                <td class="text-center">48</td>
                                <td class="text-center">2</td>
                                <td class="text-center fw-bold">96</td>
                            </tr>
                            <tr>
                                <td class="ps-3">2</td>
                                <td>Budi Santoso</td>
                                <td class="text-center">50m 10s</td>
                                <td class="text-center">45</td>
                                <td class="text-center">5</td>
                                <td class="text-center fw-bold">90</td>
                            </tr>
                            <tr>
                                <td class="ps-3">3</td>
                                <td>Citra Kirana</td>
                                <td class="text-center">55m 00s</td>
                                <td class="text-center">49</td>
                                <td class="text-center">1</td>
                                <td class="text-center fw-bold">98</td>
                            </tr>
                            <tr>
                                <td class="ps-3">4</td>
                                <td>Dewi Lestari</td>
                                <td class="text-center">40m 15s</td>
                                <td class="text-center">40</td>
                                <td class="text-center">10</td>
                                <td class="text-center fw-bold">80</td>
                            </tr>
                            <tr>
                                <td class="ps-3">5</td>
                                <td>Eko Prasetyo</td>
                                <td class="text-center">48m 30s</td>
                                <td class="text-center">44</td>
                                <td class="text-center">6</td>
                                <td class="text-center fw-bold">88</td>
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