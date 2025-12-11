<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user = current_user();
$paketId = $_GET['id'] ?? 'PK-NEW';
$isNew = $paketId === 'PK-NEW';

// Dummy Data for Package
$paket = [
    'title' => $isNew ? 'Paket Soal Baru' : 'Ujian Akhir – Operator Komputer',
    'subject' => 'Operator Komputer',
    'duration' => 60,
    'total_score' => 100,
    'questions' => []
];

// Dummy Questions if not new
if (!$isNew) {
    $paket['questions'] = [
        [
            'id' => 1,
            'type' => 'pg',
            'text' => '<p>Apa fungsi utama dari CPU pada komputer?</p>',
            'score' => 10,
            'options' => [
                ['text' => 'Menyimpan data permanen', 'correct' => false],
                ['text' => 'Memproses instruksi dan data', 'correct' => true],
                ['text' => 'Menampilkan gambar ke layar', 'correct' => false],
                ['text' => 'Mencetak dokumen', 'correct' => false]
            ]
        ],
        [
            'id' => 2,
            'type' => 'checkbox',
            'text' => '<p>Pilih perangkat yang termasuk Input Device (Boleh lebih dari satu):</p>',
            'score' => 15,
            'options' => [
                ['text' => 'Keyboard', 'correct' => true],
                ['text' => 'Monitor', 'correct' => false],
                ['text' => 'Mouse', 'correct' => true],
                ['text' => 'Printer', 'correct' => false]
            ]
        ],
        [
            'id' => 3,
            'type' => 'essay_short',
            'text' => '<p>Sebutkan kepanjangan dari RAM!</p>',
            'score' => 10,
            'answer_key' => 'Random Access Memory'
        ],
        [
            'id' => 4,
            'type' => 'scale',
            'text' => '<p>Seberapa mudah Anda memahami materi Microsoft Excel sejauh ini?</p>',
            'score' => 0, // Survey type usually 0 score
            'scale_min' => 1,
            'scale_max' => 5,
            'labels' => ['Sangat Sulit', 'Sangat Mudah']
        ]
    ];
}

