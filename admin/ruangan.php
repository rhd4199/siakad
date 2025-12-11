<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$title = 'Manajemen Ruangan';
$currentPage = 'ruangan';
$roleBasePath = '/admin';
$baseUrl = '/siakad';

// Mock Data Ruangan
$rooms = [
    [
        'id' => 1,
        'code' => 'R-01',
        'name' => 'Ruang Teori A',
        'capacity' => 20,
        'type' => 'Classroom',
        'facilities' => ['AC', 'Proyektor', 'Whiteboard'],
        'status' => 'active',
        'color' => 'primary'
    ],
    [
        'id' => 2,
        'code' => 'R-02',
        'name' => 'Lab Komputer 1',
        'capacity' => 15,
        'type' => 'Laboratory',
        'facilities' => ['AC', '15 PC', 'Internet', 'Proyektor'],
        'status' => 'active',
        'color' => 'info'
    ],
    [
        'id' => 3,
        'code' => 'R-03',
        'name' => 'Ruang Diskusi',
        'capacity' => 8,
        'type' => 'Discussion',
        'facilities' => ['AC', 'Smart TV', 'Round Table'],
        'status' => 'maintenance',
        'color' => 'warning'
    ]
];

ob_start();
?>

<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Manajemen Ruangan</h2>
            <p class="text-muted mb-0">Kelola daftar ruangan dan fasilitas kelas.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddRoom">
            <i class="bi bi-plus-lg me-2"></i>Tambah Ruangan
        </button>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100 overflow-hidden position-relative">
                <div class="card-body p-4 position-relative z-1">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-white bg-opacity-25 rounded-circle p-2 me-3">
                            <i class="bi bi-door-open fs-4 text-white"></i>
                        </div>
                        <h6 class="mb-0 text-white-50 text-uppercase letter-spacing-1">Total Ruangan</h6>
                    </div>
                    <h2 class="display-5 fw-bold mb-0">3</h2>
                </div>
                <i class="bi bi-building position-absolute end-0 bottom-0 display-1 text-white opacity-10 me-n4 mb-n2"></i>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-success-subtle rounded-circle p-2 me-3">
                            <i class="bi bi-check-lg fs-4 text-success"></i>
                        </div>
                        <h6 class="mb-0 text-muted text-uppercase letter-spacing-1">Ruangan Aktif</h6>
                    </div>
                    <h2 class="display-5 fw-bold mb-0 text-dark">2</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-warning-subtle rounded-circle p-2 me-3">
                            <i class="bi bi-tools fs-4 text-warning"></i>
                        </div>
                        <h6 class="mb-0 text-muted text-uppercase letter-spacing-1">Maintenance</h6>
                    </div>
                    <h2 class="display-5 fw-bold mb-0 text-dark">1</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Room List -->
    <div class="row g-4">
        <?php foreach ($rooms as $room): ?>
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-card transition-all">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-<?= $room['color'] ?>-subtle text-<?= $room['color'] ?> px-3 py-2 rounded-pill mb-2 fw-medium">
                                <?= $room['code'] ?>
                            </span>
                            <h5 class="fw-bold text-dark mb-1"><?= $room['name'] ?></h5>
                            <span class="text-muted small"><i class="bi bi-people me-1"></i> Kapasitas: <?= $room['capacity'] ?> Orang</span>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-icon btn-light rounded-circle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                                <li><a class="dropdown-item py-2" href="#" onclick="editRoom(<?= $room['id'] ?>)"><i class="bi bi-pencil me-2 text-warning"></i>Edit</a></li>
                                <li><a class="dropdown-item py-2" href="#"><i class="bi bi-calendar-check me-2 text-primary"></i>Lihat Jadwal</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2 text-danger" href="#"><i class="bi bi-trash me-2"></i>Hapus</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($room['facilities'] as $facility): ?>
                                <span class="badge bg-light text-secondary border fw-normal"><?= $facility ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <span class="badge rounded-pill <?= $room['status'] === 'active' ? 'bg-success' : 'bg-warning' ?>">
                            <?= ucfirst($room['status']) ?>
                        </span>
                        <small class="text-muted">Type: <?= $room['type'] ?></small>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Offcanvas Add Room -->
