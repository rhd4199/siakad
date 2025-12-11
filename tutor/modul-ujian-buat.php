<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user = current_user();
$examId = $_GET['id'] ?? 'EX-NEW';
$isNew = $examId === 'EX-NEW';

// Dummy Data: Available Question Packages (from modul-soal.php)
$availablePackages = [
    [
        'id' => 'PK-OM-01',
        'title' => 'Ujian Akhir – Operator Komputer',
        'subject' => 'Operator Komputer',
        'q_count' => 25,
        'duration' => 60,
        'type' => 'mix'
    ],
    [
        'id' => 'PK-DM-01',
        'title' => 'Quiz Funnel & Konten',
        'subject' => 'Digital Marketing',
        'q_count' => 15,
        'duration' => 45,
        'type' => 'pg'
    ],
    [
        'id' => 'PK-BRS-01',
        'title' => 'Evaluasi Praktik Barista',
        'subject' => 'Barista & F&B',
        'q_count' => 8,
        'duration' => 30,
        'type' => 'essay'
    ]
];

// Dummy Data: Current Exam Template (if editing)
$examData = [
    'title' => $isNew ? '' : 'Ujian Akhir Semester Genap',
    'description' => $isNew ? '' : 'Ujian wajib untuk seluruh siswa operator komputer.',
    'kkm' => 70,
    'max_attempt' => 1,
    'random_question' => true,
    'random_answer' => true,
    'show_result' => false,
    'segments' => []
];

// If not new, populate segments (Modules + Breaks)
if (!$isNew) {
    $examData['segments'] = [
        ['type' => 'module', 'package_id' => 'PK-OM-01', 'duration' => 60],
        ['type' => 'break', 'duration' => 15, 'message' => 'Istirahat sejenak sebelum lanjut ke sesi berikutnya.'],
        ['type' => 'module', 'package_id' => 'PK-DM-01', 'duration' => 45]
    ];
}

ob_start();
?>

<div class="d-flex flex-column h-100">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-3">
            <a href="modul-ujian.php" class="btn btn-light rounded-circle shadow-sm p-0" style="width: 40px; height: 40px; display: grid; place-items: center;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="fw-bold mb-0"><?= $isNew ? 'Buat Template Ujian Baru' : 'Edit Template Ujian' ?></h5>
                <div class="text-muted small">
                    Susun modul soal dan sesi istirahat.
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold small">
                <i class="bi bi-clock me-2"></i>Total Durasi: <span id="total-exam-duration">0</span> Menit
            </div>
            <button class="btn btn-primary rounded-pill px-4 shadow-sm" onclick="saveExam()">
                <i class="bi bi-save me-2"></i>Simpan Template
            </button>
        </div>
    </div>

    <div class="row g-4 h-100">
        <!-- Left: Settings -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom p-4">
                    <h6 class="fw-bold mb-0"><i class="bi bi-sliders me-2 text-primary"></i>Pengaturan Dasar</h6>
                </div>
                <div class="card-body p-4 overflow-y-auto">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Judul Ujian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-light border-0" id="exam-title" value="<?= htmlspecialchars($examData['title']) ?>" placeholder="Contoh: Ujian Akhir Semester">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Deskripsi</label>
                        <textarea class="form-control bg-light border-0" id="exam-desc" rows="3" placeholder="Instruksi singkat..."><?= htmlspecialchars($examData['description']) ?></textarea>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">KKM</label>
                            <input type="number" class="form-control bg-light border-0" id="exam-kkm" value="<?= $examData['kkm'] ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Kesempatan</label>
                            <input type="number" class="form-control bg-light border-0" id="exam-attempt" value="<?= $examData['max_attempt'] ?>">
                        </div>
                    </div>

                    <h6 class="fw-bold small text-muted text-uppercase mb-3">Opsi Tambahan</h6>
                    
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="opt-random-q" <?= $examData['random_question'] ? 'checked' : '' ?>>
                        <label class="form-check-label small" for="opt-random-q">Acak Urutan Soal</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="opt-random-a" <?= $examData['random_answer'] ? 'checked' : '' ?>>
                        <label class="form-check-label small" for="opt-random-a">Acak Urutan Jawaban</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="opt-show-result" <?= $examData['show_result'] ? 'checked' : '' ?>>
                        <label class="form-check-label small" for="opt-show-result">Tampilkan Nilai Setelah Selesai</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Timeline Builder -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100 d-flex flex-column bg-light">
                <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-1"><i class="bi bi-collection-play me-2 text-primary"></i>Alur Ujian (Timeline)</h6>
                        <p class="text-muted small mb-0">Susun urutan paket soal dan istirahat.</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-dark rounded-pill px-3 btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Sesi
                        </button>
                        <ul class="dropdown-menu shadow border-0">
                            <li><a class="dropdown-item small py-2" href="#" onclick="addModule()"><i class="bi bi-stack me-2 text-primary"></i>Modul Soal</a></li>
                            <li><a class="dropdown-item small py-2" href="#" onclick="addBreak()"><i class="bi bi-cup-hot me-2 text-warning"></i>Istirahat</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="card-body p-4 overflow-y-auto custom-scrollbar position-relative" id="timeline-container">
                    <!-- Empty State -->
                    <div id="empty-state" class="text-center py-5 d-none">
                        <div class="mb-3 text-muted opacity-25">
                            <i class="bi bi-layers fs-1"></i>
                        </div>
                        <h6 class="fw-bold text-muted">Belum ada sesi</h6>
                        <p class="small text-muted mb-0">Tambahkan modul soal atau istirahat untuk memulai.</p>
                    </div>

                    <!-- Timeline Items injected via JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template: Module Item -->
