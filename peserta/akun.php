<?php
require_once __DIR__ . '/../config.php';
require_login(['peserta']);

$user         = current_user();
$title        = 'Pengaturan Akun';
$currentPage  = 'akun';
$roleBasePath = '/peserta';
$baseUrl      = '/siakad';

ob_start();
?>
<div class="row mb-3">
    <div class="col-lg-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <h4 class="fw-semibold mb-0">Pengaturan Akun Peserta</h4>
            <span class="badge rounded-pill bg-light text-muted extra-small">
                <i class="bi bi-person-badge me-1"></i> Profil & Keamanan
            </span>
        </div>
        <p class="text-muted small mb-0">
            Kelola informasi akun yang kamu gunakan di SIAKAD Depati Akademi.
            Di versi demo ini data masih statis, tapi layout-nya sudah siap untuk dipakai di produksi.
        </p>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-primary-subtle text-primary">
                <i class="bi bi-person-circle"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Nama</div>
                <div class="small fw-semibold text-truncate" style="max-width: 150px;">
                    <?= htmlspecialchars($user['name']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-success-subtle text-success">
                <i class="bi bi-upc-scan"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">NIP Peserta</div>
                <div class="small fw-semibold">DA-NIP-2025-0001</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-info-subtle text-info">
                <i class="bi bi-envelope"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Email Login</div>
                <div class="small fw-semibold text-truncate" style="max-width: 150px;">
                    <?= htmlspecialchars($user['email']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white border-0 shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-warning-subtle text-warning">
                <i class="bi bi-key"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">PIN Absen</div>
                <div class="small fw-semibold">••••</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body small">
                <h6 class="fw-semibold mb-2">Informasi Peserta</h6>
                <p class="extra-small text-muted mb-3">
                    Data ini digunakan sebagai identitasmu di LPK dan akan muncul di rapor dan sertifikat.
                </p>

                <div class="mb-2">
                    <label class="form-label extra-small text-muted mb-1">Nama lengkap</label>
                    <input type="text"
                           class="form-control form-control-sm"
                           value="<?= htmlspecialchars($user['name']) ?>"
                           disabled>
                </div>

                <div class="mb-2">
                    <label class="form-label extra-small text-muted mb-1">Nomor Induk Peserta (NIP)</label>
                    <input type="text"
                           class="form-control form-control-sm"
                           value="DA-NIP-2025-0001"
                           disabled>
                    <div class="form-text extra-small">
                        NIP akan dibuat otomatis oleh sistem saat kamu terdaftar sebagai peserta.
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label extra-small text-muted mb-1">Alamat</label>
                    <textarea class="form-control form-control-sm" rows="2" disabled>Jl. Contoh Alamat No. 123, Kerinci</textarea>
                    <div class="form-text extra-small">
                        Di versi final, alamat ini bisa diupdate jika ada perubahan domisili.
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label extra-small text-muted mb-1">No. Handphone</label>
                    <input type="text"
                           class="form-control form-control-sm"
                           value="08xx-xxxx-xxxx"
                           disabled>
                    <div class="form-text extra-small">
                        Nomor HP akan dipakai untuk pengingat via WhatsApp / SMS.
                    </div>
                </div>

                <div class="alert alert-light border extra-small mb-0 mt-2">
                    <i class="bi bi-info-circle me-1"></i>
                    Untuk mengubah data identitas resmi (nama di sertifikat, NIP, dll)
                    biasanya harus lewat admin / operator LPK.
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body small">
                <h6 class="fw-semibold mb-2">Login & Keamanan</h6>
                <p class="extra-small text-muted mb-3">
                    Email, password, dan PIN dipakai untuk login, absen, dan beberapa fitur penting seperti ujian.
                </p>

                <div class="mb-2">
                    <label class="form-label extra-small text-muted mb-1">Email akun</label>
                    <input type="email"
                           class="form-control form-control-sm"
                           value="<?= htmlspecialchars($user['email']) ?>"
                           disabled>
                    <div class="form-text extra-small">
                        Email ini digunakan untuk login dan menerima notifikasi.
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label extra-small text-muted mb-1">Password</label>
                    <div class="input-group input-group-sm">
                        <input type="password"
                               class="form-control"
                               value="********"
                               disabled>
                        <button class="btn btn-outline-secondary" type="button" disabled>
                            Ubah (Demo)
                        </button>
                    </div>
                    <div class="form-text extra-small">
                        Di versi final, kamu bisa mengubah password dari halaman ini (dengan verifikasi dulu).
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label extra-small text-muted mb-1">PIN Absen</label>
                    <div class="input-group input-group-sm" style="max-width: 240px;">
                        <input type="password"
                               class="form-control"
                               value="••••"
                               disabled>
                        <span class="input-group-text">PIN</span>
                    </div>
                    <div class="form-text extra-small">
                        PIN akan dipakai untuk konfirmasi saat <strong>absen</strong> dan
                        aktivitas tertentu seperti mulai ujian atau tanda tangan digital.
                    </div>
                </div>

                <div class="alert alert-light border extra-small mb-2">
                    <i class="bi bi-shield-lock me-1"></i>
                    Jangan bagikan password dan PIN ke orang lain. 
                    Admin tidak akan pernah meminta password secara langsung.
                </div>

                <button class="btn btn-primary btn-sm" type="button" disabled>
                    <i class="bi bi-save me-1"></i> Simpan perubahan (Demo)
                </button>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