ob_start();
?>
<!-- Quill Theme -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div class="d-flex flex-column h-100">
    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-3">
            <a href="modul-soal.php" class="btn btn-light rounded-circle shadow-sm p-0" style="width: 40px; height: 40px; display: grid; place-items: center;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="fw-bold mb-0"><?= $paket['title'] ?></h5>
                <div class="text-muted small">
                    <span class="badge bg-light text-dark border me-2"><?= $paket['subject'] ?></span>
                    <i class="bi bi-clock me-1"></i> <?= $paket['duration'] ?> Menit • 
                    <i class="bi bi-award me-1"></i> Total Bobot: <span id="total-score"><?= $paket['total_score'] ?></span>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalPreview" onclick="renderPreview()">
                <i class="bi bi-eye me-2"></i>Preview
            </button>
            <button class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-save me-2"></i>Simpan Paket
            </button>
        </div>
    </div>

    <div class="row g-4 h-100">
        <!-- LEFT: QUESTION LIST -->
        <div class="col-lg-4 d-flex flex-column" style="height: calc(100vh - 200px);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Daftar Soal (<span id="q-count"><?= count($paket['questions']) ?></span>)</h6>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light rounded-pill px-3 text-primary fw-medium" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </button>
                    <ul class="dropdown-menu shadow-sm border-0">
                        <li><h6 class="dropdown-header small text-uppercase">Tipe Soal</h6></li>
                        <li><a class="dropdown-item small" href="#" onclick="addQuestion('pg')"><i class="bi bi-ui-checks me-2 text-primary"></i>Pilihan Ganda</a></li>
                        <li><a class="dropdown-item small" href="#" onclick="addQuestion('checkbox')"><i class="bi bi-check-all me-2 text-success"></i>Pilihan Ganda (Multi)</a></li>
                        <li><a class="dropdown-item small" href="#" onclick="addQuestion('essay_short')"><i class="bi bi-input-cursor-text me-2 text-warning"></i>Isian Singkat</a></li>
                        <li><a class="dropdown-item small" href="#" onclick="addQuestion('essay')"><i class="bi bi-justify-left me-2 text-info"></i>Esai / Uraian</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item small" href="#" onclick="addQuestion('scale')"><i class="bi bi-sliders me-2 text-secondary"></i>Skala (Likert)</a></li>
                        <li><a class="dropdown-item small" href="#" onclick="addQuestion('percentage')"><i class="bi bi-percent me-2 text-danger"></i>Persentase</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item small" href="#" data-bs-toggle="modal" data-bs-target="#modalImportQuestion"><i class="bi bi-cloud-arrow-down me-2 text-primary"></i>Import dari Bank Soal</a></li>
                    </ul>
                </div>
            </div>

            <!-- List Container -->
            <div class="flex-grow-1 overflow-y-auto pe-2 custom-scrollbar" id="question-list">
                <!-- Questions will be rendered here via JS -->
                <?php foreach ($paket['questions'] as $idx => $q): ?>
                <div class="card mb-2 border-0 shadow-sm question-item cursor-pointer hover-bg-light transition-all <?= $idx === 0 ? 'active-question border-start border-4 border-primary' : '' ?>" 
                     onclick="selectQuestion(<?= $q['id'] ?>)" id="q-item-<?= $q['id'] ?>">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge bg-light text-muted border text-uppercase extra-small type-badge"><?= $q['type'] ?></span>
                            <span class="fw-bold small text-primary score-badge">Bobot: <?= $q['score'] ?></span>
                        </div>
                        <div class="text-truncate-2 small text-dark mb-2 question-preview">
                            <?= strip_tags($q['text']) ?>
                        </div>
                        <div class="d-flex justify-content-end gap-2 opacity-50 hover-opacity-100">
                            <button class="btn btn-xs btn-icon text-muted" title="Duplikasi" onclick="duplicateQuestion(<?= $q['id'] ?>); event.stopPropagation();"><i class="bi bi-copy"></i></button>
                            <button class="btn btn-xs btn-icon text-danger" title="Hapus" onclick="deleteQuestion(<?= $q['id'] ?>); event.stopPropagation();"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- RIGHT: EDITOR -->
        <div class="col-lg-8" style="height: calc(100vh - 200px);">
            <div class="card border-0 shadow-lg h-100 rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px;" id="editor-number">1</div>
                            <select class="form-select form-select-sm border-0 bg-light fw-bold" style="width: auto;" id="editor-type">
                                <option value="pg">Pilihan Ganda</option>
                                <option value="checkbox">Pilihan Ganda (Multi)</option>
                                <option value="essay_short">Isian Singkat</option>
                                <option value="essay">Esai / Uraian</option>
                                <option value="scale">Skala</option>
                                <option value="percentage">Persentase</option>
                            </select>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="input-group input-group-sm" style="width: 140px;">
                                <span class="input-group-text bg-light border-0">Bobot</span>
                                <input type="number" class="form-control border-light bg-light fw-bold text-center" value="10" id="editor-score">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0 d-flex flex-column overflow-hidden">
                    <!-- Question Text Editor -->
                    <div class="p-4 border-bottom flex-shrink-0">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-2">Pertanyaan</label>
                        <div id="editor-container" style="height: 150px;" class="bg-white"></div>
                    </div>

                    <!-- Answer Area (Scrollable) -->
                    <div class="flex-grow-1 overflow-y-auto p-4 bg-light bg-opacity-25" id="answer-area">
                        <!-- Dynamic Content Based on Type -->
                        
                        <!-- Template: PG -->
                        <div id="tmpl-pg" class="answer-template">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase mb-0">Pilihan Jawaban</label>
                                <button class="btn btn-sm btn-outline-primary rounded-pill py-0 extra-small" onclick="addOption('pg')">+ Tambah Opsi</button>
                            </div>
                            <div class="d-flex flex-column gap-2" id="options-container-pg">
                                <!-- Options injected here -->
                            </div>
                        </div>

                        <!-- Template: Essay Short -->
                        <div id="tmpl-essay_short" class="answer-template d-none">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-2">Kunci Jawaban (Opsional)</label>
                            <input type="text" class="form-control" placeholder="Masukkan jawaban yang benar...">
                            <div class="form-text small">Biarkan kosong jika koreksi dilakukan manual.</div>
                        </div>

                         <!-- Template: Essay Long -->
                         <div id="tmpl-essay" class="answer-template d-none">
                            <div class="alert alert-info border-0 bg-info-subtle text-info small">
                                <i class="bi bi-info-circle me-2"></i> Jawaban untuk tipe soal ini memerlukan koreksi manual oleh instruktur.
                            </div>
                            <label class="form-label small fw-bold text-muted text-uppercase mb-2">Referensi Jawaban (Untuk Instruktur)</label>
                            <textarea class="form-control" rows="4" placeholder="Poin-poin penting yang harus ada dalam jawaban siswa..."></textarea>
                        </div>

                        <!-- Template: Scale -->
                        <div id="tmpl-scale" class="answer-template d-none">
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label small fw-bold text-muted">Skala Min</label>
                                    <input type="number" class="form-control" value="1">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-bold text-muted">Skala Max</label>
                                    <input type="number" class="form-control" value="5">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-bold text-muted">Label Min (Kiri)</label>
                                    <input type="text" class="form-control" placeholder="Contoh: Tidak Setuju">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-bold text-muted">Label Max (Kanan)</label>
                                    <input type="text" class="form-control" placeholder="Contoh: Sangat Setuju">
                                </div>
                            </div>
                        </div>

                        <!-- Template: Percentage -->
                        <div id="tmpl-percentage" class="answer-template d-none">
                             <label class="form-label small fw-bold text-muted text-uppercase mb-2">Kunci Jawaban (Angka)</label>
                             <div class="input-group w-50">
                                <input type="number" class="form-control" placeholder="0-100">
                                <span class="input-group-text">%</span>
                             </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Preview -->
