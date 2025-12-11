<?php
require_once __DIR__ . '/../config.php';
require_login(['peserta']);

$user         = current_user();
$title        = 'Jadwal Saya';
$currentPage  = 'jadwal';
$roleBasePath = '/peserta';
$baseUrl      = '/siakad';

// Simulated Schedule Data
$upcomingSchedules = [
    [
        'date' => date('Y-m-d'), // Today
        'items' => [
            [
                'type' => 'class',
                'title' => 'Operator Komputer - Pertemuan 5',
                'time' => '08:00 - 10:00',
                'location' => 'Lab Komputer 1',
                'tutor' => 'Budi Santoso',
                'status' => 'upcoming'
            ],
            [
                'type' => 'exam',
                'title' => 'Ujian Tengah Semester',
                'time' => '13:00 - 14:30',
                'location' => 'Online',
                'status' => 'active'
            ]
        ]
    ],
    [
        'date' => date('Y-m-d', strtotime('+1 day')), // Tomorrow
        'items' => [
            [
                'type' => 'class',
                'title' => 'Digital Marketing - SEO Basic',
                'time' => '10:00 - 12:00',
                'location' => 'Lab Multimedia',
                'tutor' => 'Siti Aminah',
                'status' => 'upcoming'
            ]
        ]
    ],
    [
        'date' => date('Y-m-d', strtotime('+3 days')),
        'items' => [
            [
                'type' => 'class',
                'title' => 'Operator Komputer - Pertemuan 6',
                'time' => '08:00 - 10:00',
                'location' => 'Lab Komputer 1',
                'tutor' => 'Budi Santoso',
                'status' => 'upcoming'
            ]
        ]
    ]
];

// --- Calendar Logic Setup ---
$currentMonth = date('n');
$currentYear  = date('Y');
$monthName    = date('F Y');
$daysInMonth  = date('t');
$firstDayOfWeek = date('w', strtotime("$currentYear-$currentMonth-01")); // 0 (Sun) - 6 (Sat)

// Flatten events for O(1) lookup in calendar
$eventsMap = [];
foreach ($upcomingSchedules as $schedule) {
    $eventsMap[$schedule['date']] = $schedule['items'];
}

