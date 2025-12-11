<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$title        = 'Ujian & Soal';
$currentPage  = 'ujian-saya';
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

ob_start();
?>
<div class="row mb-3">
    <div class="col-lg-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <h4 class="fw-semibold mb-0">Ujian & Soal Peserta</h4>
            <span class="badge rounded-pill bg-light text-muted extra-small">
                <i class="bi bi-patch-question me-1"></i> Panel Pengaturan Ujian (Demo)
            </span>
        </div>
        <p class="text-muted small mb-0">
            Dari sini Anda bisa mengatur ujian untuk peserta: jadwal, durasi, tipe soal,
            sampai kunci jawabannya. Semua data masih dummy, tapi layout sudah disiapkan
            untuk versi produksi.
        </p>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-primary-subtle text-primary">
                <i class="bi bi-patch-question"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Total ujian</div>
                <div class="fs-4 fw-semibold">4</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-success-subtle text-success">
                <i class="bi bi-lightning-charge"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Aktif hari ini</div>
                <div class="fs-4 fw-semibold">1</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-info-subtle text-info">
                <i class="bi bi-bank"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Bank soal</div>
                <div class="fs-4 fw-semibold">120</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 bg-white shadow-sm d-flex align-items-center gap-3">
            <div class="app-summary-icon bg-warning-subtle text-warning">
                <i class="bi bi-ui-checks-grid"></i>
            </div>
            <div>
                <div class="extra-small text-muted text-uppercase">Tipe soal aktif</div>
                <div class="fs-4 fw-semibold">6</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- KOLOM KIRI: DAFTAR UJIAN -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body small">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-semibold mb-0">Daftar Ujian</h6>
                    <button class="btn btn-primary btn-sm" type="button" disabled>
                        <i class="bi bi-plus-lg me-1"></i> Buat ujian baru (Demo)
                    </button>
                </div>
                <p class="extra-small text-muted mb-2">
                    Ujian di bawah ini akan muncul di halaman peserta sesuai jadwal dan kelas yang Anda pilih.
                </p>

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light extra-small text-muted">
                            <tr>
                                <th>Ujian</th>
                                <th>Kelas</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th style="width: 170px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="extra-small">
                            <!-- Ujian 1 -->
                            <tr>
                                <td>
                                    <div class="fw-semibold small">Ujian Tengah – Operator Komputer</div>
                                    <div class="text-muted">
                                        50 soal CBT • PG & Esai Singkat
                                    </div>
                                </td>
                                <td>
                                    <div>OM-01</div>
                                    <div class="text-muted">Operator Komputer</div>
                                </td>
                                <td>
                                    <div>12 Des 2025</div>
                                    <div class="text-muted">08.00 – 09.00</div>
                                </td>
                                <td>
                                    <span class="badge bg-warning-subtle text-warning">
                                        <i class="bi bi-hourglass-split me-1"></i>Dijadwalkan
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm w-100">
                                        <button class="btn btn-outline-secondary btn-sm"
                                                type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalPengaturanUjian">
                                            <i class="bi bi-gear me-1"></i> Pengaturan
                                        </button>
                                        <button class="btn btn-outline-primary btn-sm"
                                                type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalKelolaSoal">
                                            <i class="bi bi-ui-checks-grid me-1"></i> Soal
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Ujian 2 -->
                            <tr>
                                <td>
                                    <div class="fw-semibold small">Tryout TPA – Digital Marketing</div>
                                    <div class="text-muted">
                                        30 soal TPA • PG & Skala
                                    </div>
                                </td>
                                <td>
                                    <div>DM-02</div>
                                    <div class="text-muted">Digital Marketing</div>
                                </td>
                                <td>
                                    <div>Hari ini</div>
                                    <div class="text-muted">13.00 – 14.00</div>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success">
                                        <i class="bi bi-play-circle me-1"></i>Berlangsung (Demo)
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm w-100">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" disabled>
                                            <i class="bi bi-gear me-1"></i> Pengaturan
                                        </button>
                                        <button class="btn btn-outline-primary btn-sm" type="button" disabled>
                                            <i class="bi bi-ui-checks-grid me-1"></i> Soal
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Ujian 3 -->
                            <tr>
                                <td>
                                    <div class="fw-semibold small">Tes Sikap Kerja – Barista Dasar</div>
                                    <div class="text-muted">
                                        25 soal TKP • Skala & Matrix
                                    </div>
                                </td>
                                <td>
                                    <div>BRS-01</div>
                                    <div class="text-muted">Barista Dasar</div>
                                </td>
                                <td>
                                    <div>15 Des 2025</div>
                                    <div class="text-muted">09.00 – 10.00</div>
                                </td>
                                <td>
                                    <span class="badge bg-info-subtle text-info">
                                        <i class="bi bi-calendar-week me-1"></i>Draft
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm w-100">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" disabled>
                                            <i class="bi bi-gear me-1"></i> Pengaturan
                                        </button>
                                        <button class="btn btn-outline-primary btn-sm" type="button" disabled>
                                            <i class="bi bi-ui-checks-grid me-1"></i> Soal
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Ujian 4 -->
                            <tr>
                                <td>
                                    <div class="fw-semibold small">Tes Minat & Bakat</div>
                                    <div class="text-muted">
                                        Skala sikap • Rekomendasi program
                                    </div>
                                </td>
                                <td>
                                    <div>Umum</div>
                                    <div class="text-muted">Semua peserta</div>
                                </td>
                                <td>
                                    <div>Online</div>
                                    <div class="text-muted">Tanpa batas jam</div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        <i class="bi bi-clipboard-check me-1"></i>Selesai
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-outline-secondary btn-sm w-100" type="button" disabled>
                                        <i class="bi bi-bar-chart-line me-1"></i> Hasil & Rekomendasi
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: BANK SOAL & TIPE SOAL -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body small">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-semibold mb-0">Ringkasan Bank Soal</h6>
                    <button class="btn btn-outline-secondary btn-sm" type="button" disabled>
                        <i class="bi bi-download me-1"></i> Export (Demo)
                    </button>
                </div>
                <p class="extra-small text-muted mb-2">
                    Gambaran cepat berapa banyak soal yang sudah Anda punya per tipe.
                </p>

                <div class="row g-2 extra-small">
                    <div class="col-6">
                        <div class="border rounded-3 p-2 d-flex justify-content-between align-items-center">
                            <span>Pilihan Ganda</span>
                            <span class="badge bg-primary-subtle text-primary">60</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded-3 p-2 d-flex justify-content-between align-items-center">
                            <span>PG Multi Jawaban</span>
                            <span class="badge bg-primary-subtle text-primary">15</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded-3 p-2 d-flex justify-content-between align-items-center">
                            <span>Esai Singkat</span>
                            <span class="badge bg-success-subtle text-success">20</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded-3 p-2 d-flex justify-content-between align-items-center">
                            <span>Esai</span>
                            <span class="badge bg-success-subtle text-success">10</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded-3 p-2 d-flex justify-content-between align-items-center">
                            <span>Skala (Likert)</span>
                            <span class="badge bg-warning-subtle text-warning">8</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded-3 p-2 d-flex justify-content-between align-items-center">
                            <span>True / False</span>
                            <span class="badge bg-warning-subtle text-warning">7</span>
                        </div>
                    </div>
                </div>

                <p class="extra-small text-muted mt-2 mb-0">
                    Di versi final, setiap kartu di atas bisa diklik untuk melihat daftar soal detail
                    per tipe dan mengeditnya.
                </p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body small">
                <h6 class="fw-semibold mb-2">Tipe Soal yang Didukung</h6>
                <ul class="extra-small text-muted mb-0">
                    <li><strong>Pilihan Ganda:</strong> 1 jawaban benar dari beberapa opsi.</li>
                    <li><strong>Pilihan Ganda Multi Jawaban:</strong> peserta bisa pilih lebih dari 1 jawaban benar.</li>
                    <li><strong>Esai Singkat:</strong> jawaban 1–2 kalimat (bisa semi-otomatis dinilai).</li>
                    <li><strong>Esai:</strong> jawaban panjang, dinilai manual oleh tutor.</li>
                    <li><strong>Skala (Likert):</strong> misalnya 1–5 dari “Sangat Tidak Setuju” sampai “Sangat Setuju”.</li>
                    <li><strong>True / False:</strong> Benar / Salah.</li>
                    <li><strong>Matrix / Grid:</strong> beberapa pernyataan dinilai dengan skala yang sama (cocok untuk sikap / TKP).</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PENGATURAN UJIAN -->
