<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$user         = current_user();
$title        = 'Raport & Sertifikat';
$currentPage  = 'raport';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

// --- Simulated Data ---
$classes = [
    [
        'id' => 1,
        'code' => 'OM-01',
        'program' => 'Operator Komputer',
        'batch' => 'Januari 2025',
        'students' => 20,
        'grading_progress' => 100,
        'status' => 'completed',
        'certificates_generated' => true,
        'date_completed' => '10 Des 2025'
    ],
    [
        'id' => 2,
        'code' => 'DM-02',
        'program' => 'Digital Marketing',
        'batch' => 'Februari 2025',
        'students' => 15,
        'grading_progress' => 60,
        'status' => 'grading',
        'certificates_generated' => false,
        'date_completed' => '-'
    ],
    [
        'id' => 3,
        'code' => 'WEB-03',
        'program' => 'Web Development',
        'batch' => 'Maret 2025',
        'students' => 12,
        'grading_progress' => 0,
        'status' => 'ongoing',
        'certificates_generated' => false,
        'date_completed' => '-'
    ]
];

ob_start();
?>
<!-- Header -->
<div class="row g-3 mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold text-dark mb-1">Raport & Sertifikat</h4>
        <p class="text-muted small mb-0">Kelola penilaian akhir dan penerbitan sertifikat kelulusan.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <button class="btn btn-outline-primary rounded-pill px-3 shadow-sm me-2">
            <i class="bi bi-gear me-1"></i> Template Sertifikat
        </button>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-printer me-1"></i> Cetak Massal
        </button>
    </div>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-success text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="fs-6 opacity-75">Sertifikat Terbit</div>
                    <i class="bi bi-award fs-4"></i>
                </div>
                <h3 class="fw-bold mb-0">1,245</h3>
                <div class="small opacity-75 mt-1">Total lulusan bersertifikat</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="fs-6 text-muted">Dalam Penilaian</div>
                    <div class="p-2 rounded bg-warning-subtle text-warning">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-dark">45</h3>
                <div class="small text-muted mt-1">Siswa menunggu hasil akhir</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="fs-6 text-muted">Siap Generate</div>
                    <div class="p-2 rounded bg-primary-subtle text-primary">
                        <i class="bi bi-magic"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-dark">20</h3>
                <div class="small text-muted mt-1">Siswa lulus siap sertifikat</div>
            </div>
        </div>
    </div>
</div>

<!-- Grading Table -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom-0 py-3">
        <h6 class="fw-bold mb-0">Status Penilaian Kelas</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Kelas & Program</th>
                    <th>Batch</th>
                    <th>Progress Penilaian</th>
                    <th>Status</th>
                    <th>Sertifikat</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $cls): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark"><?= $cls['program'] ?></div>
                            <div class="extra-small text-muted"><?= $cls['code'] ?></div>
                        </td>
                        <td><?= $cls['batch'] ?></td>
                        <td style="width: 200px;">
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                    <div class="progress-bar bg-<?= $cls['grading_progress'] == 100 ? 'success' : 'primary' ?>" role="progressbar" style="width: <?= $cls['grading_progress'] ?>%"></div>
                                </div>
                                <span class="small fw-semibold"><?= $cls['grading_progress'] ?>%</span>
                            </div>
                        </td>
                        <td>
                            <?php if ($cls['status'] == 'completed'): ?>
                                <span class="badge bg-success-subtle text-success rounded-pill">Selesai</span>
                            <?php elseif ($cls['status'] == 'grading'): ?>
                                <span class="badge bg-warning-subtle text-warning rounded-pill">Penilaian</span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill">Berjalan</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($cls['certificates_generated']): ?>
                                <span class="badge bg-success-subtle text-success rounded-pill"><i class="bi bi-check-circle me-1"></i> Terbit</span>
                            <?php else: ?>
                                <span class="badge bg-light text-muted border rounded-pill">Belum Ada</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="showClassDetail(<?= $cls['id'] ?>, '<?= $cls['program'] ?>')">Detail</button>
                                <?php if ($cls['grading_progress'] == 100 && !$cls['certificates_generated']): ?>
                                    <button class="btn btn-sm btn-primary rounded-pill px-3 ms-1"><i class="bi bi-magic"></i> Generate</button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Class Detail (Student List) -->
<div class="modal fade" id="modalClassDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold" id="detailClassTitle">Detail Kelas</h5>
                    <p class="text-muted small mb-0">Daftar siswa dan status kelulusan</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="input-group w-auto">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control bg-light border-start-0" placeholder="Cari siswa...">
                    </div>
                    <button class="btn btn-success rounded-pill px-4">
                        <i class="bi bi-printer me-2"></i> Cetak Semua Raport
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Nama Siswa</th>
                                <th>Nilai Akhir</th>
                                <th>Kehadiran</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Aksi / Preview</th>
                            </tr>
                        </thead>
                        <tbody id="studentListBody">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Raport -->
