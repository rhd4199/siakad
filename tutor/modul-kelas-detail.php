<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$kodeModul    = $_GET['kode'] ?? 'MOD-OM-01';
$title        = 'Kelola Modul: ' . $kodeModul;
$currentPage  = 'modul-kelas';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

// Dummy Module Info
$moduleInfo = [
    'title'       => 'Operator Komputer Dasar',
    'code'        => 'MOD-OM-01',
    'category'    => 'Office & Administrasi',
    'level'       => 'Basic',
    'description' => 'Modul ini dirancang untuk pemula yang ingin menguasai dasar-dasar pengoperasian komputer dan aplikasi perkantoran Microsoft Office (Word, Excel, PowerPoint).',
    'sessions'    => 16,
    'duration'    => 32, // jam
    'cover_img'   => 'https://source.unsplash.com/random/800x600?computer',
    // General Resources (Overall)
    'general' => [
        'videos' => [
            ['title' => 'Sambutan Instruktur', 'file' => 'welcome.mp4', 'size' => '15 MB'],
            ['title' => 'Panduan Install Software', 'file' => 'install-guide.mp4', 'size' => '45 MB'],
        ],
        'files' => [
            ['title' => 'Silabus Lengkap', 'type' => 'pdf', 'size' => '1.2 MB'],
            ['title' => 'Software Requirements', 'type' => 'txt', 'size' => '2 KB'],
        ],
        'note' => '<p><strong>Selamat datang di kelas ini!</strong><br>Silakan unduh semua software yang dibutuhkan sebelum memulai pertemuan pertama. Jika ada kendala instalasi, hubungi admin.</p>'
    ]
];

// Dummy Curriculum Data Generator (16 Sessions)
$curriculum = [];
$topics = [
    'Pengenalan Komputer & Windows', 'Microsoft Word Dasar', 'Formatting Dokumen', 'Mail Merge & Printing',
    'Microsoft Excel Dasar', 'Formula & Fungsi Dasar', 'Pengolahan Data & Grafik', 'Pivot Table',
    'Microsoft PowerPoint Dasar', 'Desain Slide & Transisi', 'Animasi & Multimedia', 'Presentasi Efektif',
    'Pengenalan Internet & Email', 'Google Workspace', 'Keamanan Digital Dasar', 'Review & Ujian Akhir'
];

for ($i = 0; $i < 16; $i++) {
    $topic = $topics[$i] ?? "Topik Lanjutan " . ($i + 1);
    $curriculum[] = [
        'title' => "Pertemuan " . ($i + 1) . ": $topic",
        'summary' => "Pada pertemuan ini, peserta akan mempelajari konsep $topic secara mendalam melalui teori dan praktik langsung.",
        'note_tutor' => ($i % 3 == 0) ? "<p><strong>Catatan Tutor:</strong><br>Pastikan peserta sudah menginstall software terkait sebelum memulai sesi ini.</p>" : "",
        'videos' => ($i % 2 == 0) ? [
            ['title' => "Tutorial $topic Part 1", 'file' => "vid-sess".($i+1).".mp4", 'duration' => '15:00', 'size' => '150 MB']
        ] : [],
        'materials' => [
            ['type' => 'pdf', 'title' => "Modul $topic", 'size' => '2.1 MB']
        ],
        'assignments' => ($i % 4 == 0) ? [
            ['type' => 'quiz', 'title' => "Kuis $topic", 'duration' => '15 min']
        ] : []
    ];
}

