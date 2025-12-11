<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$title        = 'Jadwal';
$currentPage  = 'jadwal';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

// --- 1. SETUP DATE & TIMELINE ---
// Default anchor date is Today. 
// View range: 1 day before anchor, anchor, 5 days after.
$anchorDateStr = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$anchorDate    = new DateTime($anchorDateStr);

// Start Date = Anchor - 1 Day
$startDate = (clone $anchorDate)->modify('-1 day');
// End Date = Start Date + 6 Days (Total 7 days)
$endDate   = (clone $startDate)->modify('+6 days');

// Generate Date Array for Header
$dates = [];
$curr  = clone $startDate;
for ($i = 0; $i < 7; $i++) {
    $dates[] = [
        'obj'   => clone $curr,
        'label' => $curr->format('D, d M'),
        'ymd'   => $curr->format('Y-m-d'),
        'is_today' => ($curr->format('Y-m-d') === date('Y-m-d')),
        'is_anchor' => ($curr->format('Y-m-d') === $anchorDateStr)
    ];
    $curr->modify('+1 day');
}

// Navigation Dates
$prevAnchor = (clone $anchorDate)->modify('-1 day')->format('Y-m-d');
$nextAnchor = (clone $anchorDate)->modify('+1 day')->format('Y-m-d');
$todayAnchor = date('Y-m-d');

// Timeline Settings (08:00 - 18:00)
$startHour = 8;
$endHour   = 18;
$totalHours = $endHour - $startHour;

// --- 2. DATA RUANGAN (MOCK) ---
// Should match database in real app
$rooms = [
    ['id' => 1, 'code' => 'R-01', 'name' => 'Ruang Teori A'],
    ['id' => 2, 'code' => 'R-02', 'name' => 'Lab Komputer 1'],
    ['id' => 3, 'code' => 'R-03', 'name' => 'Ruang Diskusi'],
];

// --- 3. FILTER LOGIC ---
$filterRoomId = isset($_GET['room_id']) ? (int)$_GET['room_id'] : null;

// --- 4. DATA JADWAL (MOCK) ---
// In real app: SELECT * FROM schedules WHERE date BETWEEN $startDate AND $endDate
// If filterRoomId is set, add WHERE room_id = ...
$allSchedules = [
    [
        'id' => 101,
        'title' => 'Operator Komputer',
        'code' => 'OM-01',
        'room_id' => 1,
        'room_code' => 'R-01',
        'tutor' => 'Budi S.',
        'date' => date('Y-m-d'), // Today
        'start' => '08:00',
        'end' => '10:00',
        'color' => 'primary',
        'status' => 'scheduled'
    ],
    [
        'id' => 102,
        'title' => 'Digital Marketing',
        'code' => 'DM-02',
        'room_id' => 2,
        'room_code' => 'R-02',
        'tutor' => 'Siti R.',
        'date' => date('Y-m-d'), // Today
        'start' => '10:15',
        'end' => '12:00',
        'color' => 'success',
        'status' => 'scheduled'
    ],
    [
        'id' => 103,
        'title' => 'Barista Dasar',
        'code' => 'BD-01',
        'room_id' => 3,
        'room_code' => 'R-03',
        'tutor' => 'Andi P.',
        'date' => date('Y-m-d', strtotime('-1 day')), // Yesterday
        'start' => '13:00',
        'end' => '15:00',
        'color' => 'warning',
        'status' => 'completed'
    ],
    [
        'id' => 104,
        'title' => 'Web Dev',
        'code' => 'WD-05',
        'room_id' => 2,
        'room_code' => 'R-02',
        'tutor' => 'Sandhika',
        'date' => date('Y-m-d', strtotime('+1 day')), // Tomorrow
        'start' => '09:00',
        'end' => '12:00',
        'color' => 'info',
        'status' => 'scheduled'
    ],
    [
        'id' => 105,
        'title' => 'Rapat Tutor',
        'code' => 'MEET',
        'room_id' => 3,
        'room_code' => 'R-03',
        'tutor' => 'Admin',
        'date' => date('Y-m-d', strtotime('+2 days')),
        'start' => '14:00',
        'end' => '16:00',
        'color' => 'danger',
        'status' => 'scheduled'
    ],
    [
        'id' => 106,
        'title' => 'Ujian Akhir: Operator Komputer',
        'code' => 'UJIAN',
        'room_id' => 1,
        'room_code' => 'R-01',
        'tutor' => 'Pengawas: Budi S.',
        'date' => date('Y-m-d', strtotime('+3 days')),
        'start' => '08:00',
        'end' => '10:00',
        'color' => 'danger',
        'status' => 'scheduled'
    ]
];

