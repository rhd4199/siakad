<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$user         = current_user();
$title        = 'Manajemen Instruktur';
$currentPage  = 'instruktur';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

// Simulated Tutor Data
$tutors = [
    [
        'id' => 1,
        'name' => 'Eko Kurniawan',
        'specialty' => 'Web Development',
        'role' => 'Senior Instructor',
        'email' => 'eko.kurniawan@example.com',
        'phone' => '0812-3456-7890',
        'status' => 'active',
        'rating' => 4.9,
        'students' => 120,
        'avatar_color' => 'primary',
        'initials' => 'EK',
        'bio' => 'Full Stack Developer dengan pengalaman lebih dari 10 tahun. Spesialis di ekosistem JavaScript dan PHP Modern. Suka berbagi ilmu dan berkontribusi di open source.',
        'skills' => ['PHP', 'Laravel', 'React', 'Node.js', 'DevOps'],
        'education' => [
            ['degree' => 'S2 Teknik Informatika', 'school' => 'Institut Teknologi Bandung', 'year' => '2015 - 2017'],
            ['degree' => 'S1 Ilmu Komputer', 'school' => 'Universitas Indonesia', 'year' => '2010 - 2014']
        ],
        'experience' => [
            ['role' => 'Principal Engineer', 'company' => 'Tech Unicorn ID', 'year' => '2019 - Sekarang'],
            ['role' => 'Senior Web Developer', 'company' => 'Digital Agency', 'year' => '2015 - 2019']
        ]
    ],
    [
        'id' => 2,
        'name' => 'Sandhika Galih',
        'specialty' => 'Frontend Expert',
        'role' => 'Lead Instructor',
        'email' => 'sandhika@example.com',
        'phone' => '0813-4567-8901',
        'status' => 'active',
        'rating' => 5.0,
        'students' => 250,
        'avatar_color' => 'success',
        'initials' => 'SG',
        'bio' => 'Dosen dan Content Creator edukasi pemrograman web. Memiliki passion tinggi dalam mengajar teknologi frontend terbaru.',
        'skills' => ['HTML5/CSS3', 'JavaScript', 'Vue.js', 'Tailwind', 'UI Design'],
        'education' => [
            ['degree' => 'S2 Pendidikan Komputer', 'school' => 'Universitas Pendidikan Indonesia', 'year' => '2014 - 2016']
        ],
        'experience' => [
            ['role' => 'Dosen Tetap', 'company' => 'Universitas Pasundan', 'year' => '2016 - Sekarang'],
            ['role' => 'Frontend Architect', 'company' => 'Freelance', 'year' => '2014 - 2016']
        ]
    ],
    [
        'id' => 3,
        'name' => 'Rio Purba',
        'specialty' => 'UI/UX Design',
        'role' => 'Design Mentor',
        'email' => 'rio.purba@example.com',
        'phone' => '0814-5678-9012',
        'status' => 'active',
        'rating' => 4.8,
        'students' => 180,
        'avatar_color' => 'info',
        'initials' => 'RP',
        'bio' => 'UI/UX Designer yang fokus pada User Centered Design. Berpengalaman menangani klien internasional dan membangun produk digital.',
        'skills' => ['Figma', 'Adobe XD', 'User Research', 'Prototyping', 'Design System'],
        'education' => [
            ['degree' => 'S1 Desain Komunikasi Visual', 'school' => 'Universitas Trisakti', 'year' => '2011 - 2015']
        ],
        'experience' => [
            ['role' => 'Head of Design', 'company' => 'Creative Studio', 'year' => '2018 - Sekarang'],
            ['role' => 'UI Designer', 'company' => 'Startup Indo', 'year' => '2015 - 2018']
        ]
    ],
    [
        'id' => 4,
        'name' => 'Budi Santoso',
        'specialty' => 'Office Automation',
        'role' => 'Instructor',
        'email' => 'budi.santoso@example.com',
        'phone' => '0815-6789-0123',
        'status' => 'inactive',
        'rating' => 4.5,
        'students' => 90,
        'avatar_color' => 'warning',
        'initials' => 'BS',
        'bio' => 'Praktisi administrasi perkantoran profesional. Ahli dalam penggunaan Microsoft Office Suite untuk efisiensi bisnis.',
        'skills' => ['Microsoft Excel', 'VBA', 'PowerPoint', 'Google Workspace'],
        'education' => [
            ['degree' => 'D3 Administrasi Perkantoran', 'school' => 'Politeknik Negeri Jakarta', 'year' => '2009 - 2012']
        ],
        'experience' => [
            ['role' => 'Office Manager', 'company' => 'Corporate Tbk', 'year' => '2015 - 2023'],
            ['role' => 'Admin Staff', 'company' => 'Retail Group', 'year' => '2012 - 2015']
        ]
    ]
];