ob_start();
?>
<!-- Include Quill Styles -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-start mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= $baseUrl . $roleBasePath ?>/modul-kelas.php" class="btn btn-light rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h4 class="fw-bold mb-0"><?= $moduleInfo['title'] ?></h4>
                <span class="badge bg-light text-muted border"><?= $moduleInfo['code'] ?></span>
            </div>
            <div class="text-muted small">
                <?= $moduleInfo['category'] ?> • <?= $moduleInfo['level'] ?> • <?= count($curriculum) ?> Sesi
            </div>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalEditInfo">
            <i class="bi bi-pencil me-2"></i>Edit Info
        </button>
        <button class="btn btn-primary rounded-pill px-3">
            <i class="bi bi-save me-2"></i>Simpan
        </button>
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
                <div class="ratio ratio-16x9 bg-light rounded-3 mb-3 overflow-hidden position-relative group-hover-container">
                    <img src="<?= $moduleInfo['cover_img'] ?>" class="object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center opacity-0 hover-opacity-100 transition-all">
                        <button class="btn btn-light rounded-pill btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditInfo"><i class="bi bi-camera me-2"></i>Ganti Sampul</button>
                    </div>
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
                    <button class="btn btn-sm btn-light rounded-pill px-3 text-primary" data-bs-toggle="modal" data-bs-target="#modalAddGeneral">
                        <i class="bi bi-plus-lg me-1"></i>Tambah
                    </button>
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
                                    <button class="btn btn-sm btn-icon text-danger bg-danger-subtle rounded-circle" title="Hapus Video"><i class="bi bi-trash"></i></button>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-icon text-muted" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                            <li><a class="dropdown-item small" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                            <li><a class="dropdown-item small text-danger" href="#"><i class="bi bi-trash me-2"></i>Hapus</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- General File -->
                    <div class="tab-pane fade" id="gen-file">
                        <div class="list-group list-group-flush">
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
                                <button class="btn btn-sm btn-icon text-danger bg-danger-subtle rounded-circle" title="Hapus File"><i class="bi bi-trash"></i></button>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-icon text-muted" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                        <li><a class="dropdown-item small" href="#"><i class="bi bi-download me-2"></i>Download</a></li>
                                        <li><a class="dropdown-item small text-danger" href="#"><i class="bi bi-trash me-2"></i>Hapus</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- General Note -->
                    <div class="tab-pane fade" id="gen-note">
                        <div class="bg-light-subtle rounded-3 p-3 border border-dashed">
                            <div class="small text-dark">
                                <?= $moduleInfo['general']['note'] ?>
                            </div>
                            <div class="mt-3 text-end">
                                <button class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalEditGeneralNote">
                                    <i class="bi bi-pencil-square me-1"></i> Edit Catatan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CURRICULUM BUILDER -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Kurikulum & Sesi Pertemuan</h5>
    <button class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAddSession">
        <i class="bi bi-plus-lg me-1"></i> Tambah Pertemuan
    </button>
</div>

