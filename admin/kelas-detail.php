<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

// Get class ID from query string or default to 101
$class_id = isset($_GET['id']) ? $_GET['id'] : 101;

// Simulated Class Data (Single Class)
$class_data = [
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
    'progress' => 45, // Percentage of course completed
    'status' => 'active',
    'room' => 'Lab Komputer A',
    'start_date' => '10 Januari 2025',
    'end_date' => '10 April 2025',
    'description' => 'Kelas intensif Digital Marketing mencakup SEO, SEM, Social Media Marketing, dan Content Strategy.'
];

// Simulated Students Data
$students = [
    ['name' => 'Aditya Pratama', 'id' => 'ST-001', 'avatar' => 'AP', 'color' => 'primary', 'attendance' => 90, 'score' => 85, 'status' => 'active'],
    ['name' => 'Bunga Citra', 'id' => 'ST-002', 'avatar' => 'BC', 'color' => 'success', 'attendance' => 95, 'score' => 88, 'status' => 'active'],
    ['name' => 'Chandra Wijaya', 'id' => 'ST-003', 'avatar' => 'CW', 'color' => 'info', 'attendance' => 80, 'score' => 75, 'status' => 'warning'],
    ['name' => 'Diana Sari', 'id' => 'ST-004', 'avatar' => 'DS', 'color' => 'warning', 'attendance' => 100, 'score' => 92, 'status' => 'active'],
    ['name' => 'Erik Santoso', 'id' => 'ST-005', 'avatar' => 'ES', 'color' => 'danger', 'attendance' => 60, 'score' => 0, 'status' => 'inactive'],
];

// Simulated Schedule Data
$sessions = [
    ['date' => '2025-01-10', 'topic' => 'Pengenalan Digital Marketing', 'status' => 'completed', 'attendance' => '18/18'],
    ['date' => '2025-01-13', 'topic' => 'Dasar-dasar SEO', 'status' => 'completed', 'attendance' => '17/18'],
    ['date' => '2025-01-17', 'topic' => 'Keyword Research', 'status' => 'upcoming', 'attendance' => '-'],
    ['date' => '2025-01-20', 'topic' => 'On-Page SEO', 'status' => 'upcoming', 'attendance' => '-'],
];

$title        = 'Detail Kelas: ' . $class_data['code'];
$currentPage  = 'kelas';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

ob_start();
?>

<!-- Modal Edit Class -->
<div class="modal fade" id="editClassModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold">Edit Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editClassForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Program Pelatihan</label>
                            <select class="form-select" disabled>
                                <option selected><?= $class_data['program'] ?></option>
                            </select>
                            <div class="form-text extra-small">Program tidak dapat diubah setelah kelas dibuat.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Kode Kelas</label>
                            <input type="text" class="form-control" value="<?= $class_data['code'] ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nama Batch</label>
                            <input type="text" class="form-control" value="<?= $class_data['batch'] ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Instruktur</label>
                            <select class="form-select">
                                <option selected><?= $class_data['tutor'] ?></option>
                                <option>Sandhika Galih</option>
                                <option>Rio Purba</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Jadwal</label>
                            <input type="text" class="form-control" value="<?= $class_data['schedule'] ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Ruangan</label>
                            <input type="text" class="form-control" value="<?= $class_data['room'] ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Deskripsi</label>
                            <textarea class="form-control" rows="3"><?= $class_data['description'] ?></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Participant (Multi-select) -->
