<?php
require_once __DIR__ . '/../config.php';
require_login(['peserta']);

$user         = current_user();
$kodeKelas    = $_GET['kode'] ?? 'OM-01'; // prototipe: anggap OM-01
$namaKelas    = 'Operator Komputer';
$title        = 'Kelas: ' . $namaKelas;
$currentPage  = 'kelas';
$roleBasePath = '/peserta';
$baseUrl      = '/siakad';

// Simulated Data
$meetings = [
    [
        'id' => 1,
        'title' => 'Pengenalan Komputer & Workspace',
        'status' => 'completed',
        'video_title' => 'Pengenalan Komputer',
        'video_duration' => '15 menit',
        'desc' => 'Menjelaskan bagian-bagian dasar komputer, cara menyalakan, dan mengenal tampilan Windows.',
        'files' => [
            ['name' => 'Modul 1 - Pengenalan.pdf', 'type' => 'pdf', 'size' => '2.4 MB'],
            ['name' => 'Shortcut Keys.jpg', 'type' => 'img', 'size' => '500 KB']
        ]
    ],
    [
        'id' => 2,
        'title' => 'Microsoft Word Dasar',
        'status' => 'active',
        'video_title' => 'Tutorial MS Word Part 1',
        'video_duration' => '25 menit',
        'desc' => 'Memulai dokumen baru, formatting teks dasar, dan penyimpanan file.',
        'files' => [
            ['name' => 'Latihan 1 - Surat Lamaran.docx', 'type' => 'doc', 'size' => '1.1 MB']
        ]
    ],
    [
        'id' => 3,
        'title' => 'Microsoft Excel Basic',
        'status' => 'locked',
        'video_title' => '',
        'video_duration' => '',
        'desc' => 'Materi ini akan terbuka setelah Anda menyelesaikan pertemuan sebelumnya.',
        'files' => []
    ]
];

