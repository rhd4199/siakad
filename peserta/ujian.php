<?php
require_once __DIR__ . '/../config.php';
require_login(['peserta']);

$user = current_user();
$examId = $_GET['id'] ?? null;

// Simulated Exam Data Structure (Multi-Module)
$examData = [
    'title' => 'Ujian Tengah Semester - Operator Komputer',
    'modules' => [
        [
            'id' => 1,
            'name' => 'Modul 1: Tes Intelegensi Umum',
            'duration' => 30 * 60, // 30 minutes
            'description' => 'Bagian ini menguji kemampuan logika verbal dan numerik Anda.',
            'questions' => []
        ],
        [
            'id' => 2,
            'name' => 'Modul 2: Tes Karakteristik Pribadi',
            'duration' => 20 * 60,
            'description' => 'Jawablah sesuai dengan kepribadian Anda sehari-hari.',
            'questions' => []
        ],
        [
            'id' => 3,
            'name' => 'Modul 3: Studi Kasus & Esai',
            'duration' => 40 * 60,
            'description' => 'Jawablah pertanyaan berikut dengan singkat dan jelas.',
            'questions' => []
        ]
    ]
];

// --- Generate Dummy Questions ---

// Module 1: TIU (Multiple Choice)
for ($i = 1; $i <= 10; $i++) {
    $examData['modules'][0]['questions'][] = [
        'id' => "m1_q$i",
        'type' => 'multiple_choice',
        'text' => "Soal TIU Nomor $i. Pilihlah padanan kata yang tepat untuk: <strong>MOBIL : BENSIN</strong>",
        'options' => [
            'A' => 'Pelari : Makanan',
            'B' => 'Sapi : Rumput',
            'C' => 'Pesawat : Propeler',
            'D' => 'Manusia : Nasi',
            'E' => 'Motor : Listrik'
        ]
    ];
}

// Module 2: TKP (Likert / Scale)
for ($i = 1; $i <= 5; $i++) {
    $examData['modules'][1]['questions'][] = [
        'id' => "m2_q$i",
        'type' => 'scale',
        'text' => "Saya merasa nyaman bekerja dalam tekanan tinggi.",
        'scale_min' => 1,
        'scale_max' => 5,
        'labels' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Netral', 'Setuju', 'Sangat Setuju']
    ];
}