// Stats Calculation
$total_tutors = count($tutors);
$active_tutors = count(array_filter($tutors, fn($t) => $t['status'] === 'active'));
$total_students_handled = array_sum(array_column($tutors, 'students'));

ob_start();
?>

<style>
    .avatar-circle-lg {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 700;
        border: 4px solid #fff;
    }
    .tutor-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .tutor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }
    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        border: 2px solid #fff;
    }
    .status-badge-absolute {
        position: absolute;
        bottom: 2px;
        right: 2px;
    }
    
    /* Cool Offcanvas Styles */
    .offcanvas-wide {
        width: 600px !important;
    }
    @media (max-width: 768px) {
        .offcanvas-wide {
            width: 100% !important;
        }
    }
    .profile-cover {
        height: 150px;
        background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
        position: relative;
    }
    .profile-avatar-container {
        position: absolute;
        bottom: -50px;
        left: 30px;
        z-index: 2;
    }
    .avatar-profile-xl {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 800;
        border: 5px solid #fff;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
    }
    .dashed-upload {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 2px dashed #dee2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .dashed-upload:hover {
        border-color: #0d6efd;
        background-color: #f8f9fa;
        color: #0d6efd;
    }
    
    /* Timeline Styles */
    .timeline-item {
        position: relative;
        padding-left: 30px;
        padding-bottom: 25px;
        border-left: 2px solid #e9ecef;
    }
    .timeline-item:last-child {
        border-left: 2px solid transparent;
        padding-bottom: 0;
    }
    .timeline-dot {
        position: absolute;
        left: -6px;
        top: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #0d6efd;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #0d6efd;
    }
    
    /* ID Card Tutor Styles */
    .id-card-tutor {
        width: 100%;
        max-width: 350px;
        height: 520px;
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        position: relative;
        margin: 0 auto;
    }
    .id-header-bg {
        height: 180px;
        background: linear-gradient(45deg, #1e1e2f 0%, #2c2c44 100%);
        position: relative;
        overflow: hidden;
    }
    .id-header-bg::before {
        content: '';
        position: absolute;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 10%, transparent 10%);
        background-size: 20px 20px;
        transform: rotate(45deg);
    }
    .id-avatar-main {
        width: 140px;
        height: 140px;
        background: #fff;
        border-radius: 15px;
        position: absolute;
        top: 60px;
        left: 50%;
        transform: translateX(-50%);
        padding: 5px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        z-index: 2;
    }
    .id-avatar-inner {
        width: 100%;
        height: 100%;
        background: #e9ecef;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: bold;
        color: #495057;
    }
    .id-content {
        padding-top: 80px;
        text-align: center;
        padding-bottom: 20px;
    }
    .id-role-badge {
        background: #0d6efd;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .id-qrcode {
        margin-top: 20px;
        opacity: 0.8;
    }
    .skill-pill {
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-right: 5px;
        margin-bottom: 5px;
        display: inline-block;
    }
</style>

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1">Data Instruktur</h4>
        <p class="text-muted small mb-0">
            Kelola pengajar, spesialisasi, dan performa mengajar.
        </p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <button class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddTutor">
            <i class="bi bi-plus-lg me-1"></i> Tambah Instruktur
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white overflow-hidden h-100">
            <div class="card-body position-relative z-1">
                <div class="fs-1 fw-bold mb-1"><?= $total_tutors ?></div>
                <div class="small opacity-75">Total Instruktur</div>
            </div>
            <i class="bi bi-person-video3 position-absolute text-white opacity-25" style="font-size: 5rem; bottom: -1rem; right: -1rem;"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white overflow-hidden h-100">
            <div class="card-body position-relative z-1">
                <div class="fs-1 fw-bold mb-1"><?= $active_tutors ?></div>
                <div class="small opacity-75">Instruktur Aktif Mengajar</div>
            </div>
            <i class="bi bi-check-circle position-absolute text-white opacity-25" style="font-size: 5rem; bottom: -1rem; right: -1rem;"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-info text-white overflow-hidden h-100">
            <div class="card-body position-relative z-1">
                <div class="fs-1 fw-bold mb-1"><?= $total_students_handled ?></div>
                <div class="small opacity-75">Total Siswa Diampu</div>
            </div>
            <i class="bi bi-mortarboard-fill position-absolute text-white opacity-25" style="font-size: 5rem; bottom: -1rem; right: -1rem;"></i>
        </div>
    </div>