<div class="modal fade" id="modalPreview" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light border-bottom-0 pb-2">
                <div>
                    <h5 class="modal-title fw-bold">Preview Soal</h5>
                    <p class="text-muted small mb-0">Tampilan simulasi pengerjaan siswa</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light p-4">
                <div class="bg-white rounded-4 shadow-sm p-4 border" style="min-height: 400px;">
                    <!-- Header Exam -->
                    <div class="border-bottom pb-3 mb-4 text-center">
                        <h4 class="fw-bold mb-1"><?= $paket['title'] ?></h4>
                        <div class="text-muted small">
                            <?= $paket['subject'] ?> • <i class="bi bi-clock"></i> <?= $paket['duration'] ?> Menit
                        </div>
                    </div>

                    <!-- Questions Container -->
                    <div id="preview-container" class="d-flex flex-column gap-4">
                        <!-- Content rendered via JS -->
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 px-4 bg-light">
                <button type="button" class="btn btn-primary rounded-pill px-4 w-100" data-bs-dismiss="modal">Tutup Preview</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Import Question -->
<div class="modal fade" id="modalImportQuestion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-white border-bottom pb-3">
                <div>
                    <h5 class="modal-title fw-bold">Import Soal dari Bank Soal</h5>
                    <p class="text-muted small mb-0">Pilih paket soal lain untuk menyalin soal yang sudah ada.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light p-0">
                <div class="row g-0" style="height: 550px;">
                    <!-- Left: Package List -->
                    <div class="col-lg-4 border-end d-flex flex-column bg-white">
                        <div class="p-3 border-bottom">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control border-0 bg-light" placeholder="Cari paket soal...">
                            </div>
                        </div>
                        <div class="flex-grow-1 overflow-y-auto">
                            <div class="list-group list-group-flush" id="import-package-list">
                                <!-- Dummy Packages -->
                                <button class="list-group-item list-group-item-action py-3 active border-0" onclick="loadImportQuestions(1)">
                                    <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                        <h6 class="mb-0 fw-bold">Kuis Digital Marketing</h6>
                                        <small class="text-white-50">15 Soal</small>
                                    </div>
                                    <small class="opacity-75">Quiz Funnel & Konten</small>
                                </button>
                                <button class="list-group-item list-group-item-action py-3 border-0" onclick="loadImportQuestions(2)">
                                    <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                        <h6 class="mb-0 fw-bold">Evaluasi Barista</h6>
                                        <small class="text-muted">8 Soal</small>
                                    </div>
                                    <small class="text-muted">Barista & F&B</small>
                                </button>
                                <button class="list-group-item list-group-item-action py-3 border-0" onclick="loadImportQuestions(3)">
                                    <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                        <h6 class="mb-0 fw-bold">Ujian Excel Basic</h6>
                                        <small class="text-muted">20 Soal</small>
                                    </div>
                                    <small class="text-muted">Operator Komputer</small>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Questions List -->
                    <div class="col-lg-8 d-flex flex-column bg-light">
                        <div class="p-3 border-bottom bg-white d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check-all-import">
                                <label class="form-check-label small fw-bold" for="check-all-import">Pilih Semua</label>
                            </div>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle" id="import-selected-count">0 terpilih</span>
                        </div>
                        <div class="flex-grow-1 overflow-y-auto p-4" id="import-questions-container">
                            <!-- Questions loaded via JS -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-3 pb-4 px-4 bg-white">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" onclick="executeImport()">
                    <i class="bi bi-cloud-download me-2"></i>Import Soal Terpilih
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.active-question {
    background-color: var(--bs-primary-bg-subtle);
    border-left: 4px solid var(--bs-primary) !important;
}
.text-truncate-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.hover-bg-light:hover {
    background-color: var(--bs-gray-100);
}
.cursor-pointer {
    cursor: pointer;
}
.btn-xs {
    padding: 0.1rem 0.4rem;
    font-size: 0.75rem;
}
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}
.hover-opacity-100:hover {
    opacity: 1 !important;
}
/* Quill Overrides */
.ql-toolbar.ql-snow { border-color: #dee2e6; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; }
.ql-container.ql-snow { border-color: #dee2e6; border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; }
</style>

<!-- JS Scripts -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
// Mock Data (Sync with PHP)
let questions = <?= json_encode($paket['questions']) ?>;
let currentQId = questions.length > 0 ? questions[0].id : null;
let quill;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill
    quill = new Quill('#editor-container', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['image', 'code-block']
            ]
        },
        placeholder: 'Tulis pertanyaan Anda disini...'
    });

    // Initial Load
    if (questions.length > 0) {
        loadQuestion(questions[0].id);
    } else {
        // Empty state?
    }
    
    // Type Change Listener
    document.getElementById('editor-type').addEventListener('change', function(e) {
        updateAnswerArea(e.target.value);
    });
});