// Filter Schedules based on Date Range & Room
$displaySchedules = [];
foreach ($allSchedules as $s) {
    // Check Date Range
    if ($s['date'] < $startDate->format('Y-m-d') || $s['date'] > $endDate->format('Y-m-d')) {
        continue;
    }
    // Check Room Filter
    if ($filterRoomId && $s['room_id'] !== $filterRoomId) {
        continue;
    }
    
    // Calculate Grid Position
    // Column: Find index in $dates
    $colIndex = -1;
    foreach ($dates as $idx => $d) {
        if ($d['ymd'] === $s['date']) {
            $colIndex = $idx;
            break;
        }
    }
    
    if ($colIndex === -1) continue;

    // Row: Calculate offset from 08:00
    // We assume 1 hour = 60px height (arbitrary unit for CSS calc)
    // Actually for CSS Grid, we can use minutes or fractional units.
    // Let's use simple hour logic: Start 8:00 is 0.
    $startTime = new DateTime($s['start']);
    $startRef  = new DateTime($s['start']);
    $startRef->setTime($startHour, 0);
    
    $diffMinutes = ($startTime->getTimestamp() - $startRef->getTimestamp()) / 60;
    $topOffset   = ($diffMinutes / 60); // In Hours
    
    $endTime   = new DateTime($s['end']);
    $durationMinutes = ($endTime->getTimestamp() - $startTime->getTimestamp()) / 60;
    $durationHours   = $durationMinutes / 60;

    $s['col_idx']    = $colIndex; // 0-6
    $s['top_offset'] = $topOffset; // relative to 8:00
    $s['duration']   = $durationHours;
    
    $displaySchedules[] = $s;
}

