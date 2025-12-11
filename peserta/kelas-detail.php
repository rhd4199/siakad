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
$moduleInfo = [
    'description' => 'Modul ini dirancang untuk memperkenalkan peserta pada dasar-dasar pengoperasian komputer, mulai dari pengenalan hardware hingga penggunaan aplikasi perkantoran dasar seperti Microsoft Office.',
    'cover_img' => 'https://placehold.co/600x400/2563eb/ffffff?text=Operator+Komputer',
    'general' => [
        'videos' => [
            [
                'title' => 'Video Orientasi Kelas',
                'file' => 'orientasi_ok.mp4',
                'size' => '15 MB'
            ]
        ],
        'files' => [
            [
                'title' => 'Silabus Lengkap',
                'type' => 'pdf',
                'size' => '2.5 MB'
            ],
            [
                'title' => 'Tata Tertib Kelas',
                'type' => 'pdf',
                'size' => '500 KB'
            ]
        ],
        'note' => 'Selamat datang di kelas Operator Komputer. Silakan unduh silabus dan tata tertib kelas. Video orientasi wajib ditonton sebelum memulai pertemuan pertama.'
    ]
];

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
        ],
        'assignment' => null
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
        ],
        'assignment' => [
            'title' => 'Praktik Membuat Surat Lamaran',
            'desc' => 'Buatlah surat lamaran kerja formal menggunakan fitur formatting yang telah dipelajari. Simpan dalam format DOCX atau PDF.',
            'deadline' => 'Besok, 23:59 WIB',
            'status' => 'pending' // pending, submitted, graded
        ]
    ],
    [
        'id' => 3,
        'title' => 'Microsoft Excel Basic',
        'status' => 'locked',
        'video_title' => '',
        'video_duration' => '',
        'desc' => 'Materi ini akan terbuka setelah Anda menyelesaikan pertemuan sebelumnya.',
        'files' => [],
        'assignment' => null
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
    .border-dashed {
        border-style: dashed !important;
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

<!-- INFO & GENERAL RESOURCES SECTION -->
<div class="row g-4 mb-5">
    <!-- Left: Description & Info -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-info-circle me-2 text-primary"></i>Informasi Modul</h6>
                </div>
                <div class="ratio ratio-16x9 bg-light rounded-3 mb-3 overflow-hidden position-relative">
                    <img src="<?= $moduleInfo['cover_img'] ?>" class="object-fit-cover">
                </div>
                <p class="text-muted small mb-0">
                    <?= $moduleInfo['description'] ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Right: General Resources (Tabs) -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0"><i class="bi bi-collection-play me-2 text-primary"></i>Materi Umum & Catatan</h6>
                </div>
                <ul class="nav nav-tabs card-header-tabs" id="generalTab" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active small" data-bs-toggle="tab" data-bs-target="#gen-video">Video Umum</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link small" data-bs-toggle="tab" data-bs-target="#gen-file">File & Dokumen</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link small" data-bs-toggle="tab" data-bs-target="#gen-note">Catatan Tutor</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="generalTabContent">
                    <!-- General Video -->
                    <div class="tab-pane fade show active" id="gen-video">
                        <div class="list-group list-group-flush">
                            <?php if(empty($moduleInfo['general']['videos'])): ?>
                                <div class="text-center py-3 text-muted small">Tidak ada video umum.</div>
                            <?php else: ?>
                                <?php foreach ($moduleInfo['general']['videos'] as $vid): ?>
                                <div class="list-group-item px-0 d-flex align-items-center gap-3">
                                    <div class="bg-light rounded p-2 text-danger">
                                        <i class="bi bi-file-play-fill fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium small"><?= $vid['title'] ?></div>
                                        <div class="text-muted extra-small">File: <?= $vid['file'] ?> (<?= $vid['size'] ?>)</div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="#" class="btn btn-sm btn-light text-primary"><i class="bi bi-play-circle me-1"></i> Tonton</a>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- General File -->
                    <div class="tab-pane fade" id="gen-file">
                        <div class="list-group list-group-flush">
                            <?php if(empty($moduleInfo['general']['files'])): ?>
                                <div class="text-center py-3 text-muted small">Tidak ada file umum.</div>
                            <?php else: ?>
                                <?php foreach ($moduleInfo['general']['files'] as $file): ?>
                                <div class="list-group-item px-0 d-flex align-items-center gap-3">
                                    <div class="bg-light rounded p-2 text-primary">
                                        <i class="bi bi-file-earmark-text-fill fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium small"><?= $file['title'] ?></div>
                                        <div class="text-muted extra-small"><?= strtoupper($file['type']) ?> • <?= $file['size'] ?></div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="#" class="btn btn-sm btn-light text-primary"><i class="bi bi-download me-1"></i> Download</a>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- General Note -->
                    <div class="tab-pane fade" id="gen-note">
                        <div class="bg-light-subtle rounded-3 p-3 border border-dashed">
                            <div class="small text-dark">
                                <?= $moduleInfo['general']['note'] ?? 'Tidak ada catatan tambahan.' ?>
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
                                        <p class="small text-muted mb-4">
                                            <?= $meeting['desc'] ?>
                                        </p>

                                        <?php if (!empty($meeting['assignment'])): ?>
                                            <div class="card border border-warning-subtle bg-warning-subtle bg-opacity-10 shadow-sm">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <div class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i> TUGAS</div>
                                                        <div class="small text-muted">Deadline: <strong><?= $meeting['assignment']['deadline'] ?></strong></div>
                                                    </div>
                                                    <h6 class="fw-bold"><?= $meeting['assignment']['title'] ?></h6>
                                                    <p class="small text-muted mb-3"><?= $meeting['assignment']['desc'] ?></p>
                                                    
                                                    <?php if ($meeting['assignment']['status'] == 'pending'): ?>
                                                        <div id="uploadArea<?= $meeting['id'] ?>">
                                                            <input type="file" id="fileInput<?= $meeting['id'] ?>" class="d-none" accept=".pdf,.docx,.doc" onchange="handleFileUpload(<?= $meeting['id'] ?>, this)">
                                                            <div class="border border-dashed border-2 border-secondary rounded p-4 text-center bg-white cursor-pointer hover-bg-light transition-all" 
                                                                 onclick="document.getElementById('fileInput<?= $meeting['id'] ?>').click()"
                                                                 id="dropZone<?= $meeting['id'] ?>">
                                                                <i class="bi bi-cloud-arrow-up fs-3 text-primary mb-2 d-block"></i>
                                                                <div class="fw-bold text-dark small">Klik untuk Upload Tugas</div>
                                                                <div class="extra-small text-muted">Format: PDF, DOCX (Max 5MB)</div>
                                                            </div>
                                                            
                                                            <!-- Progress Bar (Hidden initially) -->
                                                            <div id="uploadProgress<?= $meeting['id'] ?>" class="d-none mt-3">
                                                                <div class="d-flex justify-content-between extra-small fw-bold text-muted mb-1">
                                                                    <span>Mengupload...</span>
                                                                    <span id="progressText<?= $meeting['id'] ?>">0%</span>
                                                                </div>
                                                                <div class="progress" style="height: 6px;">
                                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" id="progressBar<?= $meeting['id'] ?>"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Success State (Hidden initially) -->
                                                        <div id="uploadSuccess<?= $meeting['id'] ?>" class="d-none">
                                                            <div class="alert alert-success d-flex align-items-center gap-2 mb-0 py-2">
                                                                <i class="bi bi-check-circle-fill"></i>
                                                                <div class="small fw-bold">Tugas berhasil dikumpulkan.</div>
                                                            </div>
                                                            <div class="mt-2 text-end">
                                                                <button class="btn btn-sm btn-link text-danger text-decoration-none extra-small" onclick="resetUpload(<?= $meeting['id'] ?>)">
                                                                    Batalkan Pengumpulan
                                                                </button>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="alert alert-success d-flex align-items-center gap-2 mb-0 py-2">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                            <div class="small fw-bold">Tugas berhasil dikumpulkan.</div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
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

<script>
    function handleFileUpload(id, input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const dropZone = document.getElementById('dropZone' + id);
            const progressArea = document.getElementById('uploadProgress' + id);
            const progressBar = document.getElementById('progressBar' + id);
            const progressText = document.getElementById('progressText' + id);
            const uploadArea = document.getElementById('uploadArea' + id);
            const successArea = document.getElementById('uploadSuccess' + id);
            
            // Validate size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('File terlalu besar! Maksimal 5MB.');
                input.value = '';
                return;
            }

            // UI Update: Hide Dropzone content partly or disable it
            dropZone.style.opacity = '0.5';
            dropZone.style.pointerEvents = 'none';
            progressArea.classList.remove('d-none');

            // Simulate Upload
            let progress = 0;
            const interval = setInterval(() => {
                progress += Math.floor(Math.random() * 10) + 5;
                if (progress > 100) progress = 100;
                
                progressBar.style.width = progress + '%';
                progressText.textContent = progress + '%';

                if (progress === 100) {
                    clearInterval(interval);
                    setTimeout(() => {
                        // Switch to success state
                        uploadArea.classList.add('d-none');
                        successArea.classList.remove('d-none');
                        
                        // Reset for next time (in background)
                        progressBar.style.width = '0%';
                        progressArea.classList.add('d-none');
                        dropZone.style.opacity = '1';
                        dropZone.style.pointerEvents = 'auto';
                    }, 500);
                }
            }, 200);
        }
    }

    function resetUpload(id) {
        if (confirm('Apakah Anda yakin ingin membatalkan pengumpulan tugas ini?')) {
            const uploadArea = document.getElementById('uploadArea' + id);
            const successArea = document.getElementById('uploadSuccess' + id);
            const input = document.getElementById('fileInput' + id);
            
            input.value = '';
            uploadArea.classList.remove('d-none');
            successArea.classList.add('d-none');
        }
    }
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