<div class="modal fade" id="addParticipantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0">
                <div>
                    <h5 class="modal-title fw-bold">Tambah Peserta</h5>
                    <p class="text-muted small mb-0">Cari dan tambahkan siswa ke kelas ini.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="position-relative mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-start-0" id="modalSearchInput" placeholder="Cari nama atau ID siswa..." autocomplete="off">
                    </div>
                    <div id="modalSearchResults" class="position-absolute w-100 bg-white shadow-sm border rounded-bottom mt-0 d-none" style="z-index: 1050; max-height: 200px; overflow-y: auto;">
                        <!-- Results injected here -->
                    </div>
                </div>

                <div class="mb-3">
                    <div class="small text-muted mb-2" id="modalSelectedLabel" style="display: none;">Siswa Dipilih:</div>
                    <div id="modalSelectedContainer" class="d-flex flex-wrap gap-1" style="min-height: 0px;">
                        <!-- Selected chips -->
                    </div>
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary" id="modalBtnAdd" disabled>
                        Tambahkan <span id="modalSelectedCount">0</span> Siswa
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mock Data for Search
        const availableStudents = [
            { id: 'ST-006', name: 'Fajar Nugraha', email: 'fajar@example.com', avatar: 'FN', color: 'primary' },
            { id: 'ST-007', name: 'Gita Pertiwi', email: 'gita@example.com', avatar: 'GP', color: 'success' },
            { id: 'ST-008', name: 'Hadi Wijaya', email: 'hadi@example.com', avatar: 'HW', color: 'danger' },
            { id: 'ST-009', name: 'Indah Sari', email: 'indah@example.com', avatar: 'IS', color: 'warning' },
            { id: 'ST-010', name: 'Joko Susilo', email: 'joko@example.com', avatar: 'JS', color: 'info' },
        ];

        let selected = [];
        const searchInput = document.getElementById('modalSearchInput');
        const searchResults = document.getElementById('modalSearchResults');
        const selectedContainer = document.getElementById('modalSelectedContainer');
        const selectedLabel = document.getElementById('modalSelectedLabel');
        const btnAdd = document.getElementById('modalBtnAdd');
        const countSpan = document.getElementById('modalSelectedCount');

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            if (query.length < 1) {
                searchResults.classList.add('d-none');
                return;
            }

            const matches = availableStudents.filter(s => 
                !selected.find(sel => sel.id === s.id) && 
                (s.name.toLowerCase().includes(query) || s.id.toLowerCase().includes(query))
            );

            if (matches.length > 0) {
                let html = '<div class="list-group list-group-flush">';
                matches.forEach(s => {
                    html += `
                        <button type="button" class="list-group-item list-group-item-action px-3 py-2 small" onclick="selectModalStudent('${s.id}')">
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

        window.selectModalStudent = function(id) {
            const student = availableStudents.find(s => s.id === id);
            if (student) {
                selected.push(student);
                renderModalSelected();
                searchInput.value = '';
                searchResults.classList.add('d-none');
                searchInput.focus();
            }
        };

        window.removeModalStudent = function(id) {
            selected = selected.filter(s => s.id !== id);
            renderModalSelected();
        };

        function renderModalSelected() {
            selectedContainer.innerHTML = '';
            if (selected.length > 0) {
                selectedLabel.style.display = 'block';
                selected.forEach(s => {
                    const chip = document.createElement('div');
                    chip.className = 'badge bg-light text-dark border d-flex align-items-center p-2 pe-2';
                    chip.innerHTML = `
                        <span class="fw-normal me-2">${s.name}</span>
                        <i class="bi bi-x text-muted cursor-pointer" onclick="removeModalStudent('${s.id}')" style="cursor:pointer"></i>
                    `;
                    selectedContainer.appendChild(chip);
                });
                btnAdd.disabled = false;
                countSpan.textContent = selected.length;
            } else {
                selectedLabel.style.display = 'none';
                btnAdd.disabled = true;
                countSpan.textContent = '0';
            }
        }

        // Hide results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('d-none');
            }
        });
    });
</script>

<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="<?= $roleBasePath ?>/kelas.php" class="text-decoration-none">Manajemen Kelas</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $class_data['code'] ?></li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h2 class="fw-bold mb-0"><?= $class_data['program'] ?></h2>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill"><?= $class_data['code'] ?></span>
                <?php if ($class_data['status'] == 'active'): ?>
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Berjalan</span>
                <?php else: ?>
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">Akan Datang</span>
                <?php endif; ?>
            </div>
            <p class="text-muted mb-0"><?= $class_data['batch'] ?> &bull; <?= $class_data['schedule'] ?></p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#editClassModal">
                <i class="bi bi-pencil me-1"></i> Edit Kelas
            </button>
            <button class="btn btn-outline-warning btn-sm rounded-pill" onclick="confirm('Nonaktifkan kelas ini?')">
                <i class="bi bi-slash-circle me-1"></i> Nonaktifkan
            </button>
        </div>
    </div>
</div>

<!-- Overview Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar-sm bg-primary-subtle text-primary rounded-circle me-2">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <span class="text-muted small">Total Peserta</span>
                </div>
                <h3 class="fw-bold mb-0"><?= $class_data['students_count'] ?> <span class="text-muted fs-6 fw-normal">/ <?= $class_data['capacity'] ?></span></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar-sm bg-success-subtle text-success rounded-circle me-2">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <span class="text-muted small">Kehadiran Rata-rata</span>
                </div>
                <h3 class="fw-bold mb-0">92%</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar-sm bg-info-subtle text-info rounded-circle me-2">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <span class="text-muted small">Materi Selesai</span>
                </div>
                <h3 class="fw-bold mb-0">2 <span class="text-muted fs-6 fw-normal">/ 12 Sesi</span></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar-sm bg-warning-subtle text-warning rounded-circle me-2">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <span class="text-muted small">Instruktur</span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="avatar-xs bg-<?= $class_data['tutor_color'] ?>-subtle text-<?= $class_data['tutor_color'] ?> rounded-circle me-2" style="width:24px;height:24px;display:flex;align-items:center;justify-content:center;font-size:0.7rem;">
                        <?= $class_data['tutor_avatar'] ?>
                    </div>
                    <div class="fw-semibold text-truncate"><?= $class_data['tutor'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Main Content -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <ul class="nav nav-tabs card-header-tabs" id="classTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="peserta-tab" data-bs-toggle="tab" data-bs-target="#peserta" type="button" role="tab">Peserta (<?= count($students) ?>)</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="jadwal-tab" data-bs-toggle="tab" data-bs-target="#jadwal" type="button" role="tab">Jadwal Sesi</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="nilai-tab" data-bs-toggle="tab" data-bs-target="#nilai" type="button" role="tab">Nilai & Evaluasi</button>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content" id="classTabsContent">
                    <!-- Tab Peserta -->
                    <div class="tab-pane fade show active" id="peserta" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="input-group input-group-sm w-50">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control border-start-0 bg-light" placeholder="Cari peserta...">
                            </div>
                            <button class="btn btn-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#addParticipantModal">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Peserta
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Peserta</th>
                                        <th class="text-center">Kehadiran</th>
                                        <th class="text-center">Nilai Rata-rata</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-<?= $student['color'] ?>-subtle text-<?= $student['color'] ?> rounded-circle me-3" style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:0.8rem;">
                                                    <?= $student['avatar'] ?>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold"><?= $student['name'] ?></div>
                                                    <div class="small text-muted"><?= $student['id'] ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?= $student['attendance'] ?>%"></div>
                                            </div>
                                            <div class="small text-muted mt-1"><?= $student['attendance'] ?>%</div>
                                        </td>
                                        <td class="text-center fw-bold"><?= $student['score'] > 0 ? $student['score'] : '-' ?></td>
                                        <td class="text-center">
                                            <?php if ($student['status'] == 'active'): ?>
                                                <span class="badge bg-success-subtle text-success rounded-pill" style="font-size: 0.7rem;">Aktif</span>
                                            <?php elseif ($student['status'] == 'warning'): ?>
                                                <span class="badge bg-warning-subtle text-warning rounded-pill" style="font-size: 0.7rem;">Perhatian</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill" style="font-size: 0.7rem;">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light text-muted" title="Detail"><i class="bi bi-three-dots-vertical"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab Jadwal -->
                    <div class="tab-pane fade" id="jadwal" role="tabpanel">
                        <div class="timeline">
                            <?php foreach ($sessions as $index => $session): ?>
                            <div class="d-flex gap-3 mb-4">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="rounded-circle border d-flex align-items-center justify-content-center bg-<?= $session['status'] == 'completed' ? 'primary' : 'light' ?> text-<?= $session['status'] == 'completed' ? 'white' : 'muted' ?>" style="width: 32px; height: 32px;">
                                        <?= $index + 1 ?>
                                    </div>
                                    <?php if ($index < count($sessions) - 1): ?>
                                    <div class="h-100 border-start my-1"></div>
                                    <?php endif; ?>
                                </div>
                                <div class="card flex-grow-1 border-0 shadow-sm bg-light">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="fw-bold mb-1"><?= $session['topic'] ?></h6>
                                                <div class="text-muted small"><i class="bi bi-calendar-event me-1"></i> <?= $session['date'] ?></div>
                                            </div>
                                            <?php if ($session['status'] == 'completed'): ?>
                                                <span class="badge bg-success-subtle text-success rounded-pill">Selesai</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill">Akan Datang</span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($session['status'] == 'completed'): ?>
                                        <div class="mt-2 small text-muted">
                                            <i class="bi bi-people me-1"></i> Hadir: <?= $session['attendance'] ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Tab Nilai -->
                    <div class="tab-pane fade" id="nilai" role="tabpanel">
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-bar-chart-line fs-1 mb-3 d-block"></i>
                            <h5>Belum ada data nilai</h5>
                            <p class="small">Data nilai akan muncul setelah ujian atau tugas diberikan.</p>
                            <button class="btn btn-outline-primary btn-sm rounded-pill">Buat Penilaian Baru</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Info & Actions -->
    <div class="col-lg-4">
        <!-- Class Info Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">Informasi Kelas</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted small">Ruangan</span>
                        <span class="fw-semibold small"><?= $class_data['room'] ?></span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted small">Mulai</span>
                        <span class="fw-semibold small"><?= $class_data['start_date'] ?></span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted small">Selesai</span>
                        <span class="fw-semibold small"><?= $class_data['end_date'] ?></span>
                    </li>
                    <li class="list-group-item px-0">
                        <span class="text-muted small d-block mb-1">Deskripsi</span>
                        <p class="small mb-0 text-secondary"><?= $class_data['description'] ?></p>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Progress Card -->
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Progress Kelas</h6>
                <div class="progress bg-white bg-opacity-25 mb-2" style="height: 10px;">
                    <div class="progress-bar bg-white" role="progressbar" style="width: <?= $class_data['progress'] ?>%"></div>
                </div>
                <div class="d-flex justify-content-between small opacity-75">
                    <span><?= $class_data['progress'] ?>% Selesai</span>
                    <span>12 Sesi Total</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>