</div>

<!-- Filter & Search -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 bg-light" placeholder="Cari instruktur...">
                </div>
            </div>
            <div class="col-md-8 text-md-end">
                <div class="d-flex justify-content-md-end gap-2">
                    <select class="form-select form-select-sm w-auto bg-light border-0">
                        <option selected>Semua Spesialisasi</option>
                        <option>Web Development</option>
                        <option>Design</option>
                        <option>Marketing</option>
                    </select>
                    <select class="form-select form-select-sm w-auto bg-light border-0">
                        <option selected>Status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tutors Grid -->
<div class="row g-4">
    <?php foreach ($tutors as $tutor): ?>
    <div class="col-md-6 col-xl-3">
        <div class="card tutor-card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
                <div class="position-relative d-inline-block mb-3">
                    <div class="avatar-circle-lg bg-<?= $tutor['avatar_color'] ?>-subtle text-<?= $tutor['avatar_color'] ?> mx-auto shadow-sm">
                        <?= $tutor['initials'] ?>
                    </div>
                    <?php if ($tutor['status'] === 'active'): ?>
                        <span class="status-dot bg-success status-badge-absolute" title="Active"></span>
                    <?php else: ?>
                        <span class="status-dot bg-secondary status-badge-absolute" title="Inactive"></span>
                    <?php endif; ?>
                </div>
                
                <h5 class="fw-bold mb-1"><?= $tutor['name'] ?></h5>
                <p class="text-muted small mb-3"><?= $tutor['specialty'] ?></p>
                
                <div class="d-flex justify-content-center gap-2 mb-4">
                    <span class="badge bg-light text-dark border fw-normal">
                        <i class="bi bi-star-fill text-warning me-1"></i><?= $tutor['rating'] ?>
                    </span>
                    <span class="badge bg-light text-dark border fw-normal">
                        <i class="bi bi-people-fill text-primary me-1"></i><?= $tutor['students'] ?> Siswa
                    </span>
                </div>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-sm btn-outline-primary rounded-pill" 
                            onclick="showTutorProfile(<?= $tutor['id'] ?>)">
                        Lihat Profil
                    </button>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-light text-muted border-0"><i class="bi bi-envelope"></i></button>
                        <button class="btn btn-sm btn-light text-muted border-0"><i class="bi bi-whatsapp"></i></button>
                        <button class="btn btn-sm btn-light text-muted border-0" 
                                onclick="editTutor(<?= $tutor['id'] ?>)">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    
    <!-- Add New Placeholder -->
    <div class="col-md-6 col-xl-3">
        <button class="card border-2 border-dashed shadow-none h-100 w-100 d-flex flex-column align-items-center justify-content-center p-4 text-muted bg-transparent tutor-card" 
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddTutor"
                style="min-height: 300px; cursor: pointer;">
            <div class="mb-3 p-3 bg-light rounded-circle">
                <i class="bi bi-plus-lg fs-3"></i>
            </div>
            <h6 class="fw-bold">Tambah Instruktur</h6>
            <p class="small text-muted text-center mb-0">Daftarkan pengajar baru ke dalam sistem</p>
        </button>
    </div>
</div>

