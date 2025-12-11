<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$user         = current_user();
$title        = 'Manajemen Kelas';
$currentPage  = 'kelas';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

// Simulated Data Classes
$classes = [
    [
        'id' => 101,
        'code' => 'DM-01',
        'program' => 'Digital Marketing',
        'batch' => 'Batch Januari 2025',
        'tutor' => 'Eko Kurniawan',
        'tutor_avatar' => 'EK',
        'tutor_color' => 'primary',
        'schedule' => 'Senin & Kamis, 19:00',
        'students_count' => 18,
        'capacity' => 20,
        'progress' => 90, 
        'status' => 'active',
        'room' => 'Lab Komputer A'
    ],
    [
        'id' => 102,
        'code' => 'WD-03',
        'program' => 'Web Development',
        'batch' => 'Batch Februari 2025',
        'tutor' => 'Sandhika Galih',
        'tutor_avatar' => 'SG',
        'tutor_color' => 'success',
        'schedule' => 'Sabtu & Minggu, 09:00',
        'students_count' => 15,
        'capacity' => 15,
        'progress' => 100,
        'status' => 'active',
        'room' => 'Lab Komputer B'
    ],
    [
        'id' => 103,
        'code' => 'GD-02',
        'program' => 'Graphic Design',
        'batch' => 'Batch Maret 2025',
        'tutor' => 'Rio Purba',
        'tutor_avatar' => 'RP',
        'tutor_color' => 'danger',
        'schedule' => 'Selasa & Jumat, 15:00',
        'students_count' => 5,
        'capacity' => 20,
        'progress' => 25,
        'status' => 'upcoming',
        'room' => 'Studio Desain'
    ],
    [
        'id' => 104,
        'code' => 'OM-05',
        'program' => 'Operator Komputer',
        'batch' => 'Batch April 2025',
        'tutor' => 'Budi Santoso',
        'tutor_avatar' => 'BS',
        'tutor_color' => 'warning',
        'schedule' => 'Rabu, 08:00',
        'students_count' => 0,
        'capacity' => 25,
        'progress' => 0,
        'status' => 'upcoming',
        'room' => 'Lab Komputer A'
    ]
];

// Simulated Participants for Demo
$demo_participants = [
    ['name' => 'Aditya Pratama', 'id' => 'ST-001', 'avatar' => 'AP', 'color' => 'primary'],
    ['name' => 'Bunga Citra', 'id' => 'ST-002', 'avatar' => 'BC', 'color' => 'success'],
    ['name' => 'Chandra Wijaya', 'id' => 'ST-003', 'avatar' => 'CW', 'color' => 'info'],
    ['name' => 'Diana Sari', 'id' => 'ST-004', 'avatar' => 'DS', 'color' => 'warning'],
    ['name' => 'Erik Santoso', 'id' => 'ST-005', 'avatar' => 'ES', 'color' => 'danger'],
];

ob_start();
?>

<style>
    .class-card {
        transition: all 0.2s ease-in-out;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .class-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        border-color: var(--bs-primary-border-subtle);
    }
    .progress-thin {
        height: 6px;
    }
    .avatar-sm {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        border-radius: 50%;
        font-weight: 600;
    }
    .dashed-circle {
        width: 40px;
        height: 40px;
        border: 2px dashed #dee2e6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
    }
</style>

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1">Manajemen Kelas</h4>
        <p class="text-muted small mb-0">
            Kelola jadwal, kapasitas, dan peserta pelatihan.
        </p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <button class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#addClassModal">
            <i class="bi bi-plus-lg me-1"></i> Buat Kelas Baru
        </button>
    </div>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 bg-light" placeholder="Cari kelas atau program...">
                </div>
            </div>
            <div class="col-md-8 text-md-end">
                <div class="d-flex justify-content-md-end gap-2">
                    <select class="form-select form-select-sm w-auto bg-light border-0">
                        <option selected>Semua Program</option>
                        <option>Web Development</option>
                        <option>Digital Marketing</option>
                    </select>
                    <select class="form-select form-select-sm w-auto bg-light border-0">
                        <option selected>Status</option>
                        <option>Active</option>
                        <option>Upcoming</option>
                        <option>Finished</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Class Grid -->