ob_start();
?>
<style>
    .video-placeholder {
        background: linear-gradient(135deg, #212529 0%, #343a40 100%);
        min-height: 200px;
        position: relative;
        overflow: hidden;
    }
    .play-button-overlay {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(4px);
        transition: transform 0.2s;
    }
    .video-placeholder:hover .play-button-overlay {
        transform: scale(1.1);
        background: rgba(255, 255, 255, 0.3);
    }
    .accordion-button:not(.collapsed) {
        background-color: #e7f1ff;
        color: #0c63e4;
        font-weight: 600;
    }
    .accordion-item {
        border: none;
        margin-bottom: 1rem;
        border-radius: 0.5rem !important;
        overflow: hidden;
        box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
    }
    .accordion-button {
        border-radius: 0.5rem !important;
    }
    .accordion-button:not(.collapsed) {
        border-bottom-right-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }
</style>

<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <a href="<?= $baseUrl . $roleBasePath ?>/kelas.php" class="text-decoration-none text-muted small mb-2 d-inline-block">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Kelas
                        </a>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-primary text-white"><?= htmlspecialchars($kodeKelas) ?></span>
                            <span class="badge bg-light text-dark border">Tatap Muka + E-learning</span>
                        </div>
                        <h3 class="fw-bold mb-1"><?= htmlspecialchars($namaKelas) ?></h3>
                        <p class="text-muted mb-0">
                            Tutor: <span class="fw-medium text-dark">Budi Santoso</span> &bull; Jadwal: Senin & Rabu, 08.00–10.00
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="bg-light p-3 rounded-3 d-inline-block text-start" style="min-width: 200px;">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small text-muted fw-bold">PROGRESS BELAJAR</span>
                                <span class="small fw-bold text-primary">40%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="mt-2 extra-small text-muted">
                                4 dari 10 Pertemuan Selesai
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Kolom kiri: Pertemuan & materi -->
    <div class="col-lg-8">
        <h5 class="fw-bold mb-3">Daftar Pertemuan</h5>
        
        <div class="accordion" id="accordionPertemuan">
            <?php foreach ($meetings as $meeting): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?= $meeting['id'] ?>">
                        <button class="accordion-button <?= $meeting['status'] == 'active' ? '' : 'collapsed' ?>" type="button"
                                data-bs-toggle="collapse" data-bs-target="#pertemuan<?= $meeting['id'] ?>"
                                aria-expanded="<?= $meeting['status'] == 'active' ? 'true' : 'false' ?>" 
                                aria-controls="pertemuan<?= $meeting['id'] ?>">
                            <div class="d-flex align-items-center w-100 me-3">
                                <div class="me-3">
                                    <div class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center fw-bold border" style="width: 36px; height: 36px;">
                                        <?= $meeting['id'] ?>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-muted">Pertemuan <?= $meeting['id'] ?></div>
                                    <div class="fw-semibold text-dark"><?= $meeting['title'] ?></div>
                                </div>
                                <div class="ms-auto">
                                    <?php if ($meeting['status'] == 'completed'): ?>
                                        <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle-fill me-1"></i> Selesai</span>
                                    <?php elseif ($meeting['status'] == 'active'): ?>
                                        <span class="badge bg-primary-subtle text-primary"><i class="bi bi-play-circle-fill me-1"></i> Sedang Belajar</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary"><i class="bi bi-lock-fill me-1"></i> Terkunci</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </button>
                    </h2>
                    <div id="pertemuan<?= $meeting['id'] ?>" class="accordion-collapse collapse <?= $meeting['status'] == 'active' ? 'show' : '' ?>"
                         aria-labelledby="heading<?= $meeting['id'] ?>" data-bs-parent="#accordionPertemuan">
                        <div class="accordion-body bg-white border-top">
                            <?php if ($meeting['status'] == 'locked'): ?>
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-lock fs-1 d-block mb-2 opacity-25"></i>
                                    <p class="mb-0 small">Selesaikan pertemuan sebelumnya untuk membuka materi ini.</p>
                                </div>
                            <?php else: ?>
                                <div class="row g-4">
                                    <div class="col-md-7">
                                        <div class="video-placeholder rounded-3 d-flex align-items-center justify-content-center text-white mb-3 shadow-sm">
                                            <div class="play-button-overlay text-white">
                                                <i class="bi bi-play-fill fs-1"></i>
                                            </div>
                                            <div class="position-absolute bottom-0 start-0 p-3 w-100 bg-dark bg-opacity-50 backdrop-blur">
                                                <div class="small fw-bold text-truncate"><?= $meeting['video_title'] ?></div>
                                                <div class="extra-small opacity-75"><i class="bi bi-clock me-1"></i> <?= $meeting['video_duration'] ?></div>
                                            </div>
                                        </div>
                                        <h6 class="fw-bold mb-1">Deskripsi Materi</h6>
                                        <p class="small text-muted mb-0">
                                            <?= $meeting['desc'] ?>
                                        </p>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="bg-light rounded-3 p-3 h-100">
                                            <h6 class="fw-bold small mb-3 text-uppercase text-muted">File Pendukung</h6>
                                            <?php if (empty($meeting['files'])): ?>
                                                <div class="text-muted extra-small fst-italic">Tidak ada file tambahan.</div>
                                            <?php else: ?>
                                                <div class="d-flex flex-column gap-2">
                                                    <?php foreach ($meeting['files'] as $file): ?>
                                                    <div class="d-flex align-items-center bg-white p-2 rounded border shadow-sm">
                                                        <div class="me-2 text-danger fs-4">
                                                            <i class="bi bi-file-earmark-<?= $file['type'] == 'pdf' ? 'pdf' : ($file['type'] == 'doc' ? 'word' : 'image') ?>"></i>
                                                        </div>
                                                        <div class="overflow-hidden">
                                                            <div class="text-truncate small fw-medium"><?= $file['name'] ?></div>
                                                            <div class="extra-small text-muted"><?= $file['size'] ?></div>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <a href="#" class="btn btn-sm btn-light text-primary"><i class="bi bi-download"></i></a>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <hr class="my-3">
                                            
                                            <div class="d-grid">
                                                <button class="btn btn-primary btn-sm">
                                                    <i class="bi bi-check-lg me-1"></i> Tandai Selesai
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Right Sidebar (Discussion / Notes) -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h6 class="fw-bold mb-0">📢 Pengumuman Kelas</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item px-3 py-3">
                        <div class="d-flex gap-2">
                            <div class="avatar-xs bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:32px; height:32px; flex-shrink:0;">
                                <i class="bi bi-megaphone-fill small"></i>
                            </div>
                            <div>
                                <div class="small fw-bold">Perubahan Jadwal</div>
                                <p class="extra-small text-muted mb-1">
                                    Pertemuan minggu depan dimajukan ke jam 08:00 WIB.
                                </p>
                                <div class="extra-small text-muted">2 Jam yang lalu</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 text-center">
                <div class="mb-3 text-muted">
                    <i class="bi bi-chat-left-text fs-1"></i>
                </div>
                <h6 class="fw-bold">Diskusi Kelas</h6>
                <p class="small text-muted mb-3">
                    Ada pertanyaan? Diskusikan dengan tutor dan teman sekelas.
                </p>
                <button class="btn btn-outline-primary w-100">
                    Buka Forum Diskusi
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