<div class="offcanvas offcanvas-end rounded-start-4 border-0" tabindex="-1" id="offcanvasAddRoom" style="width: 450px;">
    <div class="offcanvas-header bg-light border-bottom py-3">
        <h5 class="offcanvas-title fw-bold" id="offcanvasAddRoomLabel">
            <i class="bi bi-building-add me-2 text-primary"></i>Tambah Ruangan Baru
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-4">
        <form id="addRoomForm">
            <div class="mb-4 text-center">
                <div class="avatar-placeholder rounded-circle bg-primary bg-opacity-10 text-primary mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="bi bi-house-door fs-1"></i>
                </div>
                <h6 class="text-muted">Informasi Ruangan</h6>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="roomCode" placeholder="Kode Ruangan (Contoh: R-01)">
                <label for="roomCode">Kode Ruangan</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="roomName" placeholder="Nama Ruangan">
                <label for="roomName">Nama Ruangan</label>
            </div>

            <div class="row g-2 mb-3">
                <div class="col-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="roomCapacity" placeholder="Kapasitas">
                        <label for="roomCapacity">Kapasitas</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating">
                        <select class="form-select" id="roomType">
                            <option value="Classroom">Classroom</option>
                            <option value="Laboratory">Laboratory</option>
                            <option value="Discussion">Discussion</option>
                            <option value="Auditorium">Auditorium</option>
                        </select>
                        <label for="roomType">Tipe</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-medium mb-2">Fasilitas</label>
                <div class="d-flex flex-wrap gap-2">
                    <input type="checkbox" class="btn-check" id="fac_ac" autocomplete="off">
                    <label class="btn btn-outline-secondary btn-sm rounded-pill" for="fac_ac">AC</label>

                    <input type="checkbox" class="btn-check" id="fac_projector" autocomplete="off">
                    <label class="btn btn-outline-secondary btn-sm rounded-pill" for="fac_projector">Proyektor</label>

                    <input type="checkbox" class="btn-check" id="fac_whiteboard" autocomplete="off">
                    <label class="btn btn-outline-secondary btn-sm rounded-pill" for="fac_whiteboard">Whiteboard</label>

                    <input type="checkbox" class="btn-check" id="fac_wifi" autocomplete="off">
                    <label class="btn btn-outline-secondary btn-sm rounded-pill" for="fac_wifi">WiFi</label>

                    <input type="checkbox" class="btn-check" id="fac_pc" autocomplete="off">
                    <label class="btn btn-outline-secondary btn-sm rounded-pill" for="fac_pc">PC/Komputer</label>
                </div>
            </div>

            <div class="form-floating mb-4">
                <select class="form-select" id="roomStatus">
                    <option value="active">Active</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="inactive">Inactive</option>
                </select>
                <label for="roomStatus">Status</label>
            </div>

            <div class="d-grid">
                <button type="button" class="btn btn-primary btn-lg shadow-sm rounded-pill">Simpan Ruangan</button>
            </div>
        </form>
    </div>
</div>

<style>
.hover-card:hover {
    transform: translateY(-5px);
}
.transition-all {
    transition: all 0.3s ease;
}
.letter-spacing-1 {
    letter-spacing: 1px;
}
.btn-check:checked + .btn-outline-secondary {
    background-color: #0d6efd;
    color: white;
    border-color: #0d6efd;
}
</style>

<script>
function editRoom(id) {
    // Simulasi edit functionality
    const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddRoom'));
    document.querySelector('#offcanvasAddRoom .offcanvas-title').innerHTML = '<i class="bi bi-pencil-square me-2 text-primary"></i>Edit Ruangan';
    // Here you would populate the form with data
    offcanvas.show();
}
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