<div class="row g-4">
    <?php foreach ($classes as $cls): ?>
    <div class="col-md-6 col-xl-4">
        <div class="card class-card h-100 shadow-sm border-0">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge bg-light text-dark border mb-2"><?= $cls['code'] ?></span>
                        <h5 class="fw-bold mb-0 text-truncate" title="<?= $cls['program'] ?>"><?= $cls['program'] ?></h5>
                        <div class="small text-muted"><?= $cls['batch'] ?></div>
                    </div>
                    <?php if ($cls['status'] == 'active'): ?>
                        <span class="badge bg-success-subtle text-success rounded-pill">Berjalan</span>
                    <?php else: ?>
                        <span class="badge bg-warning-subtle text-warning rounded-pill">Akan Datang</span>
                    <?php endif; ?>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar-sm bg-<?= $cls['tutor_color'] ?>-subtle text-<?= $cls['tutor_color'] ?> me-2">
                            <?= $cls['tutor_avatar'] ?>
                        </div>
                        <div class="small">
                            <div class="fw-semibold"><?= $cls['tutor'] ?></div>
                            <div class="text-muted extra-small">Instruktur</div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3 small text-muted mt-3">
                        <div><i class="bi bi-calendar-week me-1"></i><?= $cls['schedule'] ?></div>
                        <div><i class="bi bi-geo-alt me-1"></i><?= $cls['room'] ?></div>
                    </div>
                </div>

                <div class="mt-auto">
                    <div class="d-flex justify-content-between align-items-end mb-1 small">
                        <span class="text-muted">Kapasitas</span>
                        <span class="fw-bold"><?= $cls['students_count'] ?> / <?= $cls['capacity'] ?></span>
                    </div>
                    <div class="progress progress-thin bg-light mb-3">
                        <div class="progress-bar bg-<?= $cls['status'] == 'active' ? 'primary' : 'warning' ?>" 
                             role="progressbar" 
                             style="width: <?= $cls['progress'] ?>%">
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm rounded-pill" 
                                type="button" 
                                data-bs-toggle="offcanvas" 
                                data-bs-target="#offcanvasPeserta" 
                                onclick="loadClassParticipants('<?= $cls['program'] ?>', '<?= $cls['code'] ?>')">
                            <i class="bi bi-people me-1"></i> Kelola Peserta
                        </button>
                        <a href="kelas-detail.php?id=<?= $cls['id'] ?>" class="btn btn-light btn-sm text-muted border-0">
                            <i class="bi bi-info-circle me-1"></i> Detail Kelas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Offcanvas Manage Participants -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasPeserta" aria-labelledby="offcanvasPesertaLabel" style="width: 450px;">
    <div class="offcanvas-header border-bottom">
        <div>
            <h5 class="offcanvas-title fw-bold" id="offcanvasPesertaLabel">Kelola Peserta</h5>
            <div class="small text-muted" id="offcanvasClassInfo">Memuat data kelas...</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <!-- Add Participant Section -->
        <div class="p-3 bg-light border-bottom">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label small fw-bold text-uppercase text-muted mb-0">Tambahkan Peserta</label>
                <div class="btn-group btn-group-sm" role="group">
                    <input type="radio" class="btn-check" name="addMode" id="modeSingle" autocomplete="off" checked onchange="toggleAddMode('single')">
                    <label class="btn btn-outline-secondary extra-small" for="modeSingle">Satuan</label>

                    <input type="radio" class="btn-check" name="addMode" id="modeBulk" autocomplete="off" onchange="toggleAddMode('bulk')">
                    <label class="btn btn-outline-secondary extra-small" for="modeBulk">Banyak</label>
                </div>
            </div>

            <!-- Single Mode -->
            <div id="singleAddMode">
                <div class="input-group mb-1">
                    <select class="form-select form-select-sm">
                        <option selected>Pilih Siswa...</option>
                        <option>Siswa Baru (Daftar dulu)</option>
                        <option>Aditya Pratama (Web Dev)</option>
                        <option>Bunga Citra (Digi Mar)</option>
                    </select>
                    <button class="btn btn-primary btn-sm" type="button">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Bulk Mode -->
            <div id="bulkAddMode" class="d-none">
                <div class="position-relative mb-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control form-control-sm border-start-0" id="studentSearchInput" placeholder="Cari nama atau ID siswa..." autocomplete="off">
                    </div>
                    <div id="searchResults" class="position-absolute w-100 bg-white shadow-sm border rounded-bottom mt-0 d-none" style="z-index: 1050; max-height: 200px; overflow-y: auto;">
                        <!-- Results injected here -->
                    </div>
                </div>
                
                <div class="mb-2">
                    <div class="small text-muted mb-1" id="selectedLabel" style="font-size: 0.75rem; display: none;">Dipilih:</div>
                    <div id="selectedStudentsContainer" class="d-flex flex-wrap gap-1" style="min-height: 0px;">
                        <!-- Selected chips injected here -->
                    </div>
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary btn-sm" type="button" id="btnAddBulk" disabled>
                        <i class="bi bi-person-plus-fill me-1"></i> Tambahkan <span id="selectedCount">0</span> Peserta
                    </button>
                </div>
            </div>
        </div>

        <!-- Participants List -->
        <div class="p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Daftar Peserta (Simulasi)</h6>
                <span class="badge bg-secondary-subtle text-secondary rounded-pill">5 Siswa</span>
            </div>

            <div class="list-group list-group-flush border rounded-3">
                <?php foreach ($demo_participants as $student): ?>
                <div class="list-group-item d-flex align-items-center justify-content-between p-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-<?= $student['color'] ?>-subtle text-<?= $student['color'] ?> me-3">
                            <?= $student['avatar'] ?>
                        </div>
                        <div>
                            <div class="fw-semibold text-dark small"><?= $student['name'] ?></div>
                            <div class="extra-small text-muted"><?= $student['id'] ?></div>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border-0 text-muted" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li><a class="dropdown-item small" href="#"><i class="bi bi-person me-2"></i>Lihat Profil</a></li>
                            <li><a class="dropdown-item small" href="#"><i class="bi bi-journal-text me-2"></i>Lihat Nilai</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item small text-danger" href="#"><i class="bi bi-x-circle me-2"></i>Keluarkan</a></li>
                        </ul>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted extra-small">
                    Data peserta ditampilkan berdasarkan kelas yang dipilih.<br>
                    (Simulasi data statis untuk demo)
                </p>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer p-3 border-top bg-light">
        <div class="d-grid">
            <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="offcanvas">Tutup Panel</button>
        </div>
    </div>