<!-- Offcanvas Add Tutor -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddTutor" aria-labelledby="offcanvasAddTutorLabel" style="width: 500px;">
    <div class="offcanvas-header border-bottom bg-light">
        <h5 class="offcanvas-title fw-bold" id="offcanvasAddTutorLabel">
            <i class="bi bi-person-plus-fill me-2 text-primary"></i>Tambah Instruktur
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form>
            <div class="text-center mb-4">
                <div class="dashed-upload mx-auto mb-2">
                    <i class="bi bi-camera fs-3 text-muted"></i>
                </div>
                <div class="small text-muted">Upload Foto Profil</div>
            </div>

            <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-info-circle me-2"></i>Informasi Pribadi</h6>
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="addName" placeholder="Nama Lengkap">
                <label for="addName">Nama Lengkap</label>
            </div>
            
            <div class="row g-2 mb-3">
                <div class="col-md-6">
                     <div class="form-floating">
                        <input type="email" class="form-control" id="addEmail" placeholder="Email">
                        <label for="addEmail">Email</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="addPhone" placeholder="No. HP">
                        <label for="addPhone">No. WhatsApp</label>
                    </div>
                </div>
            </div>

            <h6 class="fw-bold mb-3 mt-4 text-primary"><i class="bi bi-briefcase me-2"></i>Profesional</h6>

            <div class="form-floating mb-3">
                <select class="form-select" id="addSpecialty" aria-label="Spesialisasi">
                    <option selected>Pilih Bidang...</option>
                    <option>Web Development</option>
                    <option>Graphic Design</option>
                    <option>Digital Marketing</option>
                    <option>Office Automation</option>
                </select>
                <label for="addSpecialty">Spesialisasi Utama</label>
            </div>

            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Bio Singkat" id="addBio" style="height: 100px"></textarea>
                <label for="addBio">Bio Singkat</label>
            </div>
        </form>
    </div>
    <div class="offcanvas-footer p-3 border-top bg-light">
        <div class="d-grid gap-2">
            <button type="button" class="btn btn-primary btn-lg shadow-sm">
                <i class="bi bi-save me-2"></i>Simpan Data Instruktur
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Batal</button>
        </div>
    </div>
</div>

<!-- Offcanvas View Profile -->
<div class="offcanvas offcanvas-end offcanvas-wide" tabindex="-1" id="offcanvasTutorProfile" aria-labelledby="offcanvasTutorProfileLabel">
    <div class="offcanvas-header border-bottom p-0 position-relative">
        <div class="profile-cover w-100">
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="profile-avatar-container">
            <div id="profileAvatar" class="avatar-profile-xl bg-primary text-white">
                <!-- Initials -->
            </div>
        </div>
    </div>
    <div class="offcanvas-body pt-5 mt-3">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h3 class="fw-bold mb-1" id="profileName">Name</h3>
                <p class="text-primary fw-semibold mb-0" id="profileRole">Role</p>
                <p class="text-muted small" id="profileSpecialty">Specialty</p>
            </div>
            <div class="text-end">
                 <div class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                    <i class="bi bi-star-fill text-warning me-1"></i> <span id="profileRating" class="fw-bold">0.0</span>
                </div>
            </div>
        </div>

        <ul class="nav nav-tabs nav-fill mb-4" id="tutorTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-overview">Overview</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-resume">Resume</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-skills">Skills & Certs</button>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Overview Tab -->
            <div class="tab-pane fade show active" id="tab-overview">
                <h6 class="fw-bold mb-3">Biography</h6>
                <p class="text-muted small" id="profileBio">
                    <!-- Bio goes here -->
                </p>
                
                <h6 class="fw-bold mb-3 mt-4">Contact Information</h6>
                <div class="card bg-light border-0 p-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-primary">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Email Address</div>
                            <div class="fw-semibold text-dark" id="profileEmail">email@example.com</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-success">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <div>
                            <div class="small text-muted">WhatsApp / Phone</div>
                            <div class="fw-semibold text-dark" id="profilePhone">0812...</div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center p-3 h-100">
                            <h3 class="fw-bold text-primary mb-0" id="profileStudents">0</h3>
                            <div class="small text-muted">Total Students</div>
                        </div>
                    </div>
                    <div class="col-6">
                         <div class="card border-0 shadow-sm text-center p-3 h-100">
                            <h3 class="fw-bold text-success mb-0">Active</h3>
                            <div class="small text-muted">Status</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resume Tab -->
            <div class="tab-pane fade" id="tab-resume">
                <h6 class="fw-bold mb-3"><i class="bi bi-briefcase me-2 text-primary"></i>Experience</h6>
                <div class="timeline" id="experienceList">
                    <!-- JS populated -->
                </div>

                <h6 class="fw-bold mb-3 mt-4"><i class="bi bi-mortarboard me-2 text-success"></i>Education</h6>
                <div class="timeline" id="educationList">
                     <!-- JS populated -->
                </div>
            </div>

            <!-- Skills Tab -->
            <div class="tab-pane fade" id="tab-skills">
                <h6 class="fw-bold mb-3">Professional Skills</h6>
                <div id="skillsList" class="mb-4">
                    <!-- JS populated -->
                </div>
                
                <h6 class="fw-bold mb-3">Certifications</h6>
                <div class="alert alert-light border d-flex align-items-center">
                    <i class="bi bi-patch-check-fill text-primary fs-4 me-3"></i>
                    <div>
                        <div class="fw-bold">Certified Professional Instructor</div>
                        <div class="small text-muted">Issued by National Certification Board</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer p-3 border-top bg-light d-flex gap-2">
        <button class="btn btn-outline-primary flex-grow-1" onclick="showIdCard()">
            <i class="bi bi-person-badge me-2"></i> View ID Card
        </button>
        <button class="btn btn-primary flex-grow-1">
            <i class="bi bi-pencil me-2"></i> Edit Profile
        </button>
    </div>