<div class="modal fade" id="modalPengaturanUjian" tabindex="-1" aria-labelledby="modalPengaturanUjianLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h6 class="modal-title small fw-semibold" id="modalPengaturanUjianLabel">
                        Pengaturan Ujian – Ujian Tengah Operator Komputer
                    </h6>
                    <p class="extra-small text-muted mb-0">
                        Atur jadwal, durasi, dan perilaku ujian seperti urutan soal dan tampilkan nilai.
                        Semua masih contoh.
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small pt-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Nama ujian</label>
                            <input type="text" class="form-control form-control-sm"
                                   value="Ujian Tengah – Operator Komputer" disabled>
                        </div>
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Kelas & Program</label>
                            <input type="text" class="form-control form-control-sm"
                                   value="OM-01 • Operator Komputer" disabled>
                        </div>
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Tanggal & jam</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="date" class="form-control form-control-sm" value="2025-12-12" disabled>
                                </div>
                                <div class="col-3">
                                    <input type="time" class="form-control form-control-sm" value="08:00" disabled>
                                </div>
                                <div class="col-3">
                                    <input type="time" class="form-control form-control-sm" value="09:00" disabled>
                                </div>
                            </div>
                            <div class="form-text extra-small">
                                Di versi final, jam mulai & selesai bisa diatur dari sini.
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Durasi ujian (menit)</label>
                            <input type="number" class="form-control form-control-sm" value="60" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Mode ujian</label>
                            <select class="form-select form-select-sm" disabled>
                                <option>Linear (soal berurutan)</option>
                                <option>Random (soal acak)</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Pengaturan perilaku</label>
                            <div class="form-check extra-small">
                                <input class="form-check-input" type="checkbox" checked disabled id="optShuffle">
                                <label class="form-check-label" for="optShuffle">
                                    Acak urutan soal
                                </label>
                            </div>
                            <div class="form-check extra-small">
                                <input class="form-check-input" type="checkbox" checked disabled id="optShowScore">
                                <label class="form-check-label" for="optShowScore">
                                    Tampilkan nilai langsung setelah selesai
                                </label>
                            </div>
                            <div class="form-check extra-small">
                                <input class="form-check-input" type="checkbox" disabled id="optShowDiscuss">
                                <label class="form-check-label" for="optShowDiscuss">
                                    Tampilkan pembahasan setelah semua kelas selesai
                                </label>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label extra-small text-muted mb-1">Batas keterlambatan</label>
                            <select class="form-select form-select-sm" disabled>
                                <option>Max 10 menit</option>
                                <option>Max 15 menit</option>
                                <option>Max 30 menit</option>
                                <option>Tidak boleh terlambat</option>
                            </select>
                        </div>
                        <div class="alert alert-light border extra-small mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Di backend, pengaturan ini akan menentukan kapan ujian muncul
                            di dashboard peserta dan kapan otomatis tertutup.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button type="button" class="btn btn-primary btn-sm" disabled>
                    <i class="bi bi-save me-1"></i> Simpan pengaturan (Demo)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL KELOLA SOAL -->
