<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$user         = current_user();
$title        = 'Manajemen Peserta';
$currentPage  = 'peserta';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

// Simulated Student Data
$students = [
    [
        'id' => 'ST-001',
        'name' => 'Aditya Pratama',
        'email' => 'aditya.p@example.com',
        'phone' => '0812-3456-7890',
        'program' => 'Web Development',
        'class_code' => 'WD-03',
        'join_date' => '2025-01-15',
        'status' => 'active',
        'avatar_color' => 'primary',
        'initials' => 'AP',
        'history' => [
            ['class' => 'Web Development (Batch 1)', 'status' => 'Lulus', 'score' => 88],
            ['class' => 'Dasar Pemrograman', 'status' => 'Lulus', 'score' => 92]
        ]
    ],
    [
        'id' => 'ST-002',
        'name' => 'Bunga Citra',
        'email' => 'bunga.citra@example.com',
        'phone' => '0813-4567-8901',
        'program' => 'Digital Marketing',
        'class_code' => 'DM-01',
        'join_date' => '2025-01-20',
        'status' => 'active',
        'avatar_color' => 'success',
        'initials' => 'BC',
        'history' => [
            ['class' => 'Digital Marketing Fund.', 'status' => 'Berjalan', 'score' => '-']
        ]
    ],
    [
        'id' => 'ST-003',
        'name' => 'Chandra Wijaya',
        'email' => 'chandra.w@example.com',
        'phone' => '0814-5678-9012',
        'program' => 'Graphic Design',
        'class_code' => 'GD-02',
        'join_date' => '2025-02-01',
        'status' => 'active',
        'avatar_color' => 'danger',
        'initials' => 'CW',
        'history' => []
    ],
    [
        'id' => 'ST-004',
        'name' => 'Diana Sari',
        'email' => 'diana.sari@example.com',
        'phone' => '0815-6789-0123',
        'program' => 'Office Automation',
        'class_code' => 'OM-05',
        'join_date' => '2025-02-10',
        'status' => 'inactive',
        'avatar_color' => 'warning',
        'initials' => 'DS',
        'history' => []
    ]
];

ob_start();
?>