</div>

<!-- Modal ID Card Tutor -->
<div class="modal fade" id="modalTutorIdCard" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 bg-transparent shadow-none">
            <div class="modal-body p-0">
                <div class="id-card-tutor">
                    <div class="id-header-bg"></div>
                    <div class="id-avatar-main">
                        <div class="id-avatar-inner" id="idCardAvatar">
                            EK
                        </div>
                    </div>
                    <div class="id-content">
                        <h4 class="fw-bold mb-1" id="idCardName">Eko Kurniawan</h4>
                        <div class="id-role-badge" id="idCardRole">SENIOR INSTRUCTOR</div>
                        <p class="text-muted small mb-1" id="idCardSpecialty">Web Development</p>
                        <p class="text-muted small" id="idCardId">ID: INST-001</p>
                        
                        <div class="px-4 mt-4">
                            <div class="row g-2 border-top border-bottom py-3">
                                <div class="col-6 border-end">
                                    <div class="fw-bold text-dark">Active</div>
                                    <div class="extra-small text-muted">STATUS</div>
                                </div>
                                <div class="col-6">
                                    <div class="fw-bold text-dark">2025</div>
                                    <div class="extra-small text-muted">VALID UNTIL</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="id-qrcode">
                            <i class="bi bi-qr-code-scan fs-1"></i>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 w-100 bg-light py-2 text-center small text-muted border-top">
                        SIAKAD OFFICIAL INSTRUCTOR CARD
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button class="btn btn-light rounded-pill shadow-sm px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-2"></i> Close
                    </button>
                    <button class="btn btn-primary rounded-pill shadow-sm px-4 ms-2">
                        <i class="bi bi-printer me-2"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas Edit Tutor -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditTutor" aria-labelledby="offcanvasEditTutorLabel" style="width: 500px;">
    <div class="offcanvas-header border-bottom bg-light">
        <h5 class="offcanvas-title fw-bold" id="offcanvasEditTutorLabel">
            <i class="bi bi-pencil-square me-2 text-primary"></i>Edit Data Instruktur
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editTutorForm">
            <input type="hidden" id="editTutorId">
            
            <div class="text-center mb-4">
                <div class="dashed-upload mx-auto mb-2" style="border-color: #0d6efd; background-color: #f8f9fa; color: #0d6efd;">
                    <span class="fw-bold fs-4" id="editAvatarPreview">EK</span>
                </div>
                <div class="small text-muted">Ubah Foto Profil</div>
            </div>

            <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-info-circle me-2"></i>Informasi Pribadi</h6>
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="editTutorName" placeholder="Nama Lengkap">
                <label for="editTutorName">Nama Lengkap</label>
            </div>
            
            <div class="row g-2 mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="email" class="form-control" id="editTutorEmail" placeholder="Email">
                        <label for="editTutorEmail">Email</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="editTutorPhone" placeholder="No. HP">
                        <label for="editTutorPhone">No. WhatsApp</label>
                    </div>
                </div>
            </div>

            <h6 class="fw-bold mb-3 mt-4 text-primary"><i class="bi bi-briefcase me-2"></i>Profesional</h6>

            <div class="form-floating mb-3">
                <select class="form-select" id="editTutorSpecialty">
                    <option>Web Development</option>
                    <option>Graphic Design</option>
                    <option>Digital Marketing</option>
                    <option>Office Automation</option>
                </select>
                <label for="editTutorSpecialty">Spesialisasi</label>
            </div>
        </form>
    </div>
    <div class="offcanvas-footer p-3 border-top bg-light">
        <div class="d-grid gap-2">
            <button type="button" class="btn btn-primary btn-lg shadow-sm">
                <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Batal</button>
        </div>
    </div>
</div>