<div class="modal fade" id="modalKelolaSoal" tabindex="-1" aria-labelledby="modalKelolaSoalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h6 class="modal-title small fw-semibold" id="modalKelolaSoalLabel">
                        Kelola Soal – Ujian Tengah Operator Komputer
                    </h6>
                    <p class="extra-small text-muted mb-0">
                        Contoh tampilan bank soal per ujian. Di sini tutor bisa menambah, mengedit,
                        dan menentukan kunci jawaban.
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body small pt-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="extra-small text-muted">
                        Total soal: <strong>7</strong> • Kombinasi beberapa tipe soal
                    </div>
                    <button class="btn btn-primary btn-sm" type="button" disabled>
                        <i class="bi bi-plus-lg me-1"></i> Tambah soal (Demo)
                    </button>
                </div>

                <div class="row g-3">
                    <div class="col-lg-7">
                        <div class="list-group small">
                            <!-- Soal 1: PG -->
                            <div class="list-group-item border-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div>
                                        <span class="badge bg-primary-subtle text-primary extra-small me-1">#1</span>
                                        <span class="badge bg-light text-muted extra-small">Pilihan Ganda</span>
                                    </div>
                                    <span class="extra-small text-muted">Bobot: 2 poin</span>
                                </div>
                                <div class="mb-1">
                                    <strong>Perangkat keras yang berfungsi menampilkan hasil output ke layar adalah…</strong>
                                </div>
                                <ul class="extra-small mb-1">
                                    <li>A. Keyboard</li>
                                    <li><strong>B. Monitor ✔</strong></li>
                                    <li>C. Mouse</li>
                                    <li>D. Flashdisk</li>
                                </ul>
                                <div class="extra-small text-muted">
                                    Kunci: <strong>B</strong> • Wajib diisi: Ya
                                </div>
                            </div>

                            <!-- Soal 2: PG Multi -->
                            <div class="list-group-item border-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div>
                                        <span class="badge bg-primary-subtle text-primary extra-small me-1">#2</span>
                                        <span class="badge bg-light text-muted extra-small">PG Multi Jawaban</span>
                                    </div>
                                    <span class="extra-small text-muted">Bobot: 3 poin</span>
                                </div>
                                <div class="mb-1">
                                    <strong>Manakah di bawah ini yang termasuk perangkat penyimpanan data?</strong>
                                </div>
                                <ul class="extra-small mb-1">
                                    <li><strong>A. Harddisk ✔</strong></li>
                                    <li><strong>B. SSD ✔</strong></li>
                                    <li>C. Monitor</li>
                                    <li><strong>D. Flashdisk ✔</strong></li>
                                </ul>
                                <div class="extra-small text-muted">
                                    Kunci: <strong>A, B, D</strong> • Skor bisa parsial
                                </div>
                            </div>

                            <!-- Soal 3: Esai Singkat -->
                            <div class="list-group-item border-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div>
                                        <span class="badge bg-success-subtle text-success extra-small me-1">#3</span>
                                        <span class="badge bg-light text-muted extra-small">Esai Singkat</span>
                                    </div>
                                    <span class="extra-small text-muted">Bobot: 2 poin</span>
                                </div>
                                <div class="mb-1">
                                    <strong>Tuliskan dua contoh sistem operasi komputer!</strong>
                                </div>
                                <div class="extra-small text-muted mb-1">
                                    Contoh jawaban: <em>Windows, Linux</em>
                                </div>
                                <div class="extra-small text-muted">
                                    Penilaian: semi manual (tutor cek cepat)
                                </div>
                            </div>

                            <!-- Soal 4: Esai -->
                            <div class="list-group-item border-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div>
                                        <span class="badge bg-success-subtle text-success extra-small me-1">#4</span>
                                        <span class="badge bg-light text-muted extra-small">Esai</span>
                                    </div>
                                    <span class="extra-small text-muted">Bobot: 5 poin</span>
                                </div>
                                <div class="mb-1">
                                    <strong>Jelaskan langkah-langkah membuat surat resmi di Ms Word, mulai dari membuka aplikasi hingga menyimpan file.</strong>
                                </div>
                                <div class="extra-small text-muted">
                                    Penilaian: manual oleh tutor, ada kolom rubrik nilai di halaman koreksi.
                                </div>
                            </div>

                            <!-- Soal 5: Skala -->
                            <div class="list-group-item border-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div>
                                        <span class="badge bg-warning-subtle text-warning extra-small me-1">#5</span>
                                        <span class="badge bg-light text-muted extra-small">Skala (Likert)</span>
                                    </div>
                                    <span class="extra-small text-muted">Bobot: 1 poin</span>
                                </div>
                                <div class="mb-1">
                                    <strong>Saya merasa percaya diri menggunakan komputer untuk pekerjaan kantor.</strong>
                                </div>
                                <div class="extra-small text-muted">
                                    Skala: 1–5 (Sangat Tidak Setuju s.d. Sangat Setuju)
                                </div>
                            </div>

                            <!-- Soal 6: True / False -->
                            <div class="list-group-item border-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div>
                                        <span class="badge bg-warning-subtle text-warning extra-small me-1">#6</span>
                                        <span class="badge bg-light text-muted extra-small">True / False</span>
                                    </div>
                                    <span class="extra-small text-muted">Bobot: 1 poin</span>
                                </div>
                                <div class="mb-1">
                                    <strong>Flashdisk adalah perangkat input utama pada komputer.</strong>
                                </div>
                                <div class="extra-small text-muted">
                                    Kunci: <strong>False</strong>
                                </div>
                            </div>

                            <!-- Soal 7: Matrix / Grid -->
                            <div class="list-group-item border-0">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div>
                                        <span class="badge bg-info-subtle text-info extra-small me-1">#7</span>
                                        <span class="badge bg-light text-muted extra-small">Matrix / Grid</span>
                                    </div>
                                    <span class="extra-small text-muted">Bobot: 3 poin</span>
                                </div>
                                <div class="mb-1">
                                    <strong>Nilai tingkat penguasaan kamu terhadap topik berikut:</strong>
                                </div>
                                <div class="extra-small text-muted">
                                    Baris: <em>Ms Word Dasar, Ms Excel Dasar, Internet & Email</em><br>
                                    Kolom: <em>1 (Belum paham) – 5 (Sangat paham)</em>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: DETAIL & INFO -->
                    <div class="col-lg-5">
                        <div class="border rounded-3 p-3 mb-3">
                            <h6 class="fw-semibold extra-small mb-2">Info Singkat Ujian</h6>
                            <dl class="row extra-small mb-0">
                                <dt class="col-4 text-muted">Ujian</dt>
                                <dd class="col-8 mb-1">Ujian Tengah – Operator Komputer</dd>

                                <dt class="col-4 text-muted">Total soal</dt>
                                <dd class="col-8 mb-1">50 (7 tipe dicontohkan di sini)</dd>

                                <dt class="col-4 text-muted">Durasi</dt>
                                <dd class="col-8 mb-1">60 menit</dd>

                                <dt class="col-4 text-muted">Mode</dt>
                                <dd class="col-8 mb-1">Linear + soal acak (dummy)</dd>
                            </dl>
                        </div>

                        <div class="border rounded-3 p-3 extra-small bg-light-subtle">
                            <h6 class="fw-semibold extra-small mb-2">Catatan Implementasi (untuk backend nanti)</h6>
                            <ul class="mb-0 ps-3">
                                <li>Setiap soal punya <strong>tipe</strong> (PG, PG Multi, Esai, Skala, dll).</li>
                                <li>Untuk PG & PG Multi, kunci jawaban disimpan sebagai array pilihan benar.</li>
                                <li>Untuk Skala & Matrix, nilai bisa dikonversi ke skor numerik.</li>
                                <li>Esai & Esai Singkat memerlukan halaman koreksi terpisah.</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button type="button" class="btn btn-primary btn-sm" disabled>
                    <i class="bi bi-save me-1"></i> Simpan perubahan (Demo)
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