<style>
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .avatar-profile-lg {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 2.5rem;
        border: 4px solid #fff;
    }
    .id-card-container {
        width: 100%;
        max-width: 400px;
        height: 250px;
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        border-radius: 16px;
        position: relative;
        overflow: hidden;
        color: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        margin: 0 auto;
    }
    .id-card-pattern {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-image: radial-gradient(circle at 10% 20%, rgba(255,255,255,0.1) 0%, transparent 20%),
                          radial-gradient(circle at 90% 80%, rgba(255,255,255,0.1) 0%, transparent 20%);
    }
    .id-card-header {
        padding: 20px 24px 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .id-card-body {
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .id-photo {
        width: 80px;
        height: 80px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0d6efd;
        font-weight: bold;
        font-size: 1.5rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .id-details h5 {
        font-size: 1.1rem;
        margin-bottom: 4px;
        font-weight: 700;
    }
    .id-details p {
        font-size: 0.8rem;
        margin-bottom: 2px;
        opacity: 0.9;
    }
    .id-card-footer {
        position: absolute;
        bottom: 15px;
        right: 24px;
        text-align: right;
    }
    .barcode {
        height: 24px;
        background: white;
        padding: 2px 4px;
        display: inline-block;
        border-radius: 2px;
        opacity: 0.9;
    }
</style>

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1">Manajemen Peserta</h4>
        <p class="text-muted small mb-0">
            Database siswa, riwayat belajar, dan cetak kartu.
        </p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <button class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddStudent">
            <i class="bi bi-plus-lg me-1"></i> Tambah Peserta
        </button>
    </div>
</div>

<!-- Filter Bar -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 bg-light" placeholder="Cari nama atau ID siswa...">
                </div>
            </div>
            <div class="col-md-8 text-md-end">
                <div class="d-flex justify-content-md-end gap-2">
                    <select class="form-select form-select-sm w-auto bg-light border-0">
                        <option selected>Semua Program</option>
                        <option>Web Dev</option>
                        <option>Design</option>
                    </select>
                    <select class="form-select form-select-sm w-auto bg-light border-0">
                        <option selected>Status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                    <button class="btn btn-light btn-sm border-0 text-muted" title="Export Data">
                        <i class="bi bi-download"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table List -->
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0 table-hover">
            <thead class="bg-light">
                <tr class="text-muted small text-uppercase">
                    <th class="ps-4 py-3 border-0 rounded-start">Nama Peserta</th>
                    <th class="border-0">Kontak</th>
                    <th class="border-0">Program & Kelas</th>
                    <th class="border-0">Bergabung</th>
                    <th class="border-0">Status</th>
                    <th class="border-0 rounded-end text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle bg-<?= $student['avatar_color'] ?>-subtle text-<?= $student['avatar_color'] ?> me-3">
                                <?= $student['initials'] ?>
                            </div>
                            <div>
                                <div class="fw-bold text-dark mb-0"><?= $student['name'] ?></div>
                                <div class="extra-small text-muted">ID: <?= $student['id'] ?></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="small"><i class="bi bi-envelope me-2 text-muted"></i><?= $student['email'] ?></div>
                        <div class="small text-muted"><i class="bi bi-telephone me-2 text-muted"></i><?= $student['phone'] ?></div>
                    </td>
                    <td>
                        <div class="badge bg-light text-dark border fw-normal mb-1"><?= $student['program'] ?></div>
                        <div class="extra-small text-muted">Kelas: <?= $student['class_code'] ?></div>
                    </td>
                    <td class="small text-muted">
                        <?= $student['join_date'] ?>
                    </td>
                    <td>
                        <?php if ($student['status'] === 'active'): ?>
                            <span class="badge bg-success-subtle text-success rounded-pill px-2">Active</span>
                        <?php else: ?>
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end pe-4">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-light text-primary" 
                                    onclick="showProfile('<?= $student['name'] ?>', '<?= $student['id'] ?>', '<?= $student['avatar_color'] ?>', '<?= $student['initials'] ?>')"
                                    title="Lihat Profil">
                                <i class="bi bi-person-lines-fill"></i>
                            </button>
                            <button class="btn btn-sm btn-light text-dark" 
                                    onclick="showIdCard('<?= $student['name'] ?>', '<?= $student['id'] ?>', '<?= $student['program'] ?>')"
                                    title="Kartu Peserta">
                                <i class="bi bi-card-heading"></i>
                            </button>
                            <button class="btn btn-sm btn-light text-muted" title="Edit"
                                    onclick="showEditStudent('<?= $student['id'] ?>', '<?= $student['name'] ?>', '<?= $student['email'] ?>', '<?= $student['phone'] ?>', '<?= $student['program'] ?>')">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white border-top-0 py-3">
        <nav>
            <ul class="pagination pagination-sm justify-content-center mb-0">
                <li class="page-item disabled"><a class="page-link border-0" href="#"><i class="bi bi-chevron-left"></i></a></li>
                <li class="page-item active"><a class="page-link border-0 rounded-circle bg-primary text-white mx-1" href="#">1</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-circle text-muted mx-1" href="#">2</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-circle text-muted mx-1" href="#">3</a></li>
                <li class="page-item"><a class="page-link border-0" href="#"><i class="bi bi-chevron-right"></i></a></li>
            </ul>
        </nav>
    </div>
</div>

<!-- Offcanvas Add Student -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddStudent" aria-labelledby="offcanvasAddStudentLabel" style="width: 500px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold" id="offcanvasAddStudentLabel">Registrasi Peserta Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form>
            <div class="row g-3">
                <div class="col-12 text-center mb-3">
                    <div class="dashed-circle mx-auto mb-2" style="width: 80px; height: 80px; border-radius: 50%; border: 2px dashed #dee2e6; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-camera text-muted fs-4"></i>
                    </div>
                    <button type="button" class="btn btn-link btn-sm text-decoration-none">Upload Foto</button>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Nama Depan</label>
                    <input type="text" class="form-control" placeholder="Nama Depan">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Nama Belakang</label>
                    <input type="text" class="form-control" placeholder="Nama Belakang">
                </div>
                
                <div class="col-12">
                    <label class="form-label small fw-bold">Email</label>
                    <input type="email" class="form-control" placeholder="nama@email.com">
                </div>
                
                <div class="col-12">
                    <label class="form-label small fw-bold">No. WhatsApp</label>
                    <input type="text" class="form-control" placeholder="08...">
                </div>
                
                
                <div class="col-12">
                    <label class="form-label small fw-bold">Catatan / Referensi</label>
                    <textarea class="form-control" rows="3" placeholder="Info tambahan..."></textarea>
                </div>
            </div>
        </form>
    </div>
    <div class="offcanvas-footer p-3 border-top bg-light">
        <div class="d-grid gap-2">
            <button type="button" class="btn btn-primary">Simpan Data Peserta</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Batal</button>
        </div>
    </div>
</div>

<!-- Offcanvas Profile View -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasProfile" aria-labelledby="offcanvasProfileLabel" style="width: 500px;">
    <div class="offcanvas-header border-bottom bg-light">
        <h5 class="offcanvas-title fw-bold" id="offcanvasProfileLabel">Profil Peserta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="text-center bg-light pb-4 pt-2 border-bottom">
            <div id="profileAvatar" class="avatar-profile-lg mx-auto shadow-sm mb-3 bg-primary text-white">AP</div>
            <h4 class="fw-bold mb-1" id="profileName">Aditya Pratama</h4>
            <p class="text-muted mb-3" id="profileId">ID: ST-001</p>
            
            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-sm btn-white border shadow-sm"><i class="bi bi-envelope me-1"></i> Email</button>
                <button class="btn btn-sm btn-white border shadow-sm"><i class="bi bi-whatsapp me-1"></i> Chat</button>
                <button class="btn btn-sm btn-outline-primary rounded-pill px-3">Edit Profil</button>
            </div>
        </div>
        
        <div class="p-3">
            <ul class="nav nav-tabs nav-fill mb-3" id="profileTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active small" data-bs-toggle="tab" data-bs-target="#tab-history">Riwayat Kelas</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link small" data-bs-toggle="tab" data-bs-target="#tab-exams">Hasil Ujian</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link small" data-bs-toggle="tab" data-bs-target="#tab-docs">Dokumen</button>
                </li>
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-history">
                    <div class="timeline p-2">
                        <!-- Simulated History -->
                        <div class="d-flex gap-3 mb-3">
                            <div class="d-flex flex-column align-items-center">
                                <div class="badge rounded-circle bg-success p-1"><i class="bi bi-check"></i></div>
                                <div class="h-100 border-start my-1"></div>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">Web Development (Batch 1)</div>
                                <div class="small text-muted">Lulus • Nilai Akhir: 88</div>
                                <div class="extra-small text-muted">Jan 2024 - Mar 2024</div>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="d-flex flex-column align-items-center">
                                <div class="badge rounded-circle bg-success p-1"><i class="bi bi-check"></i></div>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">Dasar Pemrograman</div>
                                <div class="small text-muted">Lulus • Nilai Akhir: 92</div>
                                <div class="extra-small text-muted">Des 2023</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-exams">
                    <div class="alert alert-light border text-center text-muted small">
                        Belum ada data ujian terbaru.
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-docs">
                    <div class="list-group list-group-flush small">
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-file-pdf text-danger me-2"></i>CV_Aditya.pdf</span>
                            <i class="bi bi-download text-muted"></i>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-file-image text-primary me-2"></i>Foto_Profil.jpg</span>
                            <i class="bi bi-download text-muted"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal ID Card -->
<div class="modal fade" id="modalIdCard" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Kartu Tanda Peserta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center bg-light">
                <div class="id-card-container text-start mx-auto mb-3">
                    <div class="id-card-pattern"></div>
                    <div class="id-card-header position-relative z-1">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-mortarboard-fill fs-4"></i>
                            <div style="line-height: 1.1;">
                                <div class="fw-bold small">SIAKAD LPK</div>
                                <div style="font-size: 0.6rem; opacity: 0.8;">OFFICIAL MEMBER CARD</div>
                            </div>
                        </div>
                        <div class="fw-bold" style="letter-spacing: 2px;">2025</div>
                    </div>
                    <div class="id-card-body position-relative z-1">
                        <div class="id-photo bg-white text-primary shadow-sm" id="idCardPhoto">
                            <!-- JS will put initials here -->
                        </div>
                        <div class="id-details text-white">
                            <h5 id="idCardName">Student Name</h5>
                            <p id="idCardProgram">Program Name</p>
                            <p id="idCardId" class="mt-2 font-monospace bg-white bg-opacity-25 px-2 rounded d-inline-block">ID: 00000</p>
                        </div>
                    </div>
                    <div class="id-card-footer position-relative z-1">
                         <div class="barcode text-dark px-1 extra-small">||| || ||| |||||</div>
                    </div>
                </div>
                
                <p class="text-muted small mb-0">
                    Kartu ini dapat digunakan untuk absensi dan akses fasilitas.
                </p>
            </div>
            <div class="modal-footer border-top-0 pt-0 bg-light justify-content-center">
                <button type="button" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-printer me-1"></i> Cetak Kartu
                </button>
                <button type="button" class="btn btn-primary btn-sm">
                    <i class="bi bi-download me-1"></i> Download PDF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas Edit Student -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditStudent" aria-labelledby="offcanvasEditStudentLabel" style="width: 500px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold" id="offcanvasEditStudentLabel">Edit Data Peserta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editStudentForm">
            <div class="row g-3">
                <div class="col-12 text-center mb-3">
                    <div class="dashed-circle mx-auto mb-2" style="width: 80px; height: 80px; border-radius: 50%; border: 2px dashed #dee2e6; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-person-circle text-muted fs-1"></i>
                    </div>
                    <button type="button" class="btn btn-link btn-sm text-decoration-none">Ubah Foto</button>
                </div>
                
                <div class="col-12">
                     <label class="form-label small fw-bold">ID Peserta</label>
                     <input type="text" class="form-control bg-light" id="editId" readonly>
                </div>

                <div class="col-12">
                    <label class="form-label small fw-bold">Nama Lengkap</label>
                    <input type="text" class="form-control" id="editName" placeholder="Nama Lengkap">
                </div>
                
                <div class="col-12">
                    <label class="form-label small fw-bold">Email</label>
                    <input type="email" class="form-control" id="editEmail" placeholder="nama@email.com">
                </div>
                
                <div class="col-12">
                    <label class="form-label small fw-bold">No. WhatsApp</label>
                    <input type="text" class="form-control" id="editPhone" placeholder="08...">
                </div>
                
                <div class="col-12">
                    <label class="form-label small fw-bold">Program</label>
                    <select class="form-select" id="editProgram">
                        <option>Web Development</option>
                        <option>Digital Marketing</option>
                        <option>Graphic Design</option>
                        <option>Office Automation</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label small fw-bold">Status</label>
                    <select class="form-select" id="editStatus">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="offcanvas-footer p-3 border-top bg-light">
        <div class="d-grid gap-2">
            <button type="button" class="btn btn-primary">Simpan Perubahan</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Batal</button>
        </div>
    </div>
</div>

<script>
    function showEditStudent(id, name, email, phone, program) {
        document.getElementById('editId').value = id;
        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;
        document.getElementById('editPhone').value = phone;
        document.getElementById('editProgram').value = program;
        
        const bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasEditStudent'));
        bsOffcanvas.show();
    }

    function showProfile(name, id, color, initials) {
        document.getElementById('profileName').textContent = name;
        document.getElementById('profileId').textContent = 'ID: ' + id;
        
        const avatar = document.getElementById('profileAvatar');
        avatar.className = `avatar-profile-lg mx-auto shadow-sm mb-3 bg-${color} text-white`;
        avatar.textContent = initials;
        
        const bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasProfile'));
        bsOffcanvas.show();
    }

    function showIdCard(name, id, program) {
        document.getElementById('idCardName').textContent = name;
        document.getElementById('idCardId').textContent = 'ID: ' + id;
        document.getElementById('idCardProgram').textContent = program;
        
        const initials = name.match(/(\b\S)?/g).join("").match(/(^\S|\S$)?/g).join("").toUpperCase();
        document.getElementById('idCardPhoto').textContent = initials;

        const bsModal = new bootstrap.Modal(document.getElementById('modalIdCard'));
        bsModal.show();
    }
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
