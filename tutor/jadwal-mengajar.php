<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$user         = current_user();
$title        = 'Jadwal Mengajar';
$currentPage  = 'kelas-aktif'; // Tetap highlight menu ini jika diinginkan, atau buat 'jadwal-mengajar'
$roleBasePath = '/tutor';
$baseUrl      = '/siakad';

// --- SETUP DATE & TIMELINE ---
$anchorDateStr = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$anchorDate    = new DateTime($anchorDateStr);

// Generate Range: Today - 1 day to Today + 6 days (Total 8 days view) or based on selected date
$startDate = (clone $anchorDate)->modify('-1 day');
$endDate   = (clone $anchorDate)->modify('+6 days');

$period = new DatePeriod(
    $startDate,
    new DateInterval('P1D'),
    $endDate->modify('+1 day') // Exclusive
);

// --- DATA MOCKUP JADWAL MENGAJAR TUTOR (EXTENDED) ---
$schedules = [
    [
        'id' => 101,
        'title' => 'Operator Komputer',
        'code' => 'OM-01',
        'room' => 'Lab Komputer 1',
        'date' => date('Y-m-d'), 
        'start' => '08:00',
        'end' => '10:00',
        'color' => 'primary',
        'status' => 'scheduled'
    ],
    [
        'id' => 102,
        'title' => 'Digital Marketing',
        'code' => 'DM-02',
        'room' => 'R-02',
        'date' => date('Y-m-d'), 
        'start' => '13:00',
        'end' => '15:00',
        'color' => 'success',
        'status' => 'scheduled'
    ],
    [
        'id' => 103,
        'title' => 'Desain Grafis',
        'code' => 'DG-01',
        'room' => 'Lab Multimedia',
        'date' => date('Y-m-d', strtotime('+1 day')), 
        'start' => '09:00',
        'end' => '11:00',
        'color' => 'info',
        'status' => 'scheduled'
    ],
    [
        'id' => 104,
        'title' => 'Bahasa Inggris',
        'code' => 'EN-01',
        'room' => 'R-01',
        'date' => date('Y-m-d', strtotime('+2 days')), 
        'start' => '10:00',
        'end' => '12:00',
        'color' => 'warning',
        'status' => 'scheduled'
    ],
    [
        'id' => 105,
        'title' => 'Ms. Excel Lanjutan',
        'code' => 'OM-02',
        'room' => 'Lab Komputer 2',
        'date' => date('Y-m-d', strtotime('-1 day')), 
        'start' => '14:00',
        'end' => '16:00',
        'color' => 'danger',
        'status' => 'completed'
    ]
];

ob_start();
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1">Jadwal Mengajar</h4>
        <p class="text-muted small mb-0">Agenda kelas Anda minggu ini.</p>
    </div>
    <form action="" method="GET" class="d-flex gap-2">
        <input type="date" name="date" class="form-control form-control-sm" value="<?= $anchorDateStr ?>" onchange="this.form.submit()">
        <?php if($anchorDateStr !== date('Y-m-d')): ?>
            <a href="?date=<?= date('Y-m-d') ?>" class="btn btn-primary btn-sm text-nowrap">
                Hari Ini
            </a>
        <?php endif; ?>
    </form>
</div>

<!-- Agenda List View -->
<div class="row g-4">
    <div class="col-lg-8">
        <?php 
        $hasSchedule = false;
        foreach ($period as $dt): 
            $currDate = $dt->format('Y-m-d');
            $isToday = ($currDate === date('Y-m-d'));
            
            // Filter Schedules for this date
            $daySchedules = array_filter($schedules, function($s) use ($currDate) {
                return $s['date'] === $currDate;
            });
            
            // Sort by time
            usort($daySchedules, function($a, $b) {
                return strcmp($a['start'], $b['start']);
            });

            if (empty($daySchedules)) continue;
            $hasSchedule = true;
        ?>
            <div class="card border-0 shadow-sm mb-3 <?= $isToday ? 'border-start border-4 border-primary' : '' ?>">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0 <?= $isToday ? 'text-primary' : 'text-dark' ?>">
                        <?= $dt->format('l, d F Y') ?>
                        <?= $isToday ? '<span class="badge bg-primary-subtle text-primary ms-2">Hari Ini</span>' : '' ?>
                    </h6>
                    <span class="badge bg-light text-muted border"><?= count($daySchedules) ?> Kelas</span>
                </div>
                <div class="list-group list-group-flush">
                    <?php foreach ($daySchedules as $sch): ?>
                        <div class="list-group-item p-3 border-bottom-0">
                            <div class="row align-items-center">
                                <div class="col-3 col-md-2 text-center border-end">
                                    <div class="h5 mb-0 fw-bold text-dark"><?= $sch['start'] ?></div>
                                    <div class="extra-small text-muted"><?= $sch['end'] ?></div>
                                </div>
                                <div class="col-9 col-md-7 ps-3 ps-md-4">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="badge bg-<?= $sch['color'] ?>-subtle text-<?= $sch['color'] ?> rounded-pill px-2 extra-small">
                                            <?= $sch['code'] ?>
                                        </span>
                                        <span class="fw-bold text-dark"><?= $sch['title'] ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-3 text-muted extra-small">
                                        <span><i class="bi bi-geo-alt-fill me-1"></i> <?= $sch['room'] ?></span>
                                        <span><i class="bi bi-person-video3 me-1"></i> Tatap Muka</span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 mt-2 mt-md-0 text-md-end">
                                    <?php if ($sch['status'] === 'scheduled'): ?>
                                        <a href="kelas-aktif.php?id=<?= $sch['id'] ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3 w-100 w-md-auto">
                                            Masuk Kelas
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-light text-muted btn-sm rounded-pill px-3 w-100 w-md-auto" disabled>
                                            <i class="bi bi-check-all me-1"></i> Selesai
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (!$hasSchedule): ?>
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-calendar-x display-1 text-muted opacity-25"></i>
                </div>
                <h5 class="fw-bold text-muted">Tidak ada jadwal</h5>
                <p class="text-muted mb-0">Anda tidak memiliki jadwal mengajar dalam rentang tanggal ini.</p>
                <a href="?date=<?= date('Y-m-d') ?>" class="btn btn-link text-decoration-none mt-2">Kembali ke Hari Ini</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar Info -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Ringkasan Minggu Ini</h6>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small">Total Kelas</span>
                    <span class="fw-bold">5 Kelas</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small">Total Jam</span>
                    <span class="fw-bold">10 Jam</span>
                </div>
                <hr class="my-3">
                <div class="d-grid">
                    <button class="btn btn-light btn-sm text-primary fw-medium">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Download Jadwal PDF
                    </button>
                </div>
            </div>
        </div>
        
        <div class="alert alert-info border-0 shadow-sm d-flex gap-3 align-items-start" role="alert">
            <i class="bi bi-info-circle-fill fs-5 mt-1"></i>
            <div class="small">
                <strong>Catatan:</strong><br>
                Pastikan hadir 15 menit sebelum kelas dimulai. Hubungi admin jika ada perubahan jadwal mendadak.
            </div>
        </div>
    </div>
</div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