ob_start();
?>
<style>
    /* Custom Scrollbar for timeline */
    .timeline-wrapper::-webkit-scrollbar { height: 8px; width: 8px; }
    .timeline-wrapper::-webkit-scrollbar-track { background: #f1f1f1; }
    .timeline-wrapper::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
    .timeline-wrapper::-webkit-scrollbar-thumb:hover { background: #aaa; }

    .timeline-container {
        display: grid;
        grid-template-columns: 60px repeat(7, 1fr); /* Time Label + 7 Days */
        /* Rows: Header + Body. Body height based on content. */
        min-width: 1000px; /* Ensure horizontal scroll on small screens */
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }

    /* Header Cells */
    .th-cell {
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        border-right: 1px solid #dee2e6;
        padding: 10px;
        text-align: center;
        font-weight: 600;
        font-size: 0.9rem;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .th-time { border-right: 1px solid #dee2e6; z-index: 11; left: 0; }

    /* Grid Body */
    .grid-body {
        display: contents; /* Flattens children to grid */
    }

    /* Time Labels Column */
    .time-label-col {
        grid-column: 1;
        background: #fcfcfc;
        border-right: 1px solid #dee2e6;
        position: relative;
    }
    .time-marker {
        height: 60px; /* 1 Hour Height */
        border-bottom: 1px solid #eee;
        padding: 5px;
        font-size: 0.75rem;
        color: #888;
        text-align: center;
    }

    /* Day Columns */
    .day-col {
        position: relative;
        border-right: 1px solid #eee;
        background: #fff;
    }
    .day-col:last-child { border-right: none; }
    
    /* Hour Lines in Day Columns */
    .hour-slot {
        height: 60px;
        border-bottom: 1px solid #f5f5f5;
        box-sizing: border-box;
        position: relative;
        cursor: pointer;
        transition: background 0.1s;
    }
    .hour-slot:hover {
        background-color: #f0f8ff; /* Light blue on hover */
    }
    .hour-slot:hover::after {
        content: '+';
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        color: #0d6efd;
        font-size: 1.2rem;
        font-weight: bold;
    }

    /* Schedule Block */
    .sched-block {
        position: absolute;
        left: 2px; right: 2px; /* Margin */
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        z-index: 5;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.1s;
    }
    .sched-block:hover {
        transform: scale(1.02);
        z-index: 6;
    }
    
    .status-completed {
        border: 2px solid #198754 !important; /* Green border */
        opacity: 0.9;
    }
    
    .is-today { background-color: #e8f4ff !important; }
    .is-anchor { border-bottom: 3px solid #0d6efd; }
</style>

<div class="row mb-3 align-items-center">
    <div class="col-md-5">
        <h4 class="fw-bold mb-0">Jadwal</h4>
        <p class="text-muted small mb-0">Timeline 7 Hari (H-1 s/d H+5)</p>
    </div>
    <div class="col-md-7">
        <div class="d-flex gap-2 justify-content-md-end align-items-center">
            <!-- Room Filter -->
            <select class="form-select form-select-sm w-auto shadow-sm" id="roomFilter" onchange="applyFilter()">
                <option value="all" <?= $filterRoomId === null ? 'selected' : '' ?>>Semua Ruangan</option>
                <?php foreach($rooms as $r): ?>
                    <option value="<?= $r['id'] ?>" <?= $filterRoomId === $r['id'] ? 'selected' : '' ?>>
                        <?= $r['code'] ?> - <?= $r['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <!-- Date Navigation -->
            <div class="btn-group shadow-sm">
                <button class="btn btn-white border btn-sm" onclick="goToDate('<?= $prevAnchor ?>')">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-white border btn-sm fw-semibold" onclick="goToDate('<?= $todayAnchor ?>')">
                    Hari Ini
                </button>
                <button class="btn btn-white border btn-sm" onclick="goToDate('<?= $nextAnchor ?>')">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
            
            <!-- Legend Info -->
            <button class="btn btn-outline-secondary btn-sm rounded-circle" data-bs-toggle="tooltip" title="Klik slot kosong untuk tambah jadwal">
                <i class="bi bi-info-lg"></i>
            </button>
        </div>
    </div>
</div>

<?php if(!$filterRoomId): ?>
<div class="alert alert-info py-2 small mb-3 border-0 bg-info-subtle text-info-emphasis">
    <i class="bi bi-lightbulb me-1"></i> 
    Tips: Pilih <strong>Ruangan</strong> spesifik untuk melihat slot kosong dengan lebih akurat dan menambahkan jadwal baru.
</div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0 timeline-wrapper" style="overflow-x: auto;">
        
        <div class="timeline-container">
            <!-- Header Row -->
            <div class="th-cell th-time bg-light">Jam</div>
            <?php foreach($dates as $d): ?>
                <div class="th-cell <?= $d['is_today'] ? 'is-today' : '' ?> <?= $d['is_anchor'] ? 'is-anchor' : '' ?>">
                    <div class="small text-uppercase text-muted"><?= explode(',', $d['label'])[0] ?></div>
                    <div class="fs-5"><?= explode(' ', explode(',', $d['label'])[1])[1] ?></div>
                </div>
            <?php endforeach; ?>

            <!-- Body: Time Column -->
            <div class="time-label-col">
                <?php for($h = $startHour; $h < $endHour; $h++): ?>
                    <div class="time-marker"><?= sprintf("%02d:00", $h) ?></div>
                <?php endfor; ?>
            </div>

            <!-- Body: Day Columns -->
            <?php foreach($dates as $colIdx => $d): ?>
                <div class="day-col <?= $d['is_today'] ? 'bg-light-subtle' : '' ?>" style="grid-column: <?= $colIdx + 2 ?>;">
                    <!-- Render Empty Slots (Visual Helper & Click Targets) -->
                    <?php for($h = 0; $h < $totalHours; $h++): 
                        $slotTime = sprintf("%02d:00", $startHour + $h);
                        $slotDate = $d['ymd'];
                    ?>
                        <div class="hour-slot" 
                             onclick="openAddModal('<?= $slotDate ?>', '<?= $slotTime ?>')"
                             ondrop="drop(event, '<?= $slotDate ?>', '<?= $slotTime ?>')"
                             ondragover="allowDrop(event)"
                             title="Tambah Jadwal <?= $slotTime ?>">
                        </div>
                    <?php endfor; ?>

                    <!-- Render Schedules -->
                    <?php foreach($displaySchedules as $s): 
                        if ($s['col_idx'] !== $colIdx) continue;
                        // Height = Duration * 60px
                        // Top = Offset * 60px
                        $height = $s['duration'] * 60;
                        $top    = $s['top_offset'] * 60;
                        $isCompleted = (isset($s['status']) && $s['status'] === 'completed');
                    ?>
                        <div id="sched-block-<?= $s['id'] ?>" 
                             class="sched-block bg-<?= $s['color'] ?> bg-gradient <?= $isCompleted ? 'status-completed' : '' ?>" 
                             style="top: <?= $top ?>px; height: <?= $height ?>px;"
                             draggable="true"
                             ondragstart="drag(event, <?= $s['id'] ?>, '<?= $s['duration'] ?>')"
                             onclick="event.stopPropagation(); showDetail(<?= $s['id'] ?>)">
                            <div class="fw-bold text-truncate">
                                <?php if($isCompleted): ?>
                                    <i class="bi bi-check-circle-fill text-white me-1"></i>
                                <?php elseif($s['code'] === 'UJIAN'): ?>
                                    <i class="bi bi-file-earmark-text-fill text-white me-1"></i>
                                <?php endif; ?>
                                <?= $s['code'] ?>
                            </div>
                            <div class="small text-truncate opacity-75"><?= $s['room_code'] ?></div>
                            <?php if($height > 40): ?>
                                <div class="extra-small text-truncate mt-1"><?= $s['title'] ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="detailTitle">Detail Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary me-3">
                        <i class="bi bi-journal-text fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold" id="detailClass">Nama Kelas</h5>
                        <div class="text-muted small" id="detailProgram">Program</div>
                    </div>
                </div>
                
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="p-2 border rounded bg-light">
                            <label class="small text-muted d-block">Waktu</label>
                            <span class="fw-semibold" id="detailTime">08:00 - 10:00</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 border rounded bg-light">
                            <label class="small text-muted d-block">Ruangan</label>
                            <span class="fw-semibold" id="detailRoom">R-01</span>
                        </div>
                    </div>
                    <div class="col-12">
                         <div class="p-2 border rounded bg-light">
                            <label class="small text-muted d-block">Tutor</label>
                            <span class="fw-semibold" id="detailTutor">Budi Santoso</span>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <div class="row g-2">
                        <div class="col-6">
                            <button class="btn btn-outline-danger w-100" onclick="updateStatus('cancelled')">
                                <i class="bi bi-x-circle me-1"></i> Batalkan
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-success w-100" onclick="updateStatus('completed')">
                                <i class="bi bi-check-circle me-1"></i> Terlaksana
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-primary" onclick="openEditFromDetail()">
                        <i class="bi bi-pencil me-1"></i> Edit Jadwal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas Add/Edit Schedule -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasSchedule" aria-labelledby="offcanvasScheduleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasScheduleLabel">Form Jadwal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="" method="POST">
            <input type="hidden" id="schedId" name="id">
            
            <div class="mb-3">
                <label class="form-label">Program / Kelas</label>
                <select class="form-select" id="schedClass">
                    <option value="">Pilih Program...</option>
                    <option value="OM-01">OM-01 Operator Komputer</option>
                    <option value="DM-02">DM-02 Digital Marketing</option>
                    <option value="BD-01">BD-01 Barista Dasar</option>
                    <option value="MEET">Rapat Internal</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="schedDate" name="date" required>
            </div>

            <div class="row g-2 mb-3">
                <div class="col-6">
                    <label class="form-label">Jam Mulai</label>
                    <input type="time" class="form-control" id="schedStart" name="start" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Jam Selesai</label>
                    <input type="time" class="form-control" id="schedEnd" name="end" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Ruangan</label>
                <select class="form-select" id="schedRoom" name="room_id" required>
                    <option value="">Pilih Ruangan...</option>
                    <?php foreach($rooms as $r): ?>
                        <option value="<?= $r['id'] ?>"><?= $r['code'] ?> - <?= $r['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tutor / PIC</label>
                <input type="text" class="form-control" id="schedTutor" name="tutor" placeholder="Nama Tutor">
            </div>

            <div class="mb-4">
                <label class="form-label">Catatan</label>
                <textarea class="form-control" rows="3" placeholder="Topik materi atau catatan tambahan..."></textarea>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                <button type="button" class="btn btn-outline-danger" id="btnDelete" style="display:none;">Batalkan Jadwal</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Initialize Bootstrap components
    var bsModalDetail;
    var bsOffcanvas;

    document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById('modalDetail');
        if (modalEl) bsModalDetail = new bootstrap.Modal(modalEl);
        
        const offcanvasEl = document.getElementById('offcanvasSchedule');
        if (offcanvasEl) bsOffcanvas = new bootstrap.Offcanvas(offcanvasEl);
    });

    // Global variable to store current schedule ID for details
    let currentDetailId = null;

    // --- Drag and Drop Logic ---
    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev, id, duration) {
        ev.dataTransfer.setData("text/plain", JSON.stringify({id: id, duration: duration}));
        ev.dataTransfer.effectAllowed = "move";
    }

    function drop(ev, date, time) {
        ev.preventDefault();
        
        let data;
        try {
            data = JSON.parse(ev.dataTransfer.getData("text/plain"));
        } catch (e) {
            return;
        }
        
        const schedId = data.id;
        const schedEl = document.getElementById('sched-block-' + schedId);
        if (!schedEl) return;

        // Determine Drop Target
        let targetSlot = ev.target;
        if (!targetSlot.classList.contains('hour-slot')) {
            targetSlot = targetSlot.closest('.hour-slot');
        }
        
        if (!targetSlot) return; // Drop invalid

        const targetDayCol = targetSlot.parentElement;

        // Calculate new Top position
        // Time format is HH:MM. We assume startHour is 8.
        const [h, m] = time.split(':');
        const hour = parseInt(h);
        const min = parseInt(m);
        
        const startHour = 8; // Must match PHP $startHour
        const offsetHours = (hour - startHour) + (min / 60);
        const newTop = offsetHours * 60; // 60px per hour

        // Move the element in DOM
        if (schedEl.parentElement !== targetDayCol) {
            targetDayCol.appendChild(schedEl);
        }
        
        schedEl.style.top = newTop + 'px';
    }

    // --- Detail & Status Logic ---
    function showDetail(id) {
        currentDetailId = id;
        
        // Mock Data Fetching based on ID
        // In real app: fetch(`/api/schedule/${id}`)
        
        // Let's populate with generic data + ID for demo
        document.getElementById('detailClass').innerText = "Kelas " + (id === 101 ? "Operator Komputer" : "Digital Marketing");
        document.getElementById('detailProgram').innerText = "Program Reguler Batch 1";
        document.getElementById('detailTime').innerText = "08:00 - 10:00 (Senin, 10 Jan)";
        document.getElementById('detailRoom').innerText = "Lab Komputer 1";
        document.getElementById('detailTutor').innerText = "Budi Santoso";

        if (!bsModalDetail) {
             const el = document.getElementById('modalDetail');
             if(el) bsModalDetail = new bootstrap.Modal(el);
        }
        if(bsModalDetail) bsModalDetail.show();
    }

    function updateStatus(status) {
        if(!currentDetailId) return;
        
        const statusText = status === 'cancelled' ? 'Dibatalkan' : 'Terlaksana';
        alert(`Status jadwal #${currentDetailId} diubah menjadi: ${statusText}`);
        if(bsModalDetail) bsModalDetail.hide();
    }

    function openEditFromDetail() {
        if(bsModalDetail) bsModalDetail.hide();
        // Wait for modal to hide then show offcanvas
        setTimeout(() => {
            editSchedule(currentDetailId);
        }, 300);
    }

    // --- Existing Functions ---
    function applyFilter() {
        const roomId = document.getElementById('roomFilter').value;
        const urlParams = new URLSearchParams(window.location.search);
        
        if (roomId === 'all') {
            urlParams.delete('room_id');
        } else {
            urlParams.set('room_id', roomId);
        }
        window.location.search = urlParams.toString();
    }

    function goToDate(dateStr) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('date', dateStr);
        window.location.search = urlParams.toString();
    }

    function resetForm() {
        document.getElementById('schedId').value = '';
        document.getElementById('schedClass').value = '';
        document.getElementById('schedDate').value = '';
        document.getElementById('schedStart').value = '';
        document.getElementById('schedEnd').value = '';
        document.getElementById('schedRoom').value = '';
        document.getElementById('schedTutor').value = '';
        document.getElementById('offcanvasScheduleLabel').innerText = 'Tambah Jadwal Baru';
        document.getElementById('btnDelete').style.display = 'none';
    }

    function openAddModal(date, time) {
        resetForm();
        document.getElementById('schedDate').value = date;
        document.getElementById('schedStart').value = time;
        
        // Auto set end time + 2 hours
        let [hours, mins] = time.split(':');
        let endHours = parseInt(hours) + 2;
        if (endHours > 23) endHours = 23;
        document.getElementById('schedEnd').value = String(endHours).padStart(2, '0') + ':' + mins;

        // Pre-select room if filtered
        const urlParams = new URLSearchParams(window.location.search);
        const filterRoom = urlParams.get('room_id');
        if(filterRoom) {
            document.getElementById('schedRoom').value = filterRoom;
        }

        if (!bsOffcanvas) {
            const el = document.getElementById('offcanvasSchedule');
            if(el) bsOffcanvas = new bootstrap.Offcanvas(el);
        }
        if(bsOffcanvas) bsOffcanvas.show();
    }

    function editSchedule(id) {
        // In real app, fetch data by ID via AJAX
        // For prototype, we'll just mock it
        resetForm();
        document.getElementById('schedId').value = id;
        document.getElementById('offcanvasScheduleLabel').innerText = 'Edit Jadwal';
        document.getElementById('btnDelete').style.display = 'block';
        
        // Mock fill
        document.getElementById('schedClass').value = 'OM-01'; // Example
        document.getElementById('schedTutor').value = 'Budi Santoso';
        
        if (!bsOffcanvas) {
            const el = document.getElementById('offcanvasSchedule');
            if(el) bsOffcanvas = new bootstrap.Offcanvas(el);
        }
        if(bsOffcanvas) bsOffcanvas.show();
    }
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