<template id="tmpl-module">
    <div class="timeline-item card mb-3 border-0 shadow-sm border-start border-4 border-primary position-relative">
        <div class="card-body p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 36px; height: 36px;">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-bold mb-0 text-dark">Sesi Ujian (Modul)</h6>
                        <button class="btn btn-icon btn-sm text-danger opacity-50 hover-opacity-100" onclick="removeSegment(this)"><i class="bi bi-trash"></i></button>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-8">
                            <select class="form-select form-select-sm bg-light border-0 fw-medium package-select">
                                <option value="" disabled selected>Pilih Paket Soal...</option>
                                <?php foreach ($availablePackages as $pkg): ?>
                                <option value="<?= $pkg['id'] ?>" data-duration="<?= $pkg['duration'] ?>" data-qcount="<?= $pkg['q_count'] ?>">
                                    <?= $pkg['title'] ?> (<?= $pkg['q_count'] ?> Soal - <?= $pkg['duration'] ?> Menit)
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-clock"></i></span>
                                <input type="number" class="form-control bg-light border-0 text-center fw-bold module-duration" value="0">
                                <span class="input-group-text bg-light border-0 text-muted">mnt</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Connector Line -->
        <div class="position-absolute start-50 top-100 translate-middle-x h-100 border-start border-dashed border-secondary opacity-25" style="z-index: -1; height: 20px;"></div>
    </div>
</template>

<!-- Template: Break Item -->
<template id="tmpl-break">
    <div class="timeline-item card mb-3 border-0 shadow-sm border-start border-4 border-warning position-relative bg-warning-subtle bg-opacity-10">
        <div class="card-body p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 36px; height: 36px;">
                    <i class="bi bi-cup-hot"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-bold mb-0 text-dark">Istirahat</h6>
                        <button class="btn btn-icon btn-sm text-danger opacity-50 hover-opacity-100" onclick="removeSegment(this)"><i class="bi bi-trash"></i></button>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-8">
                            <input type="text" class="form-control form-control-sm bg-white border-0" placeholder="Pesan untuk siswa (Opsional)...">
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-0 text-muted"><i class="bi bi-hourglass-split"></i></span>
                                <input type="number" class="form-control bg-white border-0 text-center fw-bold break-duration" value="5">
                                <span class="input-group-text bg-white border-0 text-muted">mnt</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
.hover-opacity-100:hover { opacity: 1 !important; }
</style>

<script>
// Init Data
const initialSegments = <?= json_encode($examData['segments']) ?>;

document.addEventListener('DOMContentLoaded', function() {
    initEvents();
    
    if (initialSegments.length > 0) {
        initialSegments.forEach(seg => {
            if(seg.type === 'module') addModule(seg);
            else addBreak(seg);
        });
    } else {
        // Add one empty module by default for convenience
        addModule();
    }
    calculateTotalDuration();
});