function selectQuestion(id) {
    currentQId = id;
    
    // Update UI Active State
    document.querySelectorAll('.question-item').forEach(el => {
        el.classList.remove('active-question', 'border-start', 'border-4', 'border-primary');
    });
    const activeItem = document.getElementById('q-item-' + id);
    if(activeItem) activeItem.classList.add('active-question', 'border-start', 'border-4', 'border-primary');

    loadQuestion(id);
}

function loadQuestion(id) {
    const q = questions.find(item => item.id === id);
    if (!q) return;

    // Set Header Info
    document.getElementById('editor-number').innerText = questions.findIndex(item => item.id === id) + 1;
    document.getElementById('editor-type').value = q.type;
    document.getElementById('editor-score').value = q.score;

    // Set Content
    quill.root.innerHTML = q.text;

    // Show Correct Template
    updateAnswerArea(q.type);

    // Populate Options if PG
    if (q.type === 'pg' || q.type === 'checkbox') {
        renderOptions(q.type, q.options);
    }
    // Populate Scale
    if (q.type === 'scale') {
        const tmpl = document.getElementById('tmpl-scale');
        tmpl.querySelector('input[value="1"]').value = q.scale_min || 1;
        tmpl.querySelector('input[value="5"]').value = q.scale_max || 5;
        // Assuming labels are stored, but for now just placeholder logic
    }
    // Populate Essay Short Answer Key
    if (q.type === 'essay_short' && q.answer_key) {
         document.querySelector('#tmpl-essay_short input').value = q.answer_key;
    }
}