<div class="d-flex flex-column gap-3" id="curriculumAccordion">
    <?php foreach ($curriculum as $index => $section): ?>
    <div class="accordion-item border shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="accordion-header">
            <div class="accordion-button <?= $index === 0 ? '' : 'collapsed' ?> bg-white py-4 px-4 shadow-none w-100" role="button" data-bs-toggle="collapse" data-bs-target="#section-<?= $index ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="section-<?= $index ?>">
                <div class="d-flex align-items-center w-100 me-3">
                    <div class="me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 42px; height: 42px; font-size: 1.1rem;">
                        <?= $index + 1 ?>
                    </div>
                    <div class="me-auto">
                        <div class="fw-bold text-dark fs-5 mb-1"><?= $section['title'] ?></div>
                        <div class="small text-muted text-truncate d-none d-md-block opacity-75" style="max-width: 600px;"><?= $section['summary'] ?></div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex gap-1">
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle" title="Video"><i class="bi bi-play-fill"></i> <?= count($section['videos']) ?></span>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle" title="Materi"><i class="bi bi-file-text-fill"></i> <?= count($section['materials']) ?></span>
                        </div>
                        <div class="dropdown" onclick="event.stopPropagation();">
                            <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                <li><a class="dropdown-item small" href="#"><i class="bi bi-pencil me-2"></i>Edit Sesi</a></li>
                                <li><a class="dropdown-item small text-danger" href="#"><i class="bi bi-trash me-2"></i>Hapus Sesi</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div id="section-<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" data-bs-parent="#curriculumAccordion">
                <div class="accordion-body bg-light-subtle p-0">
                    
                    <!-- 1. Note Tutor Section -->
                    <div class="p-4 border-bottom bg-white">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold small text-dark mb-0"><i class="bi bi-journal-richtext me-2 text-warning"></i>Catatan & Materi Teks</h6>
                            <button class="btn btn-link btn-sm p-0 text-decoration-none extra-small" data-bs-toggle="modal" data-bs-target="#modalEditNote">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </button>
                        </div>
                        <div class="p-3 bg-warning-subtle rounded-3 border border-warning-subtle small text-dark">
                            <?php if(!empty($section['note_tutor'])): ?>
                                <?= $section['note_tutor'] ?>
                            <?php else: ?>
                                <span class="text-muted fst-italic">Belum ada catatan untuk pertemuan ini.</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row g-0">
                        <!-- 2. Videos Column -->
                        <div class="col-md-6 border-end">
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold small text-dark mb-0"><i class="bi bi-youtube me-2 text-danger"></i>Video Pembelajaran</h6>
                                    <button class="btn btn-outline-danger btn-sm rounded-pill py-0 px-2 extra-small" data-bs-toggle="modal" data-bs-target="#modalAddMaterial">
                                        + Upload Video
                                    </button>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <?php foreach ($section['videos'] as $vid): ?>
                                    <div class="card border shadow-none card-hover-light">
                                        <div class="card-body p-2 d-flex align-items-center gap-3">
                                            <div class="bg-light rounded p-2 text-danger">
                                                <i class="bi bi-play-circle-fill fs-5"></i>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <div class="small fw-semibold text-truncate"><?= $vid['title'] ?></div>
                                                <div class="d-flex gap-2 text-muted extra-small">
                                                    <span><i class="bi bi-file-earmark"></i> <?= $vid['file'] ?></span>
                                                    <span>•</span>
                                                    <span><?= $vid['size'] ?></span>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-icon text-muted" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                                    <li><a class="dropdown-item small" href="#">Preview</a></li>
                                                    <li><a class="dropdown-item small text-danger" href="#">Hapus</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Materials & Assignments Column -->
                        <div class="col-md-6">
                            <div class="p-4">
                                <!-- Materials -->
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold small text-dark mb-0"><i class="bi bi-file-earmark-text me-2 text-primary"></i>File & Dokumen</h6>
                                        <button class="btn btn-outline-primary btn-sm rounded-pill py-0 px-2 extra-small" data-bs-toggle="modal" data-bs-target="#modalAddMaterial">
                                            + Upload File
                                        </button>
                                    </div>
                                    <div class="d-flex flex-column gap-2">
                                        <?php foreach ($section['materials'] as $mat): ?>
                                        <div class="card border shadow-none card-hover-light">
                                            <div class="card-body p-2 d-flex align-items-center gap-3">
                                                <div class="bg-light rounded p-2 text-primary">
                                                    <i class="bi bi-file-earmark-pdf-fill fs-5"></i>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <div class="small fw-semibold text-truncate"><?= $mat['title'] ?></div>
                                                    <div class="text-muted extra-small"><?= $mat['size'] ?></div>
                                                </div>
                                                <button class="btn btn-sm btn-icon text-muted"><i class="bi bi-download"></i></button>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Assignments -->
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold small text-dark mb-0"><i class="bi bi-clipboard-check me-2 text-success"></i>Tugas & Kuis</h6>
                                        <button class="btn btn-outline-success btn-sm rounded-pill py-0 px-2 extra-small" data-bs-toggle="modal" data-bs-target="#modalAddMaterial">
                                            + Buat Tugas
                                        </button>
                                    </div>
                                    <div class="d-flex flex-column gap-2">
                                        <?php foreach ($section['assignments'] as $task): ?>
                                        <div class="card border shadow-none card-hover-light">
                                            <div class="card-body p-2 d-flex align-items-center gap-3">
                                                <div class="bg-light rounded p-2 text-success">
                                                    <i class="bi bi-trophy-fill fs-5"></i>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <div class="small fw-semibold text-truncate"><?= $task['title'] ?></div>
                                                    <div class="text-muted extra-small">
                                                        <?= isset($task['duration']) ? $task['duration'] : 'Deadline: '.$task['deadline'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

<!-- =========== MODALS =========== -->

<!-- Modal: Add Session (Redesigned) -->
<div class="modal fade" id="modalEditNote" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Catatan Pertemuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <div id="editor-container-edit-session" style="height: 200px;">
                    <p>Konten catatan pertemuan saat ini...</p>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add Session (Redesigned Premium) -->
<div class="modal fade" id="modalAddSession" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-body p-0">
                <div class="row g-0" style="min-height: 550px;">
                    <!-- Left Side: Visual/Info -->
                    <div class="col-lg-4 bg-primary text-white p-5 d-flex flex-column position-relative overflow-hidden">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.05) 100%);"></div>
                        
                        <!-- Content -->
                        <div class="position-relative z-2 h-100 d-flex flex-column">
                            <div class="mb-5">
                                <div class="bg-white bg-opacity-20 rounded-3 d-inline-flex align-items-center justify-content-center p-3 mb-4 backdrop-blur-sm">
                                    <i class="bi bi-calendar-plus fs-3 text-white"></i>
                                </div>
                                <h3 class="fw-bold mb-2">Buat Sesi Baru</h3>
                                <p class="opacity-75 mb-0 fs-6 fw-light">Rancang alur pembelajaran yang terstruktur dan menarik bagi siswa Anda.</p>
                            </div>

                            <div class="d-flex flex-column gap-4 mt-auto">
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="rounded-circle bg-white bg-opacity-25 p-1 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                        <i class="bi bi-check-lg small"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 fs-7">Struktur yang Jelas</h6>
                                        <p class="small opacity-50 mb-0">Judul dan ringkasan membantu siswa memahami tujuan sesi.</p>
                                    </div>
                                </div>
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="rounded-circle bg-white bg-opacity-25 p-1 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                        <i class="bi bi-check-lg small"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 fs-7">Materi & Interaksi</h6>
                                        <p class="small opacity-50 mb-0">Tambahkan video, dokumen, dan kuis setelah membuat sesi.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="position-absolute bottom-0 start-0 translate-middle-x translate-middle-y mb-n5 ms-n5 bg-white bg-opacity-10 rounded-circle" style="width: 300px; height: 300px; filter: blur(50px);"></div>
                        <div class="position-absolute top-0 end-0 translate-middle-x translate-middle-y mt-n5 me-n5 bg-info bg-opacity-20 rounded-circle" style="width: 200px; height: 200px; filter: blur(30px);"></div>
                    </div>
                    
                    <!-- Right Side: Form -->
                    <div class="col-lg-8 bg-white d-flex flex-column">
                        <div class="p-4 p-lg-5 h-100 overflow-y-auto">
                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">Detail Pertemuan</h5>
                                    <p class="text-muted small mb-0">Lengkapi informasi dasar untuk sesi ini.</p>
                                </div>
                                <button type="button" class="btn-close bg-light rounded-circle p-2" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                            <form>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase ls-1">Judul Pertemuan <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-lg border rounded-3 overflow-hidden shadow-sm focus-ring-group transition-all">
                                            <span class="input-group-text bg-white border-0 ps-3 text-muted"><i class="bi bi-type-h1"></i></span>
                                            <input type="text" class="form-control border-0 ps-2 fw-medium" placeholder="Contoh: Pertemuan 1: Pengenalan Dasar">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase ls-1">Ringkasan Materi</label>
                                        <div class="border rounded-3 overflow-hidden shadow-sm focus-ring-group transition-all">
                                            <textarea class="form-control border-0 p-3" rows="3" placeholder="Deskripsikan secara singkat apa yang akan dipelajari pada sesi ini..."></textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label small fw-bold text-muted text-uppercase ls-1 mb-0">Catatan Awal (Opsional)</label>
                                            <span class="badge bg-light text-muted border fw-normal extra-small">Rich Text</span>
                                        </div>
                                        <div class="border rounded-3 p-0 bg-white shadow-sm overflow-hidden">
                                             <div id="editor-container-session" style="height: 180px; border: none;"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="p-4 border-top bg-light bg-opacity-50">
                            <div class="d-flex justify-content-end gap-3">
                                <button type="button" class="btn btn-light rounded-pill px-4 fw-medium text-muted" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm hover-scale transition-all">
                                    <i class="bi bi-plus-lg me-2"></i>Buat Sesi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Edit Module Info -->