// Module 3: Esai & Multiple Select
$examData['modules'][2]['questions'][] = [
    'id' => "m3_q1",
    'type' => 'short_essay',
    'text' => "Sebutkan 3 komponen utama CPU!",
    'placeholder' => 'Jawaban Anda...'
];
$examData['modules'][2]['questions'][] = [
    'id' => "m3_q2",
    'type' => 'essay',
    'text' => "Jelaskan bagaimana internet bekerja secara sederhana!",
    'placeholder' => 'Tulis penjelasan Anda di sini (min. 50 kata)...'
];
$examData['modules'][2]['questions'][] = [
    'id' => "m3_q3",
    'type' => 'multiple_select',
    'text' => "Manakah yang termasuk perangkat output? (Pilih semua yang benar)",
    'options' => [
        'A' => 'Monitor',
        'B' => 'Keyboard',
        'C' => 'Printer',
        'D' => 'Mouse',
        'E' => 'Speaker'
    ]
];
$examData['modules'][2]['questions'][] = [
    'id' => "m3_q4",
    'type' => 'percentage',
    'text' => "Berapa persentase waktu yang Anda habiskan untuk belajar coding dalam sehari?",
    'placeholder' => '0-100'
];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBT Exam - <?= htmlspecialchars($examData['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .cbt-header {
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 0.75rem 1.5rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1030;
        }
        .cbt-container {
            flex: 1;
            display: flex;
            overflow: hidden;
        }
        .cbt-main {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
            background-color: #fff;
            position: relative;
        }
        .cbt-sidebar {
            width: 320px;
            background-color: #f1f3f5;
            border-left: 1px solid #dee2e6;
            display: flex;
            flex-direction: column;
        }
        .question-nav-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            padding: 1rem;
            overflow-y: auto;
        }
        .nav-btn {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ced4da;
            background: #fff;
            cursor: pointer;
            font-size: 0.875rem;
            border-radius: 4px;
            position: relative;
        }
        .nav-btn:hover {
            background-color: #e9ecef;
        }
        .nav-btn.active {
            border-color: #0d6efd;
            background-color: #e7f1ff;
            color: #0d6efd;
            font-weight: bold;
        }
        .nav-btn.answered {
            background-color: #198754;
            color: white;
            border-color: #198754;
        }
        .nav-btn.flagged {
            background-color: #ffc107;
            color: black;
            border-color: #ffc107;
        }
        
        .option-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 0.75rem;
            transition: all 0.2s;
            cursor: pointer;
            position: relative;
            padding: 1rem;
            display: flex;
            align-items: center;
        }
        .option-card:hover {
            background-color: #f8f9fa;
        }
        .option-card.selected {
            background-color: #e7f1ff;
            border-color: #0d6efd;
        }
        .option-label {
            font-weight: bold;
            margin-right: 1rem;
            width: 24px;
        }
        
        .timer-box {
            background: #212529;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-family: monospace;
            font-size: 1.25rem;
            font-weight: bold;
        }
        
        .module-interstitial {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: white;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .cbt-container {
                flex-direction: column;
            }
            .cbt-sidebar {
                width: 100%;
                height: 200px;
                order: 2;
                border-left: none;
                border-top: 1px solid #dee2e6;
            }
            .cbt-main {
                order: 1;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="cbt-header shadow-sm">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary text-white rounded p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-laptop"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold d-none d-md-block"><?= htmlspecialchars($examData['title']) ?></h6>
                <div class="small text-muted" id="current-module-name">Modul 1</div>
            </div>
        </div>
        
        <div class="d-flex align-items-center gap-3">
            <div class="timer-box d-flex align-items-center gap-2">
                <i class="bi bi-clock"></i>
                <span id="timer">00:00:00</span>
            </div>
            <button class="btn btn-success fw-bold px-4" onclick="finishExam()">
                <i class="bi bi-check-circle me-1"></i> Selesai
            </button>
        </div>
    </header>

    <div class="cbt-container">
        <!-- Main Question Area -->
        <main class="cbt-main">
            
            <!-- Module Transition Screen (Hidden by default) -->
            <div id="module-screen" class="module-interstitial d-none">
                <div style="max-width: 600px; padding: 2rem;">
                    <div class="mb-4 text-primary">
                        <i class="bi bi-layers-fill display-1"></i>
                    </div>
                    <h2 class="fw-bold mb-3" id="mod-title">Modul Selanjutnya</h2>
                    <p class="text-muted fs-5 mb-4" id="mod-desc">Deskripsi modul...</p>
                    <div class="alert alert-info border-0 d-flex gap-3 text-start mb-4">
                        <i class="bi bi-info-circle-fill fs-4 mt-1"></i>
                        <div>
                            <strong>Perhatian:</strong>
                            <br>Waktu pengerjaan untuk modul ini adalah <strong id="mod-duration"></strong> menit. 
                            Waktu akan dimulai segera setelah Anda menekan tombol di bawah.
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg px-5 rounded-pill" onclick="startModule()">
                        Mulai Mengerjakan <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>

            <!-- Question Content -->
            <div id="question-area" class="container-fluid p-0" style="max-width: 900px; margin: 0 auto;">
                
                <!-- Question Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0 text-primary">Soal No. <span id="q-number">1</span></h5>
                    <div class="badge bg-secondary" id="q-type">TIU</div>
                </div>

                <!-- Question Text -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <p class="fs-5 mb-0" id="q-text">Loading question...</p>
                    </div>
                </div>

                <!-- Input Area (Options / Essay / Scale) -->
                <div id="input-container">
                    <!-- Injected via JS -->
                </div>

                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mt-5 pt-3 border-top align-items-center">
                    <button class="btn btn-outline-secondary px-4" id="btn-prev" onclick="prevQuestion()">
                        <i class="bi bi-chevron-left me-1"></i> Sebelumnya
                    </button>
                    
                    <div class="form-check form-switch d-flex align-items-center gap-2">
                        <input class="form-check-input" type="checkbox" id="flag-check" onchange="toggleFlag()">
                        <label class="form-check-label fw-medium text-warning" for="flag-check">Ragu-ragu</label>
                    </div>

                    <button class="btn btn-primary px-4" id="btn-next" onclick="nextQuestion()">
                        Selanjutnya <i class="bi bi-chevron-right ms-1"></i>
                    </button>
                </div>

                <!-- Bottom Submit Button (Requested) -->
                <div class="mt-4 text-center">
                    <button class="btn btn-success fw-bold px-5 py-2 shadow-sm" onclick="finishExam()">
                        <i class="bi bi-send-check me-2"></i> Submit Jawaban
                    </button>
                    <div class="small text-muted mt-2">Pastikan semua jawaban telah terisi sebelum submit.</div>
                </div>
            </div>
        </main>

        <!-- Sidebar Navigation -->
        <aside class="cbt-sidebar">
            <div class="p-3 border-bottom bg-white">
                <h6 class="fw-bold mb-0">Navigasi Soal</h6>
                <div class="d-flex gap-3 mt-2 small">
                    <div class="d-flex align-items-center gap-1">
                        <div style="width:12px; height:12px; background:#198754; border-radius:2px;"></div> Sudah
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="width:12px; height:12px; background:#ffc107; border-radius:2px;"></div> Ragu
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="width:12px; height:12px; border:1px solid #ced4da; border-radius:2px;"></div> Belum
                    </div>
                </div>
            </div>
            
            <div class="p-2 bg-light border-bottom text-center fw-bold small text-muted" id="sidebar-mod-title">
                Modul 1
            </div>

            <div class="question-nav-grid" id="nav-grid">
                <!-- Grid injected via JS -->
            </div>
        </aside>
    </div>

    <!-- Finish Modal -->
    <div class="modal fade" id="finishModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Konfirmasi Selesai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-question-circle text-primary display-1"></i>
                    </div>
                    <h5 class="mb-3">Apakah Anda yakin ingin mengakhiri ujian?</h5>
                    <p class="text-muted mb-0">
                        Anda telah menjawab <strong id="answered-count">0</strong> soal.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Lanjutkan Mengerjakan</button>
                    <a href="tugas.php?tab=completed" class="btn btn-success fw-bold px-4">Ya, Selesai</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Data from PHP
        const modules = <?= json_encode($examData['modules']) ?>;
        
        // State
        let currentModuleIndex = 0;
        let currentQuestionIndex = 0; // Relative to current module
        let answers = {}; // { qId: value }
        let flagged = new Set(); // Set of qIds
        let timerInterval;
        let timeLeft = 0;

        // Elements
        const elQArea = document.getElementById('question-area');
        const elModScreen = document.getElementById('module-screen');
        const elInputContainer = document.getElementById('input-container');
        const elNavGrid = document.getElementById('nav-grid');
        const elTimer = document.getElementById('timer');
        const elCurrentModName = document.getElementById('current-module-name');
        const elSidebarModTitle = document.getElementById('sidebar-mod-title');

        // Init
        function init() {
            showModuleScreen(0);
        }

        // --- Module Management ---

        function showModuleScreen(modIndex) {
            if (modIndex >= modules.length) {
                finishExam(true);
                return;
            }

            const mod = modules[modIndex];
            currentModuleIndex = modIndex;
            currentQuestionIndex = 0; // Reset q index for new module
            
            // UI Update
            elQArea.classList.add('d-none');
            elModScreen.classList.remove('d-none');
            
            document.getElementById('mod-title').textContent = mod.name;
            document.getElementById('mod-desc').textContent = mod.description;
            document.getElementById('mod-duration').textContent = Math.floor(mod.duration / 60);
            
            // Stop timer if running
            if (timerInterval) clearInterval(timerInterval);
        }

        function startModule() {
            const mod = modules[currentModuleIndex];
            timeLeft = mod.duration;
            
            elModScreen.classList.add('d-none');
            elQArea.classList.remove('d-none');
            
            elCurrentModName.textContent = mod.name;
            elSidebarModTitle.textContent = mod.name;

            renderNavGrid();
            loadQuestion(0);
            startTimer();
        }

        function startTimer() {
            updateTimerDisplay();
            timerInterval = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    // Time's up for module -> go to next
                    alert('Waktu untuk modul ini telah habis!');
                    showModuleScreen(currentModuleIndex + 1);
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            const h = Math.floor(timeLeft / 3600).toString().padStart(2, '0');
            const m = Math.floor((timeLeft % 3600) / 60).toString().padStart(2, '0');
            const s = (timeLeft % 60).toString().padStart(2, '0');
            elTimer.textContent = `${h}:${m}:${s}`;
        }

        // --- Rendering ---

        function renderNavGrid() {
            elNavGrid.innerHTML = '';
            const questions = modules[currentModuleIndex].questions;
            
            questions.forEach((q, index) => {
                const btn = document.createElement('div');
                btn.className = 'nav-btn';
                btn.textContent = index + 1;
                btn.onclick = () => loadQuestion(index);
                btn.id = `nav-btn-${index}`;
                
                updateNavBtnClass(btn, q.id, index);
                elNavGrid.appendChild(btn);
            });
        }

        function updateNavBtnClass(btn, qId, index) {
            btn.className = 'nav-btn';
            if (index === currentQuestionIndex) btn.classList.add('active');
            if (answers[qId] && (Array.isArray(answers[qId]) ? answers[qId].length > 0 : true)) btn.classList.add('answered');
            if (flagged.has(qId)) btn.classList.add('flagged');
        }

        function loadQuestion(index) {
            const questions = modules[currentModuleIndex].questions;
            const q = questions[index];
            
            // Update Nav UI
            const oldBtn = document.getElementById(`nav-btn-${currentQuestionIndex}`);
            if (oldBtn) updateNavBtnClass(oldBtn, questions[currentQuestionIndex].id, currentQuestionIndex);
            
            currentQuestionIndex = index;
            
            const newBtn = document.getElementById(`nav-btn-${currentQuestionIndex}`);
            if (newBtn) updateNavBtnClass(newBtn, q.id, currentQuestionIndex);

            // Render Question Info
            document.getElementById('q-number').textContent = index + 1;
            document.getElementById('q-type').textContent = formatType(q.type);
            document.getElementById('q-text').innerHTML = q.text;
            
            // Render Input
            elInputContainer.innerHTML = '';
            renderInput(q);

            // Checkbox Flag
            document.getElementById('flag-check').checked = flagged.has(q.id);

            // Nav Buttons
            document.getElementById('btn-prev').disabled = index === 0;
            const btnNext = document.getElementById('btn-next');
            
            if (index === questions.length - 1) {
                if (currentModuleIndex < modules.length - 1) {
                    btnNext.innerHTML = 'Modul Berikutnya <i class="bi bi-arrow-right ms-1"></i>';
                    btnNext.onclick = () => showModuleScreen(currentModuleIndex + 1);
                } else {
                    btnNext.innerHTML = 'Selesai <i class="bi bi-check-circle ms-1"></i>';
                    btnNext.classList.remove('btn-primary');
                    btnNext.classList.add('btn-success');
                    btnNext.onclick = finishExam;
                }
            } else {
                btnNext.innerHTML = 'Selanjutnya <i class="bi bi-chevron-right ms-1"></i>';
                btnNext.classList.add('btn-primary');
                btnNext.classList.remove('btn-success');
                btnNext.onclick = nextQuestion;
            }
        }

        function formatType(type) {
            const map = {
                'multiple_choice': 'Pilihan Ganda',
                'multiple_select': 'Pilihan Ganda (Majemuk)',
                'scale': 'Skala',
                'essay': 'Esai',
                'short_essay': 'Isian Singkat',
                'percentage': 'Persentase'
            };
            return map[type] || type.toUpperCase();
        }

        function renderInput(q) {
            const val = answers[q.id];

            // 1. Multiple Choice (Radio)
            if (q.type === 'multiple_choice') {
                for (const [key, value] of Object.entries(q.options)) {
                    const isSelected = val === key;
                    const card = document.createElement('div');
                    card.className = `option-card ${isSelected ? 'selected' : ''}`;
                    card.onclick = () => saveAnswer(q.id, key);
                    card.innerHTML = `
                        <div class="option-label text-center border rounded ${isSelected ? 'bg-primary text-white border-primary' : 'bg-light'}">${key}</div>
                        <div>${value}</div>
                    `;
                    elInputContainer.appendChild(card);
                }
            }
            
            // 2. Multiple Select (Checkbox)
            else if (q.type === 'multiple_select') {
                const currentVals = Array.isArray(val) ? val : [];
                for (const [key, value] of Object.entries(q.options)) {
                    const isSelected = currentVals.includes(key);
                    const card = document.createElement('div');
                    card.className = `option-card ${isSelected ? 'selected' : ''}`;
                    card.onclick = () => {
                        let newVals = [...currentVals];
                        if (newVals.includes(key)) newVals = newVals.filter(v => v !== key);
                        else newVals.push(key);
                        saveAnswer(q.id, newVals);
                    };
                    card.innerHTML = `
                        <div class="option-label text-center border rounded ${isSelected ? 'bg-primary text-white border-primary' : 'bg-light'}">
                            <i class="bi bi-${isSelected ? 'check-square-fill' : 'square'}"></i>
                        </div>
                        <div>${value}</div>
                    `;
                    elInputContainer.appendChild(card);
                }
            }

            // 3. Scale (Likert)
            else if (q.type === 'scale') {
                const wrapper = document.createElement('div');
                wrapper.className = 'd-flex justify-content-between align-items-center bg-light p-4 rounded-3 mt-2';
                
                q.labels.forEach((label, idx) => {
                    const score = q.scale_min + idx;
                    const isSelected = val == score;
                    const item = document.createElement('div');
                    item.className = 'text-center cursor-pointer';
                    item.style.cursor = 'pointer';
                    item.onclick = () => saveAnswer(q.id, score);
                    
                    item.innerHTML = `
                        <div class="mb-2">
                            <div class="rounded-circle border d-flex align-items-center justify-content-center mx-auto transition-all" 
                                 style="width: 40px; height: 40px; ${isSelected ? 'background: #0d6efd; color: white; border-color: #0d6efd;' : 'background: white;'}">
                                <strong>${score}</strong>
                            </div>
                        </div>
                        <small class="text-muted ${isSelected ? 'fw-bold text-primary' : ''}">${label}</small>
                    `;
                    wrapper.appendChild(item);
                });
                elInputContainer.appendChild(wrapper);
            }

            // 4. Essay / Short Essay
            else if (q.type === 'essay' || q.type === 'short_essay') {
                const isLong = q.type === 'essay';
                const wrapper = document.createElement('div');
                
                if (isLong) {
                    wrapper.innerHTML = `
                        <textarea class="form-control" rows="6" placeholder="${q.placeholder || ''}" 
                        onblur="saveAnswer('${q.id}', this.value)">${val || ''}</textarea>
                    `;
                } else {
                    wrapper.innerHTML = `
                        <input type="text" class="form-control form-control-lg" placeholder="${q.placeholder || ''}" 
                        value="${val || ''}" onblur="saveAnswer('${q.id}', this.value)">
                    `;
                }
                elInputContainer.appendChild(wrapper);
            }

            // 5. Percentage
            else if (q.type === 'percentage') {
                const wrapper = document.createElement('div');
                wrapper.innerHTML = `
                    <div class="input-group input-group-lg" style="max-width: 200px;">
                        <input type="number" class="form-control text-end" min="0" max="100" placeholder="0" 
                        value="${val || ''}" onblur="saveAnswer('${q.id}', this.value)">
                        <span class="input-group-text">%</span>
                    </div>
                `;
                elInputContainer.appendChild(wrapper);
            }
        }

        // --- Logic ---

        function saveAnswer(qId, value) {
            answers[qId] = value;
            
            // Re-render if necessary (for visual feedback on clicks)
            // For text inputs, we don't re-render to keep focus
            const q = modules[currentModuleIndex].questions[currentQuestionIndex];
            if (['multiple_choice', 'multiple_select', 'scale'].includes(q.type)) {
                loadQuestion(currentQuestionIndex);
            } else {
                // Just update sidebar
                const btn = document.getElementById(`nav-btn-${currentQuestionIndex}`);
                if (btn) updateNavBtnClass(btn, qId, currentQuestionIndex);
            }
        }

        function toggleFlag() {
            const q = modules[currentModuleIndex].questions[currentQuestionIndex];
            if (document.getElementById('flag-check').checked) {
                flagged.add(q.id);
            } else {
                flagged.delete(q.id);
            }
            const btn = document.getElementById(`nav-btn-${currentQuestionIndex}`);
            if (btn) updateNavBtnClass(btn, q.id, currentQuestionIndex);
        }

        function nextQuestion() {
            const questions = modules[currentModuleIndex].questions;
            if (currentQuestionIndex < questions.length - 1) {
                loadQuestion(currentQuestionIndex + 1);
            }
        }

        function prevQuestion() {
            if (currentQuestionIndex > 0) {
                loadQuestion(currentQuestionIndex - 1);
            }
        }

        function finishExam() {
            const count = Object.keys(answers).length;
            document.getElementById('answered-count').textContent = count;
            
            const modal = new bootstrap.Modal(document.getElementById('finishModal'));
            modal.show();
        }

        // Start
        init();

    </script>
</body>
</html>
