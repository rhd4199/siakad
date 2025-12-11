<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$user         = current_user();
$title        = 'Manajemen Template';
$currentPage  = 'template-raport';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

// Mock Data Templates
$templates = [
    [
        'id' => 1,
        'name' => 'Sertifikat Standar 2024',
        'type' => 'sertifikat',
        'last_updated' => '2024-12-10 14:30',
        'thumbnail' => 'https://via.placeholder.com/300x200?text=Sertifikat+A4'
    ],
    [
        'id' => 2,
        'name' => 'Raport Semester Ganjil',
        'type' => 'raport',
        'last_updated' => '2024-11-20 09:15',
        'thumbnail' => 'https://via.placeholder.com/200x300?text=Raport+Portrait'
    ],
    [
        'id' => 3,
        'name' => 'Sertifikat Workshop',
        'type' => 'sertifikat',
        'last_updated' => '2024-10-05 16:45',
        'thumbnail' => 'https://via.placeholder.com/300x200?text=Sertifikat+Workshop'
    ]
];

ob_start();
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1">Manajemen Template Dokumen</h4>
        <p class="text-muted small mb-0">Kelola desain sertifikat dan raport akademik.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="template_editor.php?id=new" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Buat Template Baru
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-transparent border-bottom px-4 py-3">
        <ul class="nav nav-pills card-header-pills" id="templateTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="all-tab" data-bs-toggle="pill" href="#all" role="tab">Semua</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="sertifikat-tab" data-bs-toggle="pill" href="#sertifikat" role="tab">Sertifikat</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="raport-tab" data-bs-toggle="pill" href="#raport" role="tab">Raport</a>
            </li>
        </ul>
    </div>
    <div class="card-body p-4 bg-light">
        <div class="tab-content">
            <!-- ALL TAB -->
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                <div class="row g-4">
                    <?php foreach($templates as $tpl): ?>
                        <?php renderTemplateCard($tpl); ?>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- SERTIFIKAT TAB -->
            <div class="tab-pane fade" id="sertifikat" role="tabpanel">
                <div class="row g-4">
                    <?php foreach($templates as $tpl): 
                        if($tpl['type'] !== 'sertifikat') continue;
                        renderTemplateCard($tpl);
                    endforeach; ?>
                </div>
            </div>

            <!-- RAPORT TAB -->
            <div class="tab-pane fade" id="raport" role="tabpanel">
                <div class="row g-4">
                    <?php foreach($templates as $tpl): 
                        if($tpl['type'] !== 'raport') continue;
                        renderTemplateCard($tpl);
                    endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function renderTemplateCard($tpl) {
    $badgeColor = $tpl['type'] === 'sertifikat' ? 'bg-warning text-dark' : 'bg-info text-white';
    $icon = $tpl['type'] === 'sertifikat' ? 'bi-award' : 'bi-file-earmark-text';
    ?>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
            <div class="position-relative">
                <!-- Thumbnail -->
                <div class="bg-secondary-subtle d-flex align-items-center justify-content-center overflow-hidden rounded-top" style="height: 180px;">
                    <i class="bi <?= $icon ?> display-1 text-secondary opacity-25"></i>
                </div>
                <span class="position-absolute top-0 end-0 m-2 badge <?= $badgeColor ?> shadow-sm">
                    <?= ucfirst($tpl['type']) ?>
                </span>
            </div>
            <div class="card-body">
                <h6 class="fw-bold mb-1 text-truncate"><?= $tpl['name'] ?></h6>
                <p class="text-muted extra-small mb-3">
                    <i class="bi bi-clock me-1"></i> Update: <?= $tpl['last_updated'] ?>
                </p>
                <div class="d-grid gap-2">
                    <a href="template_editor.php?id=<?= $tpl['id'] ?>&type=<?= $tpl['type'] ?>" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-pencil-square me-1"></i> Edit Desain
                    </a>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top-0 pt-0 pb-3">
                <div class="d-flex justify-content-between">
                    <button class="btn btn-link btn-sm text-secondary p-0 text-decoration-none small">
                        <i class="bi bi-files me-1"></i> Duplicate
                    </button>
                    <button class="btn btn-link btn-sm text-danger p-0 text-decoration-none small">
                        <i class="bi bi-trash me-1"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .extra-small {
        font-size: 0.75rem;
    }
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>