<div class="modal fade" id="modalEditInfo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Informasi Modul</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Judul Modul</label>
                                <input type="text" class="form-control" value="<?= $moduleInfo['title'] ?>">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold text-muted">Kode Modul</label>
                                    <input type="text" class="form-control" value="<?= $moduleInfo['code'] ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold text-muted">Level</label>
                                    <select class="form-select">
                                        <option selected>Basic</option>
                                        <option>Intermediate</option>
                                        <option>Advanced</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Kategori</label>
                                <input type="text" class="form-control" value="<?= $moduleInfo['category'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Deskripsi Singkat</label>
                                <textarea class="form-control" rows="4"><?= $moduleInfo['description'] ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Cover Image URL</label>
                            <div class="ratio ratio-16x9 bg-light rounded-3 mb-2 overflow-hidden border">
                                <img src="<?= $moduleInfo['cover_img'] ?>" class="object-fit-cover" id="preview-cover">
                            </div>
                            <input type="text" class="form-control form-control-sm mb-2" value="<?= $moduleInfo['cover_img'] ?>">
                            <button type="button" class="btn btn-outline-primary btn-sm w-100">Upload Gambar Baru</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add General Resource -->
<div class="modal fade" id="modalAddGeneral" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Materi Umum</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <ul class="nav nav-pills nav-fill mb-3 bg-light rounded-pill p-1" id="pills-tab-gen" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill small" data-bs-toggle="pill" data-bs-target="#tab-gen-video">Video Umum</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill small" data-bs-toggle="pill" data-bs-target="#tab-gen-file">File & Dokumen</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- Video Tab -->
                    <div class="tab-pane fade show active" id="tab-gen-video">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Judul Video</label>
                            <input type="text" class="form-control" placeholder="Contoh: Sambutan Instruktur">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Upload Video (MP4)</label>
                            <input type="file" class="form-control" accept="video/*">
                        </div>
                    </div>
                    <!-- File Tab -->
                    <div class="tab-pane fade" id="tab-gen-file">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Judul File</label>
                            <input type="text" class="form-control" placeholder="Contoh: Silabus PDF">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Upload File</label>
                            <input type="file" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4">Tambahkan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add Material/Video/Task (Existing) -->