function updateAnswerArea(type) {
    // Hide all templates
    document.querySelectorAll('.answer-template').forEach(el => el.classList.add('d-none'));
    
    // Show selected template
    const tmplId = (type === 'pg' || type === 'checkbox') ? 'tmpl-pg' : 'tmpl-' + type;
    const tmpl = document.getElementById(tmplId);
    if(tmpl) tmpl.classList.remove('d-none');
}

function renderOptions(type, options) {
    const container = document.getElementById('options-container-pg');
    container.innerHTML = '';
    
    if(!options) options = [{text: '', correct: false}, {text: '', correct: false}];

    options.forEach((opt, idx) => {
        const div = document.createElement('div');
        div.className = 'input-group input-group-sm align-items-center bg-white p-2 rounded border';
        
        const inputType = type === 'checkbox' ? 'checkbox' : 'radio';
        const name = 'opt_correct';
        
        div.innerHTML = `
            <div class="input-group-text bg-transparent border-0">
                <input class="form-check-input mt-0" type="${inputType}" name="${name}" ${opt.correct ? 'checked' : ''}>
            </div>
            <input type="text" class="form-control border-0 bg-transparent" value="${opt.text}" placeholder="Pilihan jawaban...">
            <button class="btn btn-icon text-muted" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>
        `;
        container.appendChild(div);
    });
}

function addOption(type) {
    const container = document.getElementById('options-container-pg');
    const div = document.createElement('div');
    div.className = 'input-group input-group-sm align-items-center bg-white p-2 rounded border';
    
    // Determine input type based on current selection
    const currentType = document.getElementById('editor-type').value;
    const inputType = currentType === 'checkbox' ? 'checkbox' : 'radio';
    
    div.innerHTML = `
        <div class="input-group-text bg-transparent border-0">
            <input class="form-check-input mt-0" type="${inputType}" name="opt_correct">
        </div>
        <input type="text" class="form-control border-0 bg-transparent" placeholder="Pilihan jawaban baru...">
        <button class="btn btn-icon text-muted" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>
    `;
    container.appendChild(div);
}

function addQuestion(type) {
    const newId = Date.now();
    const newQ = {
        id: newId,
        type: type,
        text: '<p>Pertanyaan baru...</p>',
        score: 10,
        options: []
    };
    questions.push(newQ);
    
    // Refresh List (Simplified)
    // In real app, append to DOM
    location.reload(); // Quick hack for prototype to refresh PHP render, ideally do DOM manipulation
}

function duplicateQuestion(id) {
    const q = questions.find(item => item.id === id);
    if (!q) return;
    
    const newQ = JSON.parse(JSON.stringify(q));
    newQ.id = Date.now();
    questions.push(newQ);
    
    // Mock refresh
    alert('Soal diduplikasi! (Reloading page for demo)');
    location.reload();
}

function deleteQuestion(id) {
    if(!confirm('Hapus soal ini?')) return;
    questions = questions.filter(item => item.id !== id);
    // Mock refresh
    alert('Soal dihapus! (Reloading page for demo)');
    location.reload();
}