<script>
    // Inject PHP Data to JS
    const tutorsData = <?= json_encode($tutors) ?>;
    let currentTutorId = null;

    function getTutorById(id) {
        return tutorsData.find(t => t.id == id);
    }

    function showTutorProfile(id) {
        currentTutorId = id;
        const tutor = getTutorById(id);
        if(!tutor) return;

        // Populate Header
        document.getElementById('profileName').textContent = tutor.name;
        document.getElementById('profileRole').textContent = tutor.role || 'Instructor';
        document.getElementById('profileSpecialty').textContent = tutor.specialty;
        document.getElementById('profileRating').textContent = tutor.rating;
        document.getElementById('profileStudents').textContent = tutor.students;
        
        // Avatar
        const avatar = document.getElementById('profileAvatar');
        avatar.className = `avatar-profile-xl bg-${tutor.avatar_color}-subtle text-${tutor.avatar_color}`;
        avatar.textContent = tutor.initials;

        // Overview
        document.getElementById('profileBio').textContent = tutor.bio || 'No biography available.';
        document.getElementById('profileEmail').textContent = tutor.email;
        document.getElementById('profilePhone').textContent = tutor.phone;

        // Populate Experience
        const expContainer = document.getElementById('experienceList');
        expContainer.innerHTML = '';
        if(tutor.experience && tutor.experience.length > 0) {
            tutor.experience.forEach(exp => {
                expContainer.innerHTML += `
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <h6 class="fw-bold mb-0 text-dark">${exp.role}</h6>
                        <div class="small text-muted">${exp.company}</div>
                        <div class="extra-small text-muted mt-1">${exp.year}</div>
                    </div>
                `;
            });
        } else {
            expContainer.innerHTML = '<div class="text-muted small">No experience listed.</div>';
        }

        // Populate Education
        const eduContainer = document.getElementById('educationList');
        eduContainer.innerHTML = '';
        if(tutor.education && tutor.education.length > 0) {
            tutor.education.forEach(edu => {
                eduContainer.innerHTML += `
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <h6 class="fw-bold mb-0 text-dark">${edu.degree}</h6>
                        <div class="small text-muted">${edu.school}</div>
                        <div class="extra-small text-muted mt-1">${edu.year}</div>
                    </div>
                `;
            });
        } else {
            eduContainer.innerHTML = '<div class="text-muted small">No education listed.</div>';
        }

        // Populate Skills
        const skillContainer = document.getElementById('skillsList');
        skillContainer.innerHTML = '';
        if(tutor.skills && tutor.skills.length > 0) {
            tutor.skills.forEach(skill => {
                skillContainer.innerHTML += `<span class="skill-pill">${skill}</span>`;
            });
        } else {
            skillContainer.innerHTML = '<span class="text-muted small">No skills listed.</span>';
        }
        
        const bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasTutorProfile'));
        bsOffcanvas.show();
    }

    function showIdCard() {
        const tutor = getTutorById(currentTutorId);
        if(!tutor) return;

        document.getElementById('idCardName').textContent = tutor.name;
        document.getElementById('idCardRole').textContent = (tutor.role || 'INSTRUCTOR').toUpperCase();
        document.getElementById('idCardSpecialty').textContent = tutor.specialty;
        document.getElementById('idCardId').textContent = 'ID: INST-' + String(tutor.id).padStart(3, '0');
        
        const avatar = document.getElementById('idCardAvatar');
        avatar.className = `id-avatar-inner text-${tutor.avatar_color}`;
        avatar.textContent = tutor.initials;

        const modal = new bootstrap.Modal(document.getElementById('modalTutorIdCard'));
        modal.show();
    }

    function editTutor(id) {
        const tutor = getTutorById(id);
        if(!tutor) return;

        document.getElementById('editTutorId').value = tutor.id;
        document.getElementById('editTutorName').value = tutor.name;
        
        // Avatar Preview
        const avatarPreview = document.getElementById('editAvatarPreview');
        avatarPreview.textContent = tutor.initials;
        avatarPreview.parentElement.className = `dashed-upload mx-auto mb-2 bg-${tutor.avatar_color}-subtle text-${tutor.avatar_color}`;
        avatarPreview.parentElement.style.borderColor = 'currentColor';

        // Match specialty
        const specialtySelect = document.getElementById('editTutorSpecialty');
        for(let i=0; i<specialtySelect.options.length; i++){
            if(specialtySelect.options[i].text.includes(tutor.specialty) || tutor.specialty.includes(specialtySelect.options[i].text)) {
                 specialtySelect.selectedIndex = i;
                 break;
            }
        }
        
        document.getElementById('editTutorEmail').value = tutor.email;
        document.getElementById('editTutorPhone').value = tutor.phone;
        
        const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasEditTutor'));
        offcanvas.show();
    }
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