function initEvents() {
    const container = document.getElementById('timeline-container');
    
    // Event Delegation for Package Selection
    container.addEventListener('change', function(e) {
        if (e.target && e.target.classList.contains('package-select')) {
            updateModuleInfo(e.target);
        }
    });

    // Event Delegation for Duration Changes (Module & Break)
    container.addEventListener('input', function(e) {
        if (e.target && (e.target.classList.contains('module-duration') || e.target.classList.contains('break-duration'))) {
            calculateTotalDuration();
        }
    });
}

function addModule(data = null) {
    const tmpl = document.getElementById('tmpl-module');
    const clone = tmpl.content.cloneNode(true);
    const container = document.getElementById('timeline-container');
    
    if(data) {
        const select = clone.querySelector('select');
        select.value = data.package_id;
        
        // Set duration manually if provided (legacy or custom value)
        // If data has duration, use it. Otherwise rely on user selecting a package later (though value is set)
        if (data.duration) {
            clone.querySelector('.module-duration').value = data.duration;
        } else {
            // Fallback: if data has no duration, try to pull from select (if matched)
            const option = select.options[select.selectedIndex];
            if (option) {
                const defDur = option.getAttribute('data-duration');
                if (defDur) clone.querySelector('.module-duration').value = defDur;
            }
        }
    }
    
    container.appendChild(clone);
    checkEmptyState();
}

function addBreak(data = null) {
    const tmpl = document.getElementById('tmpl-break');
    const clone = tmpl.content.cloneNode(true);
    const container = document.getElementById('timeline-container');
    
    if(data) {
        clone.querySelector('.break-duration').value = data.duration;
        clone.querySelector('input[type="text"]').value = data.message || '';
    }
    
    container.appendChild(clone);
    calculateTotalDuration();
    checkEmptyState();
}

function removeSegment(btn) {
    if(!confirm('Hapus sesi ini?')) return;
    btn.closest('.timeline-item').remove();
    calculateTotalDuration();
    checkEmptyState();
}

function updateModuleInfo(select) {
    const option = select.options[select.selectedIndex];
    if (!option) return;
    
    const duration = option.getAttribute('data-duration');
    const row = select.closest('.timeline-item');
    
    if (row && duration) {
        row.querySelector('.module-duration').value = duration;
        calculateTotalDuration();
    }
}

function calculateTotalDuration() {
    let total = 0;
    
    // Modules
    document.querySelectorAll('.module-duration').forEach(el => {
        total += parseInt(el.value) || 0;
    });
    
    // Breaks
    document.querySelectorAll('.break-duration').forEach(el => {
        total += parseInt(el.value) || 0;
    });
    
    document.getElementById('total-exam-duration').innerText = total;
}

function checkEmptyState() {
    const container = document.getElementById('timeline-container');
    const emptyState = document.getElementById('empty-state');
    const hasItems = container.querySelectorAll('.timeline-item').length > 0;
    
    if (hasItems) {
        emptyState.classList.add('d-none');
    } else {
        emptyState.classList.remove('d-none');
    }
}

function saveExam() {
    const title = document.getElementById('exam-title').value;
    if(!title) {
        alert('Mohon isi Judul Ujian!');
        return;
    }
    
    // Gather segments
    const segments = [];
    document.querySelectorAll('.timeline-item').forEach(el => {
        if(el.querySelector('.package-select')) {
            // Module
            const pkgId = el.querySelector('.package-select').value;
            if(pkgId) {
                segments.push({ 
                    type: 'module', 
                    package_id: pkgId,
                    duration: parseInt(el.querySelector('.module-duration').value) || 0
                });
            }
        } else {
            // Break
            const dur = el.querySelector('.break-duration').value;
            segments.push({ 
                type: 'break', 
                duration: parseInt(dur) || 0,
                message: el.querySelector('input[type="text"]').value
            });
        }
    });
    
    if(segments.length === 0) {
        alert('Tambahkan minimal satu sesi ujian!');
        return;
    }
    
    // Here you would typically submit the form or make an AJAX call
    // For now, just alert and redirect
    console.log('Exam Data:', segments);
    alert('Template Ujian berhasil disimpan!');
    window.location.href = 'modul-ujian.php';
}
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
