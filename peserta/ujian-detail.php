<?php
require_once __DIR__ . '/../config.php';
require_login(['peserta']);

$user         = current_user();
$kodeUjian    = $_GET['kode'] ?? 'TRYOUT-DM02';
$namaUjian    = 'Tryout TPA – Digital Marketing';
$title        = 'Ruang Ujian: ' . $namaUjian;
$currentPage  = 'tugas';
$roleBasePath = '/peserta';
$baseUrl      = '/siakad';

ob_start();
?>
<style>
    /* Sedikit styling tambahan khusus ruang ujian */
    .exam-topbar {
        position: sticky;
        top: 0;
        z-index: 20;
        background: linear-gradient(90deg, #ffffff 0%, #f8fafc 100%);
        border-bottom: 1px solid #e5e7eb;
    }
    .exam-question-nav button.active {
        border-width: 2px;
    }
</style>

<div class="exam-topbar py-2 mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <div class="extra-small text-muted mb-1">
                <a href="<?= $baseUrl . $roleBasePath ?>/tugas.php" class="text-decoration-none">
                    <i class="bi bi-arrow-left-short"></i> Kembali ke daftar ujian
                </a>
            </div>
            <div class="d-flex align-items-center gap-2">
                <h6 class="fw-semibold mb-0 small"><?= htmlspecialchars($namaUjian) ?></h6>
                <span class="badge bg-light text-muted extra-small">
                    <i class="bi bi-lightning-charge me-1"></i> Mode Demo
                </span>
            </div>
            <div class="extra-small text-muted">
                Kelas: DM-02 • TPA & logika dasar (contoh tampilan)
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end">
                <div class="extra-small text-muted">Sisa waktu (dummy)</div>
                <div class="fw-semibold text-danger">
                    <i class="bi bi-alarm me-1"></i> 45:12
                </div>
            </div>
            <button class="btn btn-outline-danger btn-sm" disabled>
                <i class="bi bi-flag-fill me-1"></i> Akhiri ujian (Demo)
            </button>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Area soal -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body small">
                <ul class="nav nav-pills mb-3 exam-question-nav" id="pills-tab" role="tablist">
                    <li class="nav-item me-1" role="presentation">
                        <button class="nav-link active btn btn-sm btn-light"
                                id="soal1-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#soal1"
                                type="button" role="tab">
                            Soal 1
                        </button>
                    </li>
                    <li class="nav-item me-1" role="presentation">
                        <button class="nav-link btn btn-sm btn-light"
                                id="soal2-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#soal2"
                                type="button" role="tab">
                            Soal 2
                        </button>
                    </li>
                    <li class="nav-item me-1" role="presentation">
                        <button class="nav-link btn btn-sm btn-light"
                                id="soal3-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#soal3"
                                type="button" role="tab">
                            Soal 3
                        </button>
                    </li>
                    <li class="nav-item me-1" role="presentation">
                        <button class="nav-link btn btn-sm btn-light"
                                id="soal4-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#soal4"
                                type="button" role="tab">
                            Soal 4
                        </button>
                    </li>
                    <li class="nav-item me-1" role="presentation">
                        <button class="nav-link btn btn-sm btn-light"
                                id="soal5-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#soal5"
                                type="button" role="tab">
                            Soal 5
                        </button>
                    </li>
                    <li class="nav-item me-1" role="presentation">
                        <button class="nav-link btn btn-sm btn-light"
                                id="soal6-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#soal6"
                                type="button" role="tab">
                            Soal 6
                        </button>
                    </li>
                    <li class="nav-item me-1" role="presentation">
                        <button class="nav-link btn btn-sm btn-light"
                                id="soal7-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#soal7"
                                type="button" role="tab">
                            Soal 7
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <!-- Soal 1: Pilihan ganda (single choice) -->
                    <div class="tab-pane fade show active" id="soal1" role="tabpanel" aria-labelledby="soal1-tab">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <div class="extra-small text-muted">
                                Soal <strong>1</strong> dari <strong>50</strong> •
                                <span class="badge bg-light text-muted">
                                    <i class="bi bi-ui-radios me-1"></i> Pilihan ganda
                                </span>
                            </div>
                            <div class="extra-small text-muted">
                                Bobot: 1 poin
                            </div>
                        </div>
                        <h6 class="small fw-semibold mb-2">
                            Sebuah akun Instagram bisnis memiliki penurunan engagement.
                            Langkah pertama yang paling tepat untuk dilakukan adalah…
                        </h6>
                        <p class="extra-small text-muted">
                            Pilih <strong>1 jawaban</strong> yang paling tepat.
                        </p>

                        <div class="list-group small mb-3">
                            <label class="list-group-item d-flex align-items-start">
                                <input class="form-check-input me-2" type="radio" name="soal1" disabled>
                                <span>
                                    <span class="fw-semibold d-block">A. Meningkatkan frekuensi posting tanpa analisis</span>
                                    <span class="extra-small text-muted">
                                        Langsung menambah jumlah konten harian tanpa melihat data sebelumnya.
                                    </span>
                                </span>
                            </label>
                            <label class="list-group-item d-flex align-items-start">
                                <input class="form-check-input me-2" type="radio" name="soal1" disabled>
                                <span>
                                    <span class="fw-semibold d-block">B. Menghapus semua konten lama</span>
                                    <span class="extra-small text-muted">
                                        Membersihkan feed dan memulai dari awal.
                                    </span>
                                </span>
                            </label>
                            <label class="list-group-item d-flex align-items-start">
                                <input class="form-check-input me-2" type="radio" name="soal1" disabled>
                                <span>
                                    <span class="fw-semibold d-block">C. Menganalisis insight dan performa konten terakhir</span>
                                    <span class="extra-small text-muted">
                                        Melihat data konten mana yang perform dan kapan audiens paling aktif.
                                    </span>
                                </span>
                            </label>
                            <label class="list-group-item d-flex align-items-start">
                                <input class="form-check-input me-2" type="radio" name="soal1" disabled>
                                <span>
                                    <span class="fw-semibold d-block">D. Langsung beriklan dengan budget besar</span>
                                    <span class="extra-small text-muted">
                                        Mengandalkan iklan berbayar tanpa evaluasi konten organik.
                                    </span>
                                </span>
                            </label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                <i class="bi bi-arrow-left"></i> Sebelumnya
                            </button>
                            <button class="btn btn-primary btn-sm" disabled>
                                Simpan & lanjut <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Soal 2: Pilihan ganda multi jawaban -->
                    <div class="tab-pane fade" id="soal2" role="tabpanel" aria-labelledby="soal2-tab">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <div class="extra-small text-muted">
                                Soal <strong>2</strong> dari <strong>50</strong> •
                                <span class="badge bg-light text-muted">
                                    <i class="bi bi-ui-checks me-1"></i> Multi jawaban
                                </span>
                            </div>
                            <div class="extra-small text-muted">
                                Bobot: 2 poin
                            </div>
                        </div>
                        <h6 class="small fw-semibold mb-2">
                            Manakah kombinasi konten yang <em>paling seimbang</em> untuk akun edukasi digital marketing?
                        </h6>
                        <p class="extra-small text-muted">
                            Pilih <strong>2 jawaban</strong> yang menurutmu paling tepat.
                        </p>

                        <div class="list-group small mb-3">
                            <label class="list-group-item d-flex align-items-start">
                                <input class="form-check-input me-2" type="checkbox" disabled>
                                <span>
                                    <span class="fw-semibold d-block">A. Konten teori panjang setiap hari</span>
                                    <span class="extra-small text-muted">
                                        Postingan artikel panjang full teori di feed.
                                    </span>
                                </span>
                            </label>
                            <label class="list-group-item d-flex align-items-start">
                                <input class="form-check-input me-2" type="checkbox" disabled>
                                <span>
                                    <span class="fw-semibold d-block">B. Campuran tips singkat, studi kasus, dan testimoni</span>
                                    <span class="extra-small text-muted">
                                        Konten ringan, contoh real, dan bukti sosial.
                                    </span>
                                </span>
                            </label>
                            <label class="list-group-item d-flex align-items-start">
                                <input class="form-check-input me-2" type="checkbox" disabled>
                                <span>
                                    <span class="fw-semibold d-block">C. Hanya upload poster promosi kelas berbayar</span>
                                    <span class="extra-small text-muted">
                                        Fokus jualan tanpa edukasi.
                                    </span>
                                </span>
                            </label>
                            <label class="list-group-item d-flex align-items-start">
                                <input class="form-check-input me-2" type="checkbox" disabled>
                                <span>
                                    <span class="fw-semibold d-block">D. Kombinasi konten edukasi, interaktif, dan behind the scene</span>
                                    <span class="extra-small text-muted">
                                        Memberi nilai, mengajak interaksi, dan membangun kedekatan.
                                    </span>
                                </span>
                            </label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                <i class="bi bi-arrow-left"></i> Sebelumnya
                            </button>
                            <button class="btn btn-primary btn-sm" disabled>
                                Simpan & lanjut <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Soal 3: Esai singkat -->
                    <div class="tab-pane fade" id="soal3" role="tabpanel" aria-labelledby="soal3-tab">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <div class="extra-small text-muted">
                                Soal <strong>3</strong> dari <strong>50</strong> •
                                <span class="badge bg-light text-muted">
                                    <i class="bi bi-chat-dots me-1"></i> Esai singkat
                                </span>
                            </div>
                            <div class="extra-small text-muted">
                                Bobot: 2 poin
                            </div>
                        </div>
                        <h6 class="small fw-semibold mb-2">
                            Jelaskan secara singkat apa yang dimaksud dengan <em>“target audiens”</em>.
                        </h6>
                        <p class="extra-small text-muted">
                            Jawab dalam 1–3 kalimat.
                        </p>

                        <input type="text"
                               class="form-control form-control-sm mb-3"
                               placeholder="Tulis jawaban singkatmu di sini (Demo, tidak tersimpan)"
                               disabled>

                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                <i class="bi bi-arrow-left"></i> Sebelumnya
                            </button>
                            <button class="btn btn-primary btn-sm" disabled>
                                Simpan & lanjut <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Soal 4: Esai panjang -->
                    <div class="tab-pane fade" id="soal4" role="tabpanel" aria-labelledby="soal4-tab">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <div class="extra-small text-muted">
                                Soal <strong>4</strong> dari <strong>50</strong> •
                                <span class="badge bg-light text-muted">
                                    <i class="bi bi-journal-text me-1"></i> Esai
                                </span>
                            </div>
                            <div class="extra-small text-muted">
                                Bobot: 4 poin
                            </div>
                        </div>
                        <h6 class="small fw-semibold mb-2">
                            Tuliskan langkah-langkah menyusun campaign promosi online sederhana untuk
                            sebuah kelas pelatihan yang sedang kamu ikuti.
                        </h6>
                        <p class="extra-small text-muted">
                            Jelaskan minimal 3 langkah, mulai dari riset sampai evaluasi.
                        </p>

                        <textarea class="form-control form-control-sm mb-3"
                                  rows="5"
                                  placeholder="Tulis jawaban esai mu di sini (Demo, tidak tersimpan)"
                                  disabled></textarea>

                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                <i class="bi bi-arrow-left"></i> Sebelumnya
                            </button>
                            <button class="btn btn-primary btn-sm" disabled>
                                Simpan & lanjut <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Soal 5: Skala (Likert / TKP style) -->
                    <div class="tab-pane fade" id="soal5" role="tabpanel" aria-labelledby="soal5-tab">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <div class="extra-small text-muted">
                                Soal <strong>5</strong> dari <strong>50</strong> •
                                <span class="badge bg-light text-muted">
                                    <i class="bi bi-sliders me-1"></i> Skala sikap
                                </span>
                            </div>
                            <div class="extra-small text-muted">
                                Bobot: 1–5 poin (TKP style)
                            </div>
                        </div>
                        <h6 class="small fw-semibold mb-2">
                            Kamu diminta membantu tim membuat konten meski jadwalmu cukup padat.
                            Bagaimana responmu?
                        </h6>
                        <p class="extra-small text-muted mb-2">
                            Pilih jawaban yang paling menggambarkan dirimu.
                        </p>

                        <div class="table-responsive mb-3">
                            <table class="table table-sm align-middle extra-small mb-0">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th class="text-start">Pernyataan</th>
                                        <th>Sangat tidak setuju</th>
                                        <th>Tidak setuju</th>
                                        <th>Netral</th>
                                        <th>Setuju</th>
                                        <th>Sangat setuju</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-start">
                                            Saya akan mencari cara mengatur waktu agar tetap bisa membantu.
                                        </td>
                                        <td class="text-center"><input type="radio" disabled></td>
                                        <td class="text-center"><input type="radio" disabled></td>
                                        <td class="text-center"><input type="radio" disabled></td>
                                        <td class="text-center"><input type="radio" disabled></td>
                                        <td class="text-center"><input type="radio" disabled></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                <i class="bi bi-arrow-left"></i> Sebelumnya
                            </button>
                            <button class="btn btn-primary btn-sm" disabled>
                                Simpan & lanjut <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Soal 6: True / False -->
                    <div class="tab-pane fade" id="soal6" role="tabpanel" aria-labelledby="soal6-tab">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <div class="extra-small text-muted">
                                Soal <strong>6</strong> dari <strong>50</strong> •
                                <span class="badge bg-light text-muted">
                                    <i class="bi bi-toggle-on me-1"></i> Benar / Salah
                                </span>
                            </div>
                            <div class="extra-small text-muted">
                                Bobot: 1 poin
                            </div>
                        </div>
                        <h6 class="small fw-semibold mb-2">
                            “Semakin sering kita posting, semakin pasti penjualan akan naik.”
                        </h6>
                        <p class="extra-small text-muted">
                            Tentukan apakah pernyataan di atas <strong>benar</strong> atau <strong>salah</strong>.
                        </p>

                        <div class="list-group small mb-3">
                            <label class="list-group-item d-flex align-items-center">
                                <input class="form-check-input me-2" type="radio" name="soal6" disabled>
                                <span>Benar</span>
                            </label>
                            <label class="list-group-item d-flex align-items-center">
                                <input class="form-check-input me-2" type="radio" name="soal6" disabled>
                                <span>Salah</span>
                            </label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                <i class="bi bi-arrow-left"></i> Sebelumnya
                            </button>
                            <button class="btn btn-primary btn-sm" disabled>
                                Simpan & lanjut <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Soal 7: Isian angka / numeric -->
                    <div class="tab-pane fade" id="soal7" role="tabpanel" aria-labelledby="soal7-tab">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <div class="extra-small text-muted">
                                Soal <strong>7</strong> dari <strong>50</strong> •
                                <span class="badge bg-light text-muted">
                                    <i class="bi bi-123 me-1"></i> Isian angka
                                </span>
                            </div>
                            <div class="extra-small text-muted">
                                Bobot: 1 poin
                            </div>
                        </div>
                        <h6 class="small fw-semibold mb-2">
                            Sebuah campaign iklan mengeluarkan biaya Rp400.000 dan menghasilkan omzet Rp1.000.000.
                            Berapa persen nilai <em>ROAS</em> (Return On Ad Spend) yang dihasilkan?
                        </h6>
                        <p class="extra-small text-muted">
                            Tulis dalam bentuk angka persen (tanpa tanda %).
                        </p>

                        <div class="input-group input-group-sm mb-3" style="max-width: 220px;">
                            <input type="number" class="form-control" placeholder="Jawaban (Demo)" disabled>
                            <span class="input-group-text">%</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                <i class="bi bi-arrow-left"></i> Sebelumnya
                            </button>
                            <button class="btn btn-primary btn-sm" disabled>
                                Simpan & lanjut <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Sidebar: Navigasi soal & ringkasan -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body small">
                <h6 class="fw-semibold mb-2">Navigasi Soal</h6>
                <div class="mb-2 extra-small text-muted">
                    Klik nomor soal untuk berpindah (mode demo, tidak menyimpan jawaban).
                </div>
                <div class="d-flex flex-wrap gap-1 mb-2">
                    <?php for ($i = 1; $i <= 20; $i++): ?>
                        <button type="button"
                                class="btn btn-sm btn-light"
                                disabled>
                            <?= $i ?>
                        </button>
                    <?php endfor; ?>
                </div>
                <div class="d-flex flex-wrap gap-2 extra-small text-muted">
                    <span><span class="badge bg-secondary-subtle border"> </span> Belum dijawab</span>
                    <span><span class="badge bg-primary-subtle border"> </span> Terjawab</span>
                    <span><span class="badge bg-warning-subtle border"> </span> Ditandai</span>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body small">
                <h6 class="fw-semibold mb-2">Ringkasan Pengerjaan (Dummy)</h6>
                <ul class="list-unstyled extra-small mb-2">
                    <li class="mb-1 d-flex justify-content-between">
                        <span>Total soal</span>
                        <span class="fw-semibold">50</span>
                    </li>
                    <li class="mb-1 d-flex justify-content-between">
                        <span>Sudah dijawab</span>
                        <span class="fw-semibold text-success">12</span>
                    </li>
                    <li class="mb-1 d-flex justify-content-between">
                        <span>Belum dijawab</span>
                        <span class="fw-semibold text-danger">38</span>
                    </li>
                    <li class="mb-1 d-flex justify-content-between">
                        <span>Ditandai</span>
                        <span class="fw-semibold text-warning">3</span>
                    </li>
                </ul>
                <div class="mb-2 extra-small">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Perkiraan progres</span>
                        <span>24%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: 24%;"></div>
                    </div>
                </div>
                <button class="btn btn-outline-success btn-sm w-100" disabled>
                    <i class="bi bi-check2-circle me-1"></i> Cek jawaban sebelum kirim
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body small">
                <h6 class="fw-semibold mb-2">Catatan Penting (Demo)</h6>
                <ul class="extra-small text-muted mb-0 ps-3">
                    <li>Jangan tutup browser saat ujian berlangsung.</li>
                    <li>Di versi final, jawaban tersimpan otomatis setiap beberapa detik.</li>
                    <li>Pengawas bisa memonitor status peserta dari panel admin.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