<div class="modal fade" id="modalPreviewRaport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-file-text me-2"></i> Preview Raport</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-secondary bg-opacity-10 p-4">
                <div class="bg-white shadow-sm p-5 mx-auto" style="max-width: 210mm; min-height: 297mm;">
                    <!-- Raport Header -->
                    <div class="text-center border-bottom pb-4 mb-4">
                        <img src="https://via.placeholder.com/60" alt="Logo" class="mb-2">
                        <h4 class="fw-bold text-uppercase mb-1">Lembaga Pelatihan Kerja (LPK) Siakad</h4>
                        <p class="small text-muted mb-0">Jl. Contoh No. 123, Jakarta Selatan, DKI Jakarta</p>
                        <p class="small text-muted">Telp: (021) 1234-5678 | Email: info@lpk-siakad.com</p>
                    </div>
                    
                    <h5 class="text-center fw-bold text-uppercase mb-4 text-decoration-underline">Laporan Hasil Belajar</h5>
                    
                    <div class="row mb-4 small">
                        <div class="col-6">
                            <table class="table table-borderless table-sm mb-0">
                                <tr><td width="100">Nama Siswa</td><td>: <span class="fw-bold" id="raportName">Nama Siswa</span></td></tr>
                                <tr><td>Nomor Induk</td><td>: <span id="raportNIS">2025001</span></td></tr>
                            </table>
                        </div>
                        <div class="col-6">
                             <table class="table table-borderless table-sm mb-0">
                                <tr><td width="100">Program</td><td>: <span class="fw-bold" id="raportProgram">Operator Komputer</span></td></tr>
                                <tr><td>Periode</td><td>: Januari - Maret 2025</td></tr>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Grades Table -->
                    <table class="table table-bordered border-dark mb-4 small">
                        <thead class="bg-light text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Mata Pelajaran / Kompetensi</th>
                                <th width="15%">Nilai (0-100)</th>
                                <th width="15%">Predikat</th>
                                <th width="30%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>Pengenalan Komputer & OS</td>
                                <td class="text-center">85</td>
                                <td class="text-center">A</td>
                                <td>Sangat memahami konsep dasar</td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>Microsoft Office Word</td>
                                <td class="text-center">90</td>
                                <td class="text-center">A</td>
                                <td>Mampu membuat dokumen kompleks</td>
                            </tr>
                             <tr>
                                <td class="text-center">3</td>
                                <td>Microsoft Office Excel</td>
                                <td class="text-center">78</td>
                                <td class="text-center">B</td>
                                <td>Cukup baik dalam rumus dasar</td>
                            </tr>
                        </tbody>
                        <tfoot class="fw-bold bg-light">
                            <tr>
                                <td colspan="2" class="text-end">Rata-rata Nilai</td>
                                <td class="text-center">84.3</td>
                                <td class="text-center">A</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <!-- Attendance & Notes -->
                    <div class="row mb-5 small">
                        <div class="col-6">
                            <table class="table table-bordered border-dark w-75">
                                <thead class="bg-light text-center">
                                    <tr><th colspan="2">Ketidakhadiran</th></tr>
                                </thead>
                                <tbody>
                                    <tr><td>Sakit</td><td class="text-center">1 Hari</td></tr>
                                    <tr><td>Izin</td><td class="text-center">0 Hari</td></tr>
                                    <tr><td>Tanpa Keterangan</td><td class="text-center">0 Hari</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6">
                            <div class="border border-dark p-2 h-100">
                                <p class="fw-bold mb-1">Catatan Instruktur:</p>
                                <p class="fst-italic mb-0">"Siswa menunjukkan dedikasi yang tinggi dan perkembangan yang signifikan selama pelatihan."</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Signature -->
                    <div class="row mt-5 pt-4">
                        <div class="col-4 text-center">
                            <p class="mb-5">Orang Tua / Wali</p>
                            <p class="fw-bold text-decoration-underline mt-5">.........................</p>
                        </div>
                        <div class="col-4 text-center">
                            <p class="mb-5">Instruktur</p>
                            <p class="fw-bold text-decoration-underline mt-5">Budi Santoso, S.Kom</p>
                        </div>
                         <div class="col-4 text-center">
                            <p class="mb-0">Jakarta, 12 Maret 2025</p>
                            <p class="mb-5">Kepala LPK</p>
                            <p class="fw-bold text-decoration-underline mt-5">Dr. Admin Siakad</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary"><i class="bi bi-printer me-2"></i> Cetak PDF</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Certificate -->