</div>

<!-- Modal Add Class (Wizard Style) -->
<div class="modal fade" id="addClassModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Buat Kelas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <!-- Stepper -->
                <div class="d-flex justify-content-center mb-4 mt-2">
                    <div class="d-flex align-items-center w-75 position-relative">
                        <div class="position-absolute top-50 start-0 w-100 translate-middle-y bg-light rounded-pill" style="height: 4px; z-index: 0;"></div>
                        <div class="position-absolute top-50 start-0 w-0 translate-middle-y bg-primary rounded-pill transition-width" id="stepperProgress" style="height: 4px; z-index: 0; transition: width 0.3s;"></div>
                        
                        <button class="btn btn-sm btn-primary rounded-circle position-relative z-1 d-flex align-items-center justify-content-center step-indicator active" style="width: 32px; height: 32px;" data-step="1">1</button>
                        <div class="flex-grow-1"></div>
                        <button class="btn btn-sm btn-light text-muted rounded-circle position-relative z-1 d-flex align-items-center justify-content-center step-indicator" style="width: 32px; height: 32px;" data-step="2">2</button>
                        <div class="flex-grow-1"></div>
                        <button class="btn btn-sm btn-light text-muted rounded-circle position-relative z-1 d-flex align-items-center justify-content-center step-indicator" style="width: 32px; height: 32px;" data-step="3">3</button>
                    </div>
                </div>

                <form id="createClassForm">
                    <!-- Step 1: Basic Info -->
                    <div class="step-content" id="step1">
                        <h6 class="fw-bold mb-3 text-primary">Informasi Dasar</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Program Pelatihan</label>
                                <select class="form-select">
                                    <option selected disabled>Pilih Program...</option>
                                    <option>Web Development</option>
                                    <option>Digital Marketing</option>
                                    <option>Graphic Design</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Batch</label>
                                <input type="text" class="form-control" placeholder="Contoh: Batch Maret 2025">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Deskripsi Singkat</label>
                                <textarea class="form-control" rows="2" placeholder="Deskripsi opsional..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Schedule & Room -->
                    <div class="step-content d-none" id="step2">
                        <h6 class="fw-bold mb-3 text-primary">Jadwal & Lokasi</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Hari</label>
                                <div class="d-flex gap-2 flex-wrap">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="senin" value="Senin">
                                        <label class="form-check-label" for="senin">Sen</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="selasa" value="Selasa">
                                        <label class="form-check-label" for="selasa">Sel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="rabu" value="Rabu">
                                        <label class="form-check-label" for="rabu">Rab</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="kamis" value="Kamis">
                                        <label class="form-check-label" for="kamis">Kam</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="jumat" value="Jumat">
                                        <label class="form-check-label" for="jumat">Jum</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Jam Mulai</label>
                                <input type="time" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Ruangan / Lab</label>
                                <select class="form-select">
                                    <option selected disabled>Pilih Ruangan...</option>
                                    <option>Lab Komputer A (Kapasitas 20)</option>
                                    <option>Lab Komputer B (Kapasitas 25)</option>
                                    <option>Studio Desain (Kapasitas 15)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Instructor & Capacity -->
                    <div class="step-content d-none" id="step3">
                        <h6 class="fw-bold mb-3 text-primary">Instruktur & Kapasitas</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Instruktur Pengajar</label>
                                <select class="form-select">
                                    <option selected disabled>Pilih Instruktur...</option>
                                    <option>Eko Kurniawan (Web)</option>
                                    <option>Sandhika Galih (Web)</option>
                                    <option>Rio Purba (Design)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Target Kapasitas Siswa</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" value="20">
                                    <span class="input-group-text">Siswa</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="autoStatus" checked>
                                    <label class="form-check-label small" for="autoStatus">Set status ke "Akan Datang" secara otomatis</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 d-flex justify-content-between">
                <button type="button" class="btn btn-light rounded-pill px-4" id="prevBtn" disabled>Kembali</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="nextBtn">Lanjut</button>
                <button type="button" class="btn btn-success rounded-pill px-4 d-none" id="submitBtn">Simpan Kelas</button>
            </div>
        </div>
    </div>