function renderPreview() {
    const container = document.getElementById('preview-container');
    container.innerHTML = '';
    
    if (questions.length === 0) {
        container.innerHTML = '<div class="text-center text-muted py-5">Belum ada soal dibuat.</div>';
        return;
    }

    questions.forEach((q, idx) => {
        const div = document.createElement('div');
        div.className = 'preview-item pb-4 border-bottom';
        if (idx === questions.length - 1) div.classList.remove('border-bottom');
        
        // Question Number & Text
        let html = `
            <div class="d-flex gap-3 mb-3">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fw-bold" style="width: 28px; height: 28px; font-size: 0.9rem;">${idx + 1}</div>
                <div class="flex-grow-1">
                    <div class="mb-3 text-dark">${q.text}</div>
        `;
        
        // Options / Inputs
        if (q.type === 'pg' || q.type === 'checkbox') {
            const inputType = q.type === 'checkbox' ? 'checkbox' : 'radio';
            const name = `preview_q_${q.id}`;
            html += '<div class="d-flex flex-column gap-2">';
            q.options.forEach(opt => {
                html += `
                    <div class="form-check">
                        <input class="form-check-input" type="${inputType}" name="${name}" id="opt_${q.id}_${Math.random().toString(36).substr(2, 5)}">
                        <label class="form-check-label text-dark opacity-75">${opt.text}</label>
                    </div>
                `;
            });
            html += '</div>';
        } else if (q.type === 'essay_short') {
            html += `<input type="text" class="form-control" placeholder="Jawaban Anda...">`;
        } else if (q.type === 'essay') {
            html += `<textarea class="form-control" rows="4" placeholder="Tulis jawaban Anda disini..."></textarea>`;
        } else if (q.type === 'scale') {
            html += `
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <span class="small fw-bold text-muted">${q.scale_min || 1}</span>
                    <input type="range" class="form-range" min="${q.scale_min || 1}" max="${q.scale_max || 5}">
                    <span class="small fw-bold text-muted">${q.scale_max || 5}</span>
                </div>
            `;
        } else if (q.type === 'percentage') {
             html += `
                <div class="input-group w-50">
                    <input type="number" class="form-control" placeholder="0-100">
                    <span class="input-group-text">%</span>
                </div>
            `;
        }

        html += `
                </div>
            </div>
        `;
        
        div.innerHTML = html;
        container.appendChild(div);
    });
}

// --- IMPORT FEATURE LOGIC ---

// Dummy Bank Soal Data
const dummyBankSoal = {
    1: [
        { id: 101, type: 'pg', text: '<p>Apa itu Funnel dalam marketing?</p>', score: 10, options: [{text:'Corong penjualan', correct:true}, {text:'Saluran air', correct:false}] },
        { id: 102, type: 'essay', text: '<p>Jelaskan strategi konten untuk awareness!</p>', score: 20 },
        { id: 103, type: 'scale', text: '<p>Seberapa penting copywriting?</p>', score: 0, scale_min: 1, scale_max: 5 }
    ],
    2: [
        { id: 201, type: 'pg', text: '<p>Suhu ideal menyeduh kopi V60 adalah?</p>', score: 10, options: [{text:'90-96 C', correct:true}, {text:'100 C', correct:false}] },
        { id: 202, type: 'checkbox', text: '<p>Alat manual brew (pilih 2):</p>', score: 15, options: [{text:'V60', correct:true}, {text:'Espresso Machine', correct:false}, {text:'French Press', correct:true}] }
    ],
    3: [
        { id: 301, type: 'pg', text: '<p>Rumus penjumlahan di Excel adalah?</p>', score: 10, options: [{text:'SUM', correct:true}, {text:'ADD', correct:false}] },
        { id: 302, type: 'pg', text: '<p>Tanda diawal rumus Excel?</p>', score: 10, options: [{text:'=', correct:true}, {text:'#', correct:false}] },
        { id: 303, type: 'essay_short', text: '<p>Shortcut Save As adalah?</p>', score: 10, answer_key: 'F12' }
    ]
};