ob_start();
?>
<style>
    /* Full Calendar Styles */
    .calendar-day {
        height: 120px;
        vertical-align: top;
        font-size: 0.9rem;
        transition: background-color 0.2s;
    }
    .calendar-day:hover {
        background-color: #f8f9fa;
    }
    .calendar-day.today {
        background-color: #fff9e6;
    }
    .calendar-day .day-number {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }
    
    /* Mini Calendar Styles */
    .mini-calendar td, .mini-calendar th {
        padding: 0.5rem;
        font-size: 0.85rem;
        text-align: center;
        vertical-align: middle;
    }
    .mini-calendar .today-circle {
        background-color: #0d6efd;
        color: white;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    .event-dot {
        height: 5px;
        width: 5px;
        background-color: #dc3545;
        border-radius: 50%;
        display: inline-block;
        margin-top: 2px;
    }
</style>

<div class="row mb-4 align-items-center">
    <div class="col-lg-8">
        <h4 class="fw-bold mb-1">Jadwal Saya</h4>
        <p class="text-muted small mb-0">
            Pantau jadwal kelas dan ujian Anda agar tidak terlewat.
        </p>
    </div>
    <div class="col-lg-4 text-end">
        <div class="btn-group" role="group">
            <input type="radio" class="btn-check" name="viewmode" id="btn-list" autocomplete="off" checked onchange="toggleView('list')">
            <label class="btn btn-outline-secondary btn-sm" for="btn-list"><i class="bi bi-list-ul me-1"></i> List</label>

            <input type="radio" class="btn-check" name="viewmode" id="btn-calendar" autocomplete="off" onchange="toggleView('calendar')">
            <label class="btn btn-outline-secondary btn-sm" for="btn-calendar"><i class="bi bi-calendar3 me-1"></i> Kalender</label>
        </div>
    </div>
</div>

<div class="row">
    <!-- Main Content Area -->
    <div class="col-lg-8">
        
        <!-- LIST VIEW CONTAINER -->
        <div id="view-list">
            <?php foreach ($upcomingSchedules as $schedule): ?>
                <div class="mb-4">
                    <h6 class="fw-bold text-muted mb-3 border-bottom pb-2">
                        <i class="bi bi-calendar-event me-2"></i>
                        <?= date('l, d F Y', strtotime($schedule['date'])) ?>
                        <?php if ($schedule['date'] == date('Y-m-d')): ?>
                            <span class="badge bg-primary-subtle text-primary ms-2">Hari Ini</span>
                        <?php endif; ?>
                    </h6>
                    
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($schedule['items'] as $item): ?>
                            <div class="card border-0 shadow-sm hover-lift transition-all">
                                <div class="card-body p-3">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="rounded-3 d-flex flex-column align-items-center justify-content-center bg-light border" style="width: 70px; height: 70px;">
                                                <?php if ($item['type'] == 'class'): ?>
                                                    <i class="bi bi-easel2 fs-3 text-primary"></i>
                                                <?php else: ?>
                                                    <i class="bi bi-file-earmark-text fs-3 text-danger"></i>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="badge bg-<?= $item['type'] == 'class' ? 'primary' : 'danger' ?>-subtle text-<?= $item['type'] == 'class' ? 'primary' : 'danger' ?> border border-<?= $item['type'] == 'class' ? 'primary' : 'danger' ?>-subtle">
                                                    <?= $item['type'] == 'class' ? 'Kelas' : 'Ujian' ?>
                                                </span>
                                                <span class="text-muted extra-small"><i class="bi bi-clock me-1"></i> <?= $item['time'] ?> WIB</span>
                                            </div>
                                            <h6 class="fw-bold mb-1"><?= $item['title'] ?></h6>
                                            <div class="text-muted small">
                                                <?php if ($item['type'] == 'class'): ?>
                                                    <i class="bi bi-person me-1"></i> <?= $item['tutor'] ?> &bull; <i class="bi bi-geo-alt me-1"></i> <?= $item['location'] ?>
                                                <?php else: ?>
                                                    <i class="bi bi-laptop me-1"></i> Mode: <?= $item['location'] ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto text-end">
                                            <?php if ($item['status'] == 'active'): ?>
                                                <button class="btn btn-primary btn-sm rounded-pill px-3">Masuk</button>
                                            <?php else: ?>
                                                <button class="btn btn-light btn-sm rounded-pill px-3 text-muted" disabled>Belum Mulai</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- CALENDAR VIEW CONTAINER -->
        <div id="view-calendar" class="d-none">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <button class="btn btn-sm btn-light rounded-circle"><i class="bi bi-chevron-left"></i></button>
                        <h5 class="fw-bold mb-0 text-uppercase letter-spacing-1"><?= $monthName ?></h5>
                        <button class="btn btn-sm btn-light rounded-circle"><i class="bi bi-chevron-right"></i></button>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered w-100">
                            <thead class="bg-light">
                                <tr class="text-center small text-muted text-uppercase">
                                    <th class="text-danger" style="width: 14.28%">Minggu</th>
                                    <th style="width: 14.28%">Senin</th>
                                    <th style="width: 14.28%">Selasa</th>
                                    <th style="width: 14.28%">Rabu</th>
                                    <th style="width: 14.28%">Kamis</th>
                                    <th style="width: 14.28%">Jumat</th>
                                    <th style="width: 14.28%">Sabtu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dayCount = 1;
                                echo "<tr>";
                                
                                // Blank cells at start
                                for ($i = 0; $i < $firstDayOfWeek; $i++) {
                                    echo "<td class='bg-light'></td>";
                                }
                                
                                // Days
                                while ($dayCount <= $daysInMonth) {
                                    if (($firstDayOfWeek + $dayCount - 1) % 7 == 0 && $dayCount > 1) {
                                        echo "</tr><tr>";
                                    }
                                    
                                    $currentDateStr = date('Y-m-d', strtotime("$currentYear-$currentMonth-$dayCount"));
                                    $isToday = ($currentDateStr == date('Y-m-d'));
                                    $hasEvents = isset($eventsMap[$currentDateStr]);
                                    
                                    $cellClass = $isToday ? 'today' : '';
                                    $textClass = $isToday ? 'text-primary' : 'text-dark';
                                    
                                    echo "<td class='calendar-day $cellClass'>";
                                    echo "<span class='day-number $textClass'>$dayCount</span>";
                                    
                                    if ($hasEvents) {
                                        foreach ($eventsMap[$currentDateStr] as $evt) {
                                            $badgeColor = $evt['type'] == 'class' ? 'primary' : 'danger';
                                            echo "<div class='d-block badge bg-{$badgeColor}-subtle text-{$badgeColor} border border-{$badgeColor}-subtle text-truncate mb-1 w-100 text-start fw-normal' style='font-size: 0.7rem;' title='{$evt['title']}'>";
                                            echo "<i class='bi bi-circle-fill me-1' style='font-size: 5px; vertical-align: middle;'></i>";
                                            echo $evt['title'];
                                            echo "</div>";
                                        }
                                    }
                                    
                                    echo "</td>";
                                    $dayCount++;
                                }
                                
                                // Blank cells at end
                                while (($firstDayOfWeek + $dayCount - 1) % 7 != 0) {
                                    echo "<td class='bg-light'></td>";
                                    $dayCount++;
                                }
                                echo "</tr>";
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h6 class="fw-bold mb-0">Kalender Akademik</h6>
            </div>
            <div class="card-body p-3">
                <!-- Mini Calendar Implementation -->
                <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                    <small class="fw-bold text-muted"><?= $monthName ?></small>
                </div>
                
                <table class="table table-borderless mini-calendar mb-0">
                    <thead>
                        <tr class="text-center text-muted">
                            <th class="text-danger">M</th><th>S</th><th>S</th><th>R</th><th>K</th><th>J</th><th>S</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $d = 1;
                        $offset = $firstDayOfWeek;
                        echo "<tr>";
                        for ($i = 0; $i < $offset; $i++) echo "<td></td>";
                        
                        while ($d <= $daysInMonth) {
                            if (($offset + $d - 1) % 7 == 0 && $d > 1) echo "</tr><tr>";
                            
                            $dateStr = date('Y-m-d', strtotime("$currentYear-$currentMonth-$d"));
                            $isToday = ($dateStr == date('Y-m-d'));
                            $hasEvent = isset($eventsMap[$dateStr]);
                            
                            echo "<td>";
                            if ($isToday) {
                                echo "<div class='today-circle'>$d</div>";
                            } else {
                                echo "<div>$d</div>";
                            }
                            
                            if ($hasEvent) {
                                echo "<div class='event-dot'></div>";
                            }
                            echo "</td>";
                            
                            $d++;
                        }
                        
                        // Fill remaining
                        while (($offset + $d - 1) % 7 != 0) {
                            echo "<td></td>";
                            $d++;
                        }
                        echo "</tr>";
                        ?>
                    </tbody>
                </table>
                
                <div class="d-flex justify-content-center gap-3 mt-3 extra-small border-top pt-3">
                    <div class="d-flex align-items-center gap-1">
                        <div class="event-dot"></div> <span class="text-muted">Ada Jadwal</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div class="today-circle" style="width: 10px; height: 10px;"></div> <span class="text-muted">Hari Ini</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info border-0 d-flex gap-3 shadow-sm">
            <i class="bi bi-info-circle-fill fs-4 flex-shrink-0"></i>
            <div>
                <div class="fw-bold small">Catatan Penting</div>
                <p class="extra-small mb-0 opacity-75">
                    Jadwal dapat berubah sewaktu-waktu. Pastikan untuk selalu mengecek jadwal H-1 sebelum kelas dimulai. Hubungi admin jika ada jadwal yang bentrok.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleView(view) {
        const listContainer = document.getElementById('view-list');
        const calendarContainer = document.getElementById('view-calendar');
        
        if (view === 'list') {
            listContainer.classList.remove('d-none');
            calendarContainer.classList.add('d-none');
        } else {
            listContainer.classList.add('d-none');
            calendarContainer.classList.remove('d-none');
        }
    }
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
