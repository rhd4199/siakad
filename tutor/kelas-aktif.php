<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$title        = 'Kelas Aktif';
$currentPage  = 'kelas-aktif';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

ob_start();
?>
<div class="row mb-3">
    <div class="col-lg-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <h4 class="fw-semibold mb-0">Kelas Aktif</h4>
            <span class="badge rounded-pill bg-success-subtle text-success extra-small">
                <i class="bi bi-broadcast me-1"></i> Sedang Berlangsung
            </span>
        </div>
        <p class="text-muted small mb-0">
            Daftar kelas yang sedang berlangsung saat ini. Anda dapat memulai absensi atau memantau aktivitas peserta.
        </p>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-success-subtle text-success">
                <i class="bi bi-broadcast"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Kelas Live</div>
                <div class="fs-4 fw-semibold">1</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-primary-subtle text-primary">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Hadir</div>
                <div class="fs-4 fw-semibold">12/15</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- KOLOM KIRI: LIST KELAS AKTIF -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge bg-success-subtle text-success mb-2">
                            <i class="bi bi-circle-fill small me-1"></i> Sedang Berlangsung
                        </span>
                        <h5 class="fw-semibold mb-1">Operator Komputer - OM-01</h5>
                        <div class="text-muted small">
                            <i class="bi bi-clock me-1"></i> 08.00 - 10.00 WIB
                            <span class="mx-1">•</span>
                            <i class="bi bi-geo-alt me-1"></i> Lab Komputer 1
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Detail Kelas</a></li>
                            <li><a class="dropdown-item" href="#">Absensi</a></li>
                        </ul>
                    </div>
                </div>

                <div class="p-3 rounded-3 bg-light mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="fw-medium">Progres Materi</span>
                                <span>Pertemuan 4 dari 12</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 33%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="small text-muted">
                        Materi hari ini: <strong>Pengenalan Microsoft Word Basic</strong>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= $baseUrl . $roleBasePath ?>/kelas-detail.php?id=1" class="btn btn-primary btn-sm">
                        <i class="bi bi-door-open me-1"></i> Masuk Kelas
                    </a>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalQrAbsen">
                        <i class="bi bi-qr-code-scan me-1"></i> Buka Absen QR
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: STATUS -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-semibold">Jadwal Berikutnya</h6>
            </div>
            <div class="card-body pt-0">
                <div class="d-flex gap-3 mb-3">
                    <div class="text-center">
                        <div class="fw-bold">13.00</div>
                        <div class="small text-muted">WIB</div>
                    </div>
                    <div class="vr"></div>
                    <div>
                        <div class="fw-medium">Digital Marketing - DM-02</div>
                        <div class="small text-muted">Lab Multimedia</div>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <div class="text-center">
                        <div class="fw-bold">15.30</div>
                        <div class="small text-muted">WIB</div>
                    </div>
                    <div class="vr"></div>
                    <div>
                        <div class="fw-medium">Desain Grafis - DG-01</div>
                        <div class="small text-muted">Lab Desain</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal QR Absen -->
<div class="modal fade" id="modalQrAbsen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-semibold">Buka Absensi QR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-4 pb-5">
                
                <!-- Step 1: Pilih Pertemuan -->
                <div id="stepSelectMeeting">
                    <div class="mb-4">
                        <div class="avatar-lg bg-primary-subtle text-primary rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                            <i class="bi bi-calendar-check fs-2"></i>
                        </div>
                        <h6 class="mb-2">Pilih Pertemuan</h6>
                        <p class="text-muted small">Silakan pilih pertemuan untuk membuat kode QR Absensi.</p>
                    </div>
                    
                    <div class="form-floating mb-3 text-start">
                        <select class="form-select" id="selectPertemuan">
                            <option value="" selected disabled>Pilih Pertemuan...</option>
                            <option value="1">Pertemuan 1 - Pengenalan Komputer</option>
                            <option value="2">Pertemuan 2 - Ms Word Dasar</option>
                            <option value="3">Pertemuan 3 - Ms Word Lanjut</option>
                            <option value="4">Pertemuan 4 - Ms Excel Dasar</option>
                            <option value="5">Pertemuan 5 - Ms Excel Lanjut</option>
                            <option value="6">Pertemuan 6 - Powerpoint</option>
                        </select>
                        <label for="selectPertemuan">Pertemuan ke-</label>
                    </div>

                    <button class="btn btn-primary w-100" id="btnGenerateQr" disabled>
                        Generate QR Code
                    </button>
                </div>

                <!-- Step 2: Tampil QR -->
                <div id="stepShowQr" class="d-none">
                    <h6 class="mb-1" id="qrTitle">Absensi Pertemuan X</h6>
                    <p class="text-muted small mb-3">Minta siswa scan QR ini untuk absen</p>
                    
                    <div class="card border-0 bg-light d-inline-block p-3 mb-3">
                        <!-- Placeholder QR Code using an API or just a styled box -->
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=SIADAK-ABSEN-TOKEN-12345" alt="QR Code" class="img-fluid rounded" style="width: 200px; height: 200px;">
                    </div>

                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <div class="badge bg-light text-dark border p-2 fw-normal">
                            <i class="bi bi-clock me-1"></i> Berlaku: <span id="countdown">05:00</span>
                        </div>
                        <div class="badge bg-light text-dark border p-2 fw-normal">
                            <i class="bi bi-people me-1"></i> Masuk: <span id="absenCount">0</span>
                        </div>
                    </div>

                    <div class="alert alert-info extra-small text-start border-0 bg-info-subtle text-info-emphasis mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Siswa tidak perlu login. Cukup scan, masukkan NIP & PIN.
                    </div>

                    <button class="btn btn-outline-danger w-100" id="btnCloseQr">
                        Tutup Absensi
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectPertemuan = document.getElementById('selectPertemuan');
    const btnGenerateQr = document.getElementById('btnGenerateQr');
    const stepSelectMeeting = document.getElementById('stepSelectMeeting');
    const stepShowQr = document.getElementById('stepShowQr');
    const btnCloseQr = document.getElementById('btnCloseQr');
    const qrTitle = document.getElementById('qrTitle');

    // Enable button when meeting is selected
    selectPertemuan.addEventListener('change', function() {
        if(this.value) {
            btnGenerateQr.removeAttribute('disabled');
        }
    });

    // Show QR
    btnGenerateQr.addEventListener('click', function() {
        const meetingText = selectPertemuan.options[selectPertemuan.selectedIndex].text;
        qrTitle.textContent = 'Absensi ' + meetingText; // e.g. Absensi Pertemuan 1...
        
        stepSelectMeeting.classList.add('d-none');
        stepShowQr.classList.remove('d-none');
        
        // Simulate live counter
        let count = 0;
        const interval = setInterval(() => {
            if(count < 15) { // max 15 students
                count++;
                document.getElementById('absenCount').textContent = count;
            } else {
                clearInterval(interval);
            }
        }, 2000); // increase every 2 seconds
    });

    // Close/Reset
    btnCloseQr.addEventListener('click', function() {
        if(confirm('Apakah Anda yakin ingin menutup sesi absensi ini?')) {
            stepShowQr.classList.add('d-none');
            stepSelectMeeting.classList.remove('d-none');
            selectPertemuan.value = "";
            btnGenerateQr.setAttribute('disabled', 'true');
            document.getElementById('absenCount').textContent = "0";
        }
    });
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
