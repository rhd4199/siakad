<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$kodeModul    = $_GET['kode'] ?? 'MOD-OM-01';
$title        = 'Kelola Modul: ' . $kodeModul;
$currentPage  = 'modul-kelas';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

// Dummy Curriculum Data
$curriculum = [
    [
        'title' => 'Pengenalan Komputer & Windows',
        'items' => [
            ['type' => 'video', 'title' => 'Video: Sejarah Komputer', 'duration' => '10 min'],
            ['type' => 'text', 'title' => 'Bacaan: Komponen Hardware', 'duration' => '15 min'],
            ['type' => 'quiz', 'title' => 'Quiz: Hardware Dasar', 'duration' => '10 min'],
        ]
    ],
    [
        'title' => 'Microsoft Word Dasar',
        'items' => [
            ['type' => 'video', 'title' => 'Video: Interface Ms Word', 'duration' => '12 min'],
            ['type' => 'text', 'title' => 'Latihan: Mengetik Surat', 'duration' => '30 min'],
        ]
    ]
];

ob_start();
?>

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= $baseUrl . $roleBasePath ?>/modul-kelas.php" class="btn btn-light rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold mb-0">Operator Komputer Dasar</h4>
            <div class="text-muted small">MOD-OM-01 • Office Program</div>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-eye me-2"></i>Preview
        </button>
        <button class="btn btn-primary rounded-pill px-3">
            <i class="bi bi-save me-2"></i>Simpan Perubahan
        </button>
    </div>
</div>

<div class="row g-4">
    <!-- LEFT: CURRICULUM BUILDER -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Struktur Kurikulum</h6>
                <button class="btn btn-sm btn-outline-primary rounded-pill">
                    <i class="bi bi-plus-lg me-1"></i> Sesi Baru
                </button>
            </div>
            <div class="card-body p-0">
                <div class="accordion accordion-flush" id="curriculumAccordion">
                    <?php foreach ($curriculum as $index => $section): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?= $index === 0 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#section-<?= $index ?>">
                                <div class="d-flex align-items-center w-100 me-3">
                                    <span class="fw-semibold text-dark me-auto"><?= $section['title'] ?></span>
                                    <span class="badge bg-light text-muted fw-normal rounded-pill px-2 me-2">
                                        <?= count($section['items']) ?> item
                                    </span>
                                </div>
                            </button>
                        </h2>
                        <div id="section-<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" data-bs-parent="#curriculumAccordion">
                            <div class="accordion-body bg-light-subtle p-0">
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($section['items'] as $item): ?>
                                    <li class="list-group-item bg-transparent d-flex align-items-center gap-3 py-3 border-bottom-0">
                                        <div class="handle text-muted cursor-move">
                                            <i class="bi bi-grip-vertical"></i>
                                        </div>
                                        <div class="icon-box rounded-circle bg-white shadow-sm text-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <?php if($item['type'] === 'video'): ?>
                                                <i class="bi bi-play-fill"></i>
                                            <?php elseif($item['type'] === 'quiz'): ?>
                                                <i class="bi bi-patch-question-fill text-warning"></i>
                                            <?php else: ?>
                                                <i class="bi bi-file-text-fill text-info"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-medium text-dark small"><?= $item['title'] ?></div>
                                            <div class="extra-small text-muted"><?= $item['duration'] ?></div>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                                <li><a class="dropdown-item small" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item small text-danger" href="#"><i class="bi bi-trash me-2"></i>Hapus</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>
                                    <li class="list-group-item bg-transparent text-center py-3 border-top border-bottom-0">
                                        <button class="btn btn-sm btn-outline-secondary rounded-pill border-dashed">
                                            <i class="bi bi-plus-lg me-1"></i> Tambah Materi
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT: SETTINGS -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Pengaturan Modul</h6>
                <div class="mb-3">
                    <label class="form-label small text-muted">Cover Modul</label>
                    <div class="ratio ratio-16x9 bg-light rounded-3 mb-2 overflow-hidden position-relative group-hover">
                        <img src="https://source.unsplash.com/random/800x600?computer" alt="Cover" class="object-fit-cover opacity-75">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <button class="btn btn-light btn-sm rounded-pill shadow-sm">
                                <i class="bi bi-camera me-1"></i> Ubah
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Judul Modul</label>
                    <input type="text" class="form-control form-control-sm" value="Operator Komputer Dasar">
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Kategori</label>
                    <select class="form-select form-select-sm">
                        <option selected>Office & Administrasi</option>
                        <option>Digital Marketing</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Level</label>
                    <div class="d-flex gap-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="level" id="lvl1" checked>
                            <label class="form-check-label small" for="lvl1">Basic</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="level" id="lvl2">
                            <label class="form-check-label small" for="lvl2">Intermediate</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle bg-white/20 p-2">
                        <i class="bi bi-lightbulb fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Tips Tutor</h6>
                        <div class="small opacity-75">Maksimalkan retensi siswa</div>
                    </div>
                </div>
                <p class="small opacity-90 mb-0">
                    Gunakan kombinasi video pendek (5-10 menit) dan kuis interaktif di setiap akhir sesi untuk meningkatkan pemahaman.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
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
.cursor-move {
    cursor: move;
}
</style>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>