<div class="modal fade" id="modalAddMaterial" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Konten Sesi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <ul class="nav nav-pills nav-fill mb-3 bg-light rounded-pill p-1" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill small" data-bs-toggle="pill" data-bs-target="#tab-video">Upload Video</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill small" data-bs-toggle="pill" data-bs-target="#tab-file">File</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill small" data-bs-toggle="pill" data-bs-target="#tab-quiz">Tugas</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- Video Tab (Upload) -->
                    <div class="tab-pane fade show active" id="tab-video">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Judul Video</label>
                            <input type="text" class="form-control" placeholder="Contoh: Tutorial Part 1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Upload Video (MP4/MKV)</label>
                            <div class="input-group">
                                <input type="file" class="form-control" accept="video/*">
                            </div>
                            <div class="form-text extra-small">Maksimal 500MB per file.</div>
                        </div>
                    </div>
                    <!-- File Tab -->
                    <div class="tab-pane fade" id="tab-file">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Judul Dokumen</label>
                            <input type="text" class="form-control" placeholder="Contoh: Handout PDF">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Upload File</label>
                            <input type="file" class="form-control">
                        </div>
                    </div>
                    <!-- Quiz Tab -->
                    <div class="tab-pane fade" id="tab-quiz">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Judul Tugas</label>
                            <input type="text" class="form-control" placeholder="Contoh: Kuis Harian 1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Jenis</label>
                            <select class="form-select">
                                <option>Kuis Pilihan Ganda</option>
                                <option>Tugas Upload File</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4">Tambahkan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Edit General Note -->
<div class="modal fade" id="modalEditGeneralNote" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Catatan Umum</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <div id="editor-container-general" style="height: 200px;">
                    <?= $moduleInfo['general']['note'] ?>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4">Simpan</button>
            </div>
        </div>
    </div>
</div>

<style>
.card-hover-light:hover {
    background-color: var(--bs-gray-100);
}
.accordion-button:not(.collapsed) {
    background-color: transparent;
    color: var(--bs-primary);
    box-shadow: none;
}
.accordion-button:focus {
    box-shadow: none;
}
.border-dashed {
    border-style: dashed !important;
}
.btn-icon {
    width: 28px;
    height: 28px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.hover-opacity-100:hover {
    opacity: 1 !important;
}
.transition-all {
    transition: all 0.3s ease;
}
/* Quill Overrides */
.ql-toolbar.ql-snow {
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
    border-color: #dee2e6;
}
.ql-container.ql-snow {
    border-bottom-left-radius: 0.5rem;
    border-bottom-right-radius: 0.5rem;
    border-color: #dee2e6;
}
/* Modal Utilities */
.backdrop-blur-sm {
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}
.fs-7 {
    font-size: 0.875rem;
}
.focus-ring-group:focus-within {
    border-color: var(--bs-primary) !important;
    box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
}
.hover-scale {
    transition: transform 0.2s;
}
.hover-scale:hover {
    transform: scale(1.02);
}
.transition-all {
    transition: all 0.3s ease;
}
</style>

<!-- Include Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill for Session Note
    var quillSession = new Quill('#editor-container-session', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'clean']
            ]
        },
        placeholder: 'Tulis materi atau catatan untuk siswa disini...'
    });

    // Initialize Quill for General Note
    var quillGeneral = new Quill('#editor-container-general', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'header': 1 }, { 'header': 2 }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                ['link', 'clean']
            ]
        }
    });

    // Initialize Quill for Edit Session Note
    var quillEditSession = new Quill('#editor-container-edit-session', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'clean']
            ]
        }
    });
});
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