let currentImportPackageId = 1;

function loadImportQuestions(pkgId) {
    currentImportPackageId = pkgId;
    
    // Update Package List Styles
    const packageList = document.getElementById('import-package-list');
    if (packageList) {
        const buttons = packageList.querySelectorAll('button');
        buttons.forEach((btn, index) => {
            // Simple logic: assume index + 1 matches pkgId for this dummy example
            if (index + 1 === pkgId) {
                btn.classList.add('active', 'bg-primary-subtle', 'text-primary');
                btn.classList.remove('bg-white');
            } else {
                btn.classList.remove('active', 'bg-primary-subtle', 'text-primary');
                btn.classList.add('bg-white');
            }
        });
    }

    const container = document.getElementById('import-questions-container');
    container.innerHTML = '';
    
    const pkgQuestions = dummyBankSoal[pkgId] || [];
    
    if(pkgQuestions.length === 0) {
        container.innerHTML = '<div class="text-center text-muted p-4">Tidak ada soal dalam paket ini.</div>';
        return;
    }
    
    pkgQuestions.forEach(q => {
        const div = document.createElement('div');
        div.className = 'card mb-2 border shadow-none';
        div.innerHTML = `
            <div class="card-body p-3 d-flex gap-3">
                <div class="form-check">
                    <input class="form-check-input import-checkbox" type="checkbox" value="${q.id}" id="import_q_${q.id}">
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="badge bg-light text-muted border text-uppercase extra-small">${q.type}</span>
                        <span class="small fw-bold text-primary">Bobot: ${q.score}</span>
                    </div>
                    <div class="small text-dark text-truncate-2 mb-0">
                        ${q.text}
                    </div>
                </div>
            </div>
        `;
        container.appendChild(div);
    });
    
    // Reset Check All
    const checkAll = document.getElementById('check-all-import');
    if(checkAll) checkAll.checked = false;
    updateSelectedCount();
    
    // Add event listeners to new checkboxes
    document.querySelectorAll('.import-checkbox').forEach(cb => {
        cb.addEventListener('change', updateSelectedCount);
    });
}

function updateSelectedCount() {
    const count = document.querySelectorAll('.import-checkbox:checked').length;
    const badge = document.getElementById('import-selected-count');
    if(badge) badge.innerText = count + ' terpilih';
}

const checkAllBtn = document.getElementById('check-all-import');
if(checkAllBtn) {
    checkAllBtn.addEventListener('change', function(e) {
        const checked = e.target.checked;
        document.querySelectorAll('.import-checkbox').forEach(cb => cb.checked = checked);
        updateSelectedCount();
    });
}

function executeImport() {
    const checkedBoxes = document.querySelectorAll('.import-checkbox:checked');
    if(checkedBoxes.length === 0) {
        alert('Pilih minimal satu soal untuk diimport!');
        return;
    }
    
    const pkgQuestions = dummyBankSoal[currentImportPackageId];
    let addedCount = 0;
    
    checkedBoxes.forEach(cb => {
        const qId = parseInt(cb.value);
        const qOriginal = pkgQuestions.find(q => q.id === qId);
        
        if(qOriginal) {
            // Duplicate Question Logic
            const newQ = JSON.parse(JSON.stringify(qOriginal));
            newQ.id = Date.now() + Math.floor(Math.random() * 1000) + addedCount; // Unique ID
            questions.push(newQ);
            addedCount++;
        }
    });
    
    // Close Modal
    const modalEl = document.getElementById('modalImportQuestion');
    const modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();
    
    alert(addedCount + ' soal berhasil diimport!');
    
    // Reload/Refresh
    location.reload(); 
}

// Initial Load for Modal
const importModal = document.getElementById('modalImportQuestion');
if(importModal) {
    importModal.addEventListener('shown.bs.modal', function () {
        loadImportQuestions(1);
    });
}

</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>