<div class="modal fade" id="modalPreviewCert" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-award me-2"></i> Preview Sertifikat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-secondary bg-opacity-10 p-4 text-center">
                 <div class="certificate-mockup bg-white shadow mx-auto p-5 text-center border position-relative" style="max-width: 900px; height: 600px; background-image: radial-gradient(#f8f9fa 2px, transparent 2px); background-size: 20px 20px;">
                    <!-- Border Design -->
                    <div class="border border-4 border-double p-5 h-100 d-flex flex-column justify-content-center position-relative" style="border-style: double !important; border-width: 10px !important; border-color: #198754 !important;">
                        
                        <div class="mb-4">
                            <i class="bi bi-patch-check-fill text-success display-3"></i>
                        </div>
                        
                        <h1 class="serif fw-bold mb-2 text-uppercase" style="font-family: 'Times New Roman', serif; letter-spacing: 2px;">Sertifikat Kompetensi</h1>
                        <p class="text-muted fst-italic mb-5 fs-5">Nomor: 2025/CERT/SI-001</p>
                        
                        <p class="mb-2 fs-5">Diberikan kepada:</p>
                        <h2 class="fw-bold text-dark mb-4 display-6 text-uppercase text-decoration-underline" id="certName">NAMA SISWA</h2>
                        
                        <p class="mb-4 fs-5 w-75 mx-auto lh-lg">
                            Telah menyelesaikan program pelatihan <strong class="text-success" id="certProgram">PROGRAM PELATIHAN</strong><br>
                            yang diselenggarakan oleh <strong>LPK Siakad</strong> pada periode <strong>Januari - Maret 2025</strong><br>
                            dengan predikat:
                        </p>
                        
                        <h3 class="fw-bold text-success mb-5">SANGAT BAIK (A)</h3>
                        
                        <div class="row mt-auto px-5">
                            <div class="col-6 text-start">
                                <p class="mb-0 fw-bold fs-6">Instruktur Utama</p>
                                <br><br><br>
                                <p class="mb-0 fw-bold text-decoration-underline fs-5">Budi Santoso, S.Kom</p>
                                <small class="text-muted">NIP. 19850101 201001 1 001</small>
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-0 fs-6">Jakarta, 12 Maret 2025</p>
                                <p class="mb-0 fw-bold fs-6">Direktur LPK</p>
                                <br><br><br>
                                <p class="mb-0 fw-bold text-decoration-underline fs-5">Dr. Admin Siakad</p>
                                <small class="text-muted">Direktur Utama</small>
                            </div>
                        </div>
                        
                         <!-- Watermark/Seal -->
                        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 opacity-10">
                            <i class="bi bi-award-fill" style="font-size: 8rem; color: #198754;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success"><i class="bi bi-download me-2"></i> Download High-Res</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Mock Data Students
    const mockStudents = [
        { id: 1, name: 'Ahmad Rizki', score: 88, grade: 'A', status: 'Lulus' },
        { id: 2, name: 'Budi Santoso', score: 75, grade: 'B', status: 'Lulus' },
        { id: 3, name: 'Citra Dewi', score: 92, grade: 'A', status: 'Lulus' },
        { id: 4, name: 'Dian Pratama', score: 60, grade: 'C', status: 'Remedial' },
        { id: 5, name: 'Eko Wijaya', score: 85, grade: 'A', status: 'Lulus' },
    ];

    function showClassDetail(classId, className) {
        document.getElementById('detailClassTitle').innerText = 'Detail Kelas: ' + className;
        const tbody = document.getElementById('studentListBody');
        tbody.innerHTML = '';
        
        mockStudents.forEach(s => {
            const row = `
                <tr>
                    <td class="ps-3 fw-semibold">${s.name}</td>
                    <td>${s.score} (${s.grade})</td>
                    <td>90%</td>
                    <td>
                        <span class="badge ${s.status === 'Lulus' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning'} rounded-pill">
                            ${s.status}
                        </span>
                    </td>
                    <td class="text-end pe-3">
                        <button class="btn btn-sm btn-outline-secondary me-1" onclick="previewRaport('${s.name}', '${className}')" title="Preview Raport">
                            <i class="bi bi-file-text"></i>
                        </button>
                        ${s.status === 'Lulus' ? `
                        <button class="btn btn-sm btn-outline-success" onclick="previewCert('${s.name}', '${className}')" title="Preview Sertifikat">
                            <i class="bi bi-award"></i>
                        </button>
                        ` : ''}
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
        
        new bootstrap.Modal(document.getElementById('modalClassDetail')).show();
    }
    
    function previewRaport(name, program) {
        document.getElementById('raportName').innerText = name;
        document.getElementById('raportProgram').innerText = program;
        // Hide class modal, show raport modal
        // bootstrap.Modal.getInstance(document.getElementById('modalClassDetail')).hide();
        new bootstrap.Modal(document.getElementById('modalPreviewRaport')).show();
    }
    
    function previewCert(name, program) {
        document.getElementById('certName').innerText = name;
        document.getElementById('certProgram').innerText = program;
        // bootstrap.Modal.getInstance(document.getElementById('modalClassDetail')).hide();
        new bootstrap.Modal(document.getElementById('modalPreviewCert')).show();
    }
</script>

<!-- Certificate Preview (Simulated) - REMOVED OLD STATIC PREVIEW TO CLEAN UP -->
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