</div>

<script>
    function loadClassParticipants(programName, classCode) {
        document.getElementById('offcanvasClassInfo').textContent = programName + ' - ' + classCode;
        // In a real app, you would fetch data via AJAX here
    }

    function toggleAddMode(mode) {
        if (mode === 'single') {
            document.getElementById('singleAddMode').classList.remove('d-none');
            document.getElementById('bulkAddMode').classList.add('d-none');
        } else {
            document.getElementById('singleAddMode').classList.add('d-none');
            document.getElementById('bulkAddMode').classList.remove('d-none');
        }
    }

    // Wizard Logic
    document.addEventListener('DOMContentLoaded', function() {
        let currentStep = 1;
        const totalSteps = 3;
        
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');
        const stepperProgress = document.getElementById('stepperProgress');

        function updateWizard() {
            // Hide all steps
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('d-none'));
            // Show current step
            document.getElementById('step' + currentStep).classList.remove('d-none');
            
            // Update buttons
            prevBtn.disabled = currentStep === 1;
            
            if (currentStep === totalSteps) {
                nextBtn.classList.add('d-none');
                submitBtn.classList.remove('d-none');
            } else {
                nextBtn.classList.remove('d-none');
                submitBtn.classList.add('d-none');
            }

            // Update Stepper UI
            document.querySelectorAll('.step-indicator').forEach(el => {
                const step = parseInt(el.getAttribute('data-step'));
                if (step <= currentStep) {
                    el.classList.remove('btn-light', 'text-muted');
                    el.classList.add('btn-primary');
                } else {
                    el.classList.remove('btn-primary');
                    el.classList.add('btn-light', 'text-muted');
                }
            });

            // Update Progress Bar
            const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
            stepperProgress.style.width = progress + '%';
        }

        nextBtn.addEventListener('click', function() {
            if (currentStep < totalSteps) {
                currentStep++;
                updateWizard();
            }
        });

        prevBtn.addEventListener('click', function() {
            if (currentStep > 1) {
                currentStep--;
                updateWizard();
            }
        });

        // Initialize
        updateWizard();

        // Bulk Add Participant Logic
        const allStudents = [
            { id: 'ST-006', name: 'Fajar Nugraha', email: 'fajar@example.com', avatar: 'FN', color: 'primary' },
            { id: 'ST-007', name: 'Gita Pertiwi', email: 'gita@example.com', avatar: 'GP', color: 'success' },
            { id: 'ST-008', name: 'Hadi Wijaya', email: 'hadi@example.com', avatar: 'HW', color: 'danger' },
            { id: 'ST-009', name: 'Indah Sari', email: 'indah@example.com', avatar: 'IS', color: 'warning' },
            { id: 'ST-010', name: 'Joko Susilo', email: 'joko@example.com', avatar: 'JS', color: 'info' },
            { id: 'ST-011', name: 'Kartika Dewi', email: 'kartika@example.com', avatar: 'KD', color: 'secondary' },
            { id: 'ST-012', name: 'Lukman Hakim', email: 'lukman@example.com', avatar: 'LH', color: 'primary' },
            { id: 'ST-013', name: 'Maya Putri', email: 'maya@example.com', avatar: 'MP', color: 'success' }
        ];

        let selectedStudents = [];
        const searchInput = document.getElementById('studentSearchInput');
        const searchResults = document.getElementById('searchResults');
        const selectedContainer = document.getElementById('selectedStudentsContainer');
        const selectedLabel = document.getElementById('selectedLabel');
        const btnAddBulk = document.getElementById('btnAddBulk');
        const selectedCountSpan = document.getElementById('selectedCount');

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            if (query.length < 1) {
                searchResults.classList.add('d-none');
                return;
            }

            const matches = allStudents.filter(s => 
                !selectedStudents.find(sel => sel.id === s.id) && 
                (s.name.toLowerCase().includes(query) || s.id.toLowerCase().includes(query))
            );

            if (matches.length > 0) {
                let html = '<div class="list-group list-group-flush">';
                matches.forEach(s => {
                    html += `
                        <button type="button" class="list-group-item list-group-item-action px-3 py-2 small" onclick="selectStudent('${s.id}')">
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs bg-${s.color}-subtle text-${s.color} rounded-circle me-2" style="width:24px;height:24px;display:flex;align-items:center;justify-content:center;font-size:0.7rem;">${s.avatar}</div>
                                <div>
                                    <div class="fw-semibold">${s.name}</div>
                                    <div class="text-muted extra-small">${s.id}</div>
                                </div>
                            </div>
                        </button>
                    `;
                });
                html += '</div>';
                searchResults.innerHTML = html;
                searchResults.classList.remove('d-none');
            } else {
                searchResults.innerHTML = '<div class="p-2 text-muted small text-center">Tidak ditemukan</div>';
                searchResults.classList.remove('d-none');
            }
        });

        // Hide results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('d-none');
            }
        });

        window.selectStudent = function(id) {
            const student = allStudents.find(s => s.id === id);
            if (student) {
                selectedStudents.push(student);
                renderSelected();
                searchInput.value = '';
                searchResults.classList.add('d-none');
                searchInput.focus();
            }
        };

        window.removeStudent = function(id) {
            selectedStudents = selectedStudents.filter(s => s.id !== id);
            renderSelected();
        };

        function renderSelected() {
            selectedContainer.innerHTML = '';
            if (selectedStudents.length > 0) {
                selectedLabel.style.display = 'block';
                selectedStudents.forEach(s => {
                    const chip = document.createElement('div');
                    chip.className = 'badge bg-light text-dark border d-flex align-items-center p-1 pe-2';
                    chip.innerHTML = `
                        <div class="avatar-xs bg-${s.color}-subtle text-${s.color} rounded-circle me-1" style="width:16px;height:16px;display:flex;align-items:center;justify-content:center;font-size:0.5rem;">${s.avatar}</div>
                        <span class="fw-normal me-2">${s.name}</span>
                        <i class="bi bi-x text-muted cursor-pointer" onclick="removeStudent('${s.id}')" style="cursor:pointer"></i>
                    `;
                    selectedContainer.appendChild(chip);
                });
                btnAddBulk.disabled = false;
                selectedCountSpan.textContent = selectedStudents.length;
            } else {
                selectedLabel.style.display = 'none';
                btnAddBulk.disabled = true;
                selectedCountSpan.textContent = '0';
            }
        }
    });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
