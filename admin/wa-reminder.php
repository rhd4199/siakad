<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$user         = current_user();
$title        = 'WA Reminder';
$currentPage  = 'wa-reminder';
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

// --- MOCK DATA ---

// 1. Data Kelas Hari Ini (Simulasi)
$today_classes = [
    [
        'id' => 1,
        'code' => 'WD-01',
        'program' => 'Web Development',
        'topic' => 'React JS Hooks',
        'time_start' => '08:00',
        'time_end' => '10:00',
        'tutor_id' => 101,
        'tutor_name' => 'Sandhika Galih',
        'tutor_phone' => '628123456789',
        'room' => 'Lab Komputer 1',
        'students_count' => 20,
        'students' => [
            ['id' => 1, 'name' => 'Aditya Pratama', 'phone' => '628123456001'],
            ['id' => 2, 'name' => 'Budi Santoso', 'phone' => '628123456002'],
            ['id' => 3, 'name' => 'Citra Lestari', 'phone' => '628123456003'],
            ['id' => 4, 'name' => 'Dewi Ayu', 'phone' => '628123456004'],
            ['id' => 5, 'name' => 'Erik Firmansyah', 'phone' => '628123456005'],
        ]
    ],
    [
        'id' => 2,
        'code' => 'DM-05',
        'program' => 'Digital Marketing',
        'topic' => 'Facebook Ads Strategy',
        'time_start' => '10:00',
        'time_end' => '12:00',
        'tutor_id' => 102,
        'tutor_name' => 'Eko Kurniawan',
        'tutor_phone' => '628129876543',
        'room' => 'Ruang Teori A',
        'students_count' => 15,
        'students' => [
            ['id' => 11, 'name' => 'Fajar Nugraha', 'phone' => '628123456011'],
            ['id' => 12, 'name' => 'Gita Pertiwi', 'phone' => '628123456012'],
        ]
    ],
    [
        'id' => 3,
        'code' => 'WD-02',
        'program' => 'Web Development Lanjut',
        'topic' => 'Rest API with Express',
        'time_start' => '13:00',
        'time_end' => '15:00',
        'tutor_id' => 101, // Sandhika Galih (Double Job hari ini)
        'tutor_name' => 'Sandhika Galih',
        'tutor_phone' => '628123456789',
        'room' => 'Lab Komputer 2',
        'students_count' => 18
    ],
    [
        'id' => 4,
        'code' => 'GD-03',
        'program' => 'Graphic Design',
        'topic' => 'Adobe Illustrator Basic',
        'time_start' => '15:30',
        'time_end' => '17:30',
        'tutor_id' => 103,
        'tutor_name' => 'Rio Purba',
        'tutor_phone' => '628112233445',
        'room' => 'Studio Desain',
        'students_count' => 12
    ]
];

// 2. Data Jadwal Mingguan Tutor (Simulasi)
$tutor_weekly_schedules = [
    101 => [ // Sandhika
        'name' => 'Sandhika Galih',
        'phone' => '628123456789',
        'schedule' => [
            ['day' => 'Senin', 'date' => date('d M', strtotime('monday this week')), 'time' => '08:00', 'class' => 'Web Dev (WD-01)'],
            ['day' => 'Senin', 'date' => date('d M', strtotime('monday this week')), 'time' => '13:00', 'class' => 'Web Dev Lanjut (WD-02)'],
            ['day' => 'Rabu', 'date' => date('d M', strtotime('wednesday this week')), 'time' => '08:00', 'class' => 'Web Dev (WD-01)'],
            ['day' => 'Jumat', 'date' => date('d M', strtotime('friday this week')), 'time' => '09:00', 'class' => 'Mentoring Project']
        ]
    ],
    102 => [ // Eko
        'name' => 'Eko Kurniawan',
        'phone' => '628129876543',
        'schedule' => [
            ['day' => 'Selasa', 'date' => date('d M', strtotime('tuesday this week')), 'time' => '10:00', 'class' => 'Digital Marketing (DM-05)'],
            ['day' => 'Kamis', 'date' => date('d M', strtotime('thursday this week')), 'time' => '10:00', 'class' => 'Digital Marketing (DM-05)']
        ]
    ],
    103 => [ // Rio
        'name' => 'Rio Purba',
        'phone' => '628112233445',
        'schedule' => [
            ['day' => 'Senin', 'date' => date('d M', strtotime('monday this week')), 'time' => '15:30', 'class' => 'Graphic Design (GD-03)'],
            ['day' => 'Rabu', 'date' => date('d M', strtotime('wednesday this week')), 'time' => '15:30', 'class' => 'Graphic Design (GD-03)']
        ]
    ]
];

// 3. Template Pesan
$templates = [
    'student_daily' => [
        'id' => 'tpl_std_day',
        'name' => 'Pengingat Harian Siswa',
        'content' => "Halo {nama_siswa} 👋\n\nMengingatkan jadwal kelas kamu hari ini:\n📚 Program: {program}\n🔖 Kode: {kode_kelas}\n🕘 Pukul: {jam_mulai} - {jam_selesai}\n🏫 Ruangan: {ruangan}\n\nJangan lupa hadir tepat waktu ya! Semangat belajarnya! 🚀"
    ],
    'tutor_daily' => [
        'id' => 'tpl_tut_day',
        'name' => 'Pengingat Harian Instruktur',
        'content' => "Selamat Pagi Coach {nama_tutor} 👋\n\nBerikut adalah jadwal mengajar Anda hari ini ({tanggal}):\n\n{list_kelas}\n\nMohon persiapkan materi dan hadir 15 menit sebelum kelas dimulai. Terima kasih! 🙏"
    ],
    'tutor_weekly' => [
        'id' => 'tpl_tut_week',
        'name' => 'Jadwal Mingguan Instruktur',
        'content' => "Halo Coach {nama_tutor}, selamat beraktivitas! 🌟\n\nBerikut adalah ringkasan jadwal mengajar Anda minggu ini:\n\n{list_jadwal_mingguan}\n\nSemoga minggu ini menyenangkan! Tetap semangat! 💪"
    ]
];

// --- LOGIC GROUPING TUTOR ---
$tutors_today_grouped = [];
foreach ($today_classes as $cls) {
    $tid = $cls['tutor_id'];
    if (!isset($tutors_today_grouped[$tid])) {
        $tutors_today_grouped[$tid] = [
            'id' => $tid,
            'name' => $cls['tutor_name'],
            'phone' => $cls['tutor_phone'],
            'classes' => []
        ];
    }
    $tutors_today_grouped[$tid]['classes'][] = $cls;
}

ob_start();
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1">WhatsApp Reminder Center</h4>
        <p class="text-muted small mb-0">Kelola pengingat jadwal otomatis untuk siswa dan instruktur.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <div class="d-inline-flex align-items-center bg-white border rounded-pill px-3 py-2 shadow-sm">
            <i class="bi bi-clock text-primary me-2"></i>
            <span class="small fw-medium me-2">Jadwal Blast Otomatis:</span>
            <span class="badge bg-primary rounded-pill">08:00 WIB</span>
        </div>
    </div>
</div>

<!-- Main Tabs -->
<ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active rounded-pill px-4" id="pills-today-tab" data-bs-toggle="pill" data-bs-target="#pills-today" type="button" role="tab">
            <i class="bi bi-calendar-day me-2"></i>Jadwal Hari Ini
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link rounded-pill px-4" id="pills-weekly-tab" data-bs-toggle="pill" data-bs-target="#pills-weekly" type="button" role="tab">
            <i class="bi bi-calendar-week me-2"></i>Mingguan Tutor
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link rounded-pill px-4" id="pills-templates-tab" data-bs-toggle="pill" data-bs-target="#pills-templates" type="button" role="tab">
            <i class="bi bi-chat-text me-2"></i>Template Pesan
        </button>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
    
    <!-- TAB: JADWAL HARI INI -->
    <div class="tab-pane fade show active" id="pills-today" role="tabpanel">
        
        <!-- Sub Tabs for Student vs Tutor -->
        <ul class="nav nav-tabs nav-fill mb-4 border-bottom-0">
            <li class="nav-item">
                <a class="nav-link active border bg-white" data-bs-toggle="tab" href="#today-students">
                    <i class="bi bi-people me-2"></i>Blast ke Siswa (Per Kelas)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link border bg-white ms-2" data-bs-toggle="tab" href="#today-tutors">
                    <i class="bi bi-person-video3 me-2"></i>Blast ke Instruktur (Personal)
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- LIST KELAS (SISWA) -->
            <div class="tab-pane active" id="today-students">
                <div class="row g-4">
                    <?php foreach ($today_classes as $cls): ?>
                    <div class="col-md-6 col-xl-4">
                        <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle"><?= $cls['code'] ?></span>
                                    <span class="badge bg-light text-dark border"><i class="bi bi-clock me-1"></i><?= $cls['time_start'] ?> - <?= $cls['time_end'] ?></span>
                                </div>
                                <h5 class="fw-bold mb-1"><?= $cls['program'] ?></h5>
                                <p class="text-muted small mb-3"><?= $cls['topic'] ?></p>
                                
                                <div class="d-flex align-items-center mb-3 bg-light rounded p-2">
                                    <div class="avatar-circle bg-white text-primary border me-2 small">
                                        <?= substr($cls['tutor_name'], 0, 2) ?>
                                    </div>
                                    <div class="small">
                                        <div class="fw-medium text-dark"><?= $cls['tutor_name'] ?></div>
                                        <div class="text-muted extra-small">Instruktur</div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center text-muted small mb-3">
                                    <span><i class="bi bi-geo-alt me-1"></i><?= $cls['room'] ?></span>
                                    <span><i class="bi bi-people me-1"></i><?= $cls['students_count'] ?> Siswa</span>
                                </div>

                                <button class="btn btn-success w-100" onclick='openBlastModal("student", <?= json_encode($cls) ?>)'>
                                    <i class="bi bi-whatsapp me-2"></i>Blast ke Peserta
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- LIST INSTRUKTUR (TUTOR) -->
            <div class="tab-pane" id="today-tutors">
                <div class="row g-4">
                    <?php foreach ($tutors_today_grouped as $tutor): ?>
                    <div class="col-md-6 col-xl-4">
                        <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-circle bg-primary text-white me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                        <?= substr($tutor['name'], 0, 2) ?>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0"><?= $tutor['name'] ?></h5>
                                        <div class="small text-muted"><i class="bi bi-whatsapp me-1"></i><?= $tutor['phone'] ?></div>
                                    </div>
                                </div>

                                <div class="bg-light rounded p-3 mb-3">
                                    <div class="small fw-bold text-muted text-uppercase mb-2">Jadwal Mengajar Hari Ini</div>
                                    <?php foreach ($tutor['classes'] as $cls): ?>
                                    <div class="d-flex mb-2 last-no-mb border-bottom pb-2 last-no-border last-no-pb">
                                        <div class="me-3 fw-bold text-dark" style="min-width: 80px;"><?= $cls['time_start'] ?></div>
                                        <div>
                                            <div class="fw-medium text-dark"><?= $cls['program'] ?></div>
                                            <div class="extra-small text-muted"><?= $cls['room'] ?> • <?= $cls['code'] ?></div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>

                                <button class="btn btn-outline-primary w-100" onclick='openBlastModal("tutor_daily", <?= json_encode($tutor) ?>)'>
                                    <i class="bi bi-send me-2"></i>Kirim Jadwal Harian
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: JADWAL MINGGUAN (TUTOR) -->
    <div class="tab-pane fade" id="pills-weekly" role="tabpanel">
        <div class="alert alert-info border-0 d-flex align-items-center mb-4">
            <i class="bi bi-info-circle-fill me-2 fs-4"></i>
            <div>
                Fitur ini digunakan untuk mengirimkan rekap jadwal mengajar mingguan kepada instruktur. 
                Biasanya dikirim setiap hari <strong>Minggu sore</strong> atau <strong>Senin pagi</strong>.
            </div>
        </div>

        <div class="row g-4">
            <?php foreach ($tutor_weekly_schedules as $tid => $tutor): ?>
            <div class="col-md-6 col-xl-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-info text-white me-2 small">
                                    <?= substr($tutor['name'], 0, 2) ?>
                                </div>
                                <h6 class="fw-bold mb-0"><?= $tutor['name'] ?></h6>
                            </div>
                            <span class="badge bg-light text-secondary border"><?= count($tutor['schedule']) ?> Sesi</span>
                        </div>

                        <div class="bg-light rounded p-3 mb-3" style="max-height: 200px; overflow-y: auto;">
                            <?php foreach ($tutor['schedule'] as $sched): ?>
                            <div class="d-flex mb-2 pb-2 border-bottom last-no-border last-no-pb">
                                <div class="text-center me-3" style="min-width: 50px;">
                                    <div class="extra-small fw-bold text-uppercase text-muted"><?= $sched['day'] ?></div>
                                    <div class="fw-bold text-dark"><?= explode(' ', $sched['date'])[0] ?></div>
                                </div>
                                <div>
                                    <div class="fw-medium text-dark small"><?= $sched['class'] ?></div>
                                    <div class="extra-small text-muted"><i class="bi bi-clock me-1"></i><?= $sched['time'] ?></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <button class="btn btn-outline-info w-100" onclick='openBlastModal("tutor_weekly", <?= json_encode($tutor) ?>)'>
                            <i class="bi bi-calendar-week me-2"></i>Kirim Jadwal Mingguan
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- TAB: TEMPLATE PESAN -->
    <div class="tab-pane fade" id="pills-templates" role="tabpanel">
        <div class="row g-4">
            <?php foreach ($templates as $key => $tpl): ?>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 text-primary">
                            <i class="bi bi-file-text me-2"></i><?= $tpl['name'] ?>
                        </h6>
                        <span class="badge bg-light text-muted border font-monospace">ID: <?= $key ?></span>
                    </div>
                    <div class="card-body">
                        <div class="bg-light p-3 rounded border font-monospace small text-muted mb-3" style="white-space: pre-wrap;"><?= $tpl['content'] ?></div>
                        <button class="btn btn-sm btn-outline-secondary" onclick='editTemplate("<?= $key ?>")'>
                            <i class="bi bi-pencil me-1"></i> Edit Template
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>

<!-- MODAL BLAST -->
<div class="modal fade" id="blastModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-whatsapp me-2"></i>Preview & Kirim</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3" id="recipientSummaryGroup">
                    <label class="form-label small fw-bold text-muted">Penerima</label>
                    <input type="text" class="form-control bg-light" id="blastRecipient" readonly>
                </div>
                
                <div class="mb-3 d-none" id="recipientListGroup">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label small fw-bold text-muted mb-0">Pilih Penerima</label>
                        <div class="form-check form-check-sm">
                            <input class="form-check-input" type="checkbox" id="selectAllStudents" checked>
                            <label class="form-check-label small" for="selectAllStudents">Pilih Semua</label>
                        </div>
                    </div>
                    <div class="border rounded bg-white p-2" style="max-height: 200px; overflow-y: auto;" id="studentListContainer">
                        <!-- Student Checkboxes -->
                    </div>
                    <div class="form-text extra-small mt-1" id="selectedCountInfo">Terpilih: 0 Siswa</div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Isi Pesan (Bisa diedit)</label>
                    <textarea class="form-control" id="blastMessage" rows="10" style="font-size: 0.9rem;"></textarea>
                    <div class="form-text extra-small text-end" id="charCount">0 karakter</div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success px-4" onclick="sendBlast()">
                    <i class="bi bi-send-fill me-2"></i>Kirim Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Load templates from PHP to JS
    const templates = <?= json_encode($templates) ?>;

    function openBlastModal(type, data) {
        let recipient = '';
        let message = '';
        let templateKey = '';
        
        // Reset UI
        document.getElementById('recipientListGroup').classList.add('d-none');
        document.getElementById('recipientSummaryGroup').classList.remove('d-none');
        document.getElementById('studentListContainer').innerHTML = '';

        if (type === 'student') {
            recipient = `Siswa Kelas ${data.program} (${data.students_count} Orang)`;
            templateKey = 'student_daily';
            message = templates[templateKey].content
                .replace('{nama_siswa}', '[Nama Siswa]')
                .replace('{program}', data.program)
                .replace('{kode_kelas}', data.code)
                .replace('{jam_mulai}', data.time_start)
                .replace('{jam_selesai}', data.time_end)
                .replace('{ruangan}', data.room);
            
            // Setup Recipient List if students data exists
            if (data.students && data.students.length > 0) {
                document.getElementById('recipientListGroup').classList.remove('d-none');
                document.getElementById('recipientSummaryGroup').classList.add('d-none');
                
                const container = document.getElementById('studentListContainer');
                data.students.forEach(std => {
                    const div = document.createElement('div');
                    div.className = 'form-check mb-1 border-bottom pb-1 last-no-border last-no-pb';
                    div.innerHTML = `
                        <input class="form-check-input student-chk" type="checkbox" value="${std.phone}" id="std_${std.id}" checked data-name="${std.name}">
                        <label class="form-check-label small w-100" for="std_${std.id}" style="cursor:pointer;">
                            <div class="fw-medium">${std.name}</div>
                            <div class="extra-small text-muted">${std.phone}</div>
                        </label>
                    `;
                    container.appendChild(div);
                });

                // Select All Logic
                const selectAll = document.getElementById('selectAllStudents');
                const checkboxes = document.querySelectorAll('.student-chk');
                
                selectAll.checked = true;
                
                selectAll.onclick = function() {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    updateSelectedCount();
                };
                
                checkboxes.forEach(cb => {
                    cb.onclick = function() {
                        const allChecked = document.querySelectorAll('.student-chk:checked').length === checkboxes.length;
                        selectAll.checked = allChecked;
                        updateSelectedCount();
                    };
                });
                
                updateSelectedCount();
            }
        } 
        else if (type === 'tutor_daily') {
            recipient = `Coach ${data.name} (${data.phone})`;
            templateKey = 'tutor_daily';
            
            // Generate list kelas for tutor
            let classList = data.classes.map(c => `- ${c.program} (${c.time_start} - ${c.time_end}) @ ${c.room}`).join('\n');
            
            message = templates[templateKey].content
                .replace('{nama_tutor}', data.name)
                .replace('{tanggal}', new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }))
                .replace('{list_kelas}', classList);
        }
        else if (type === 'tutor_weekly') {
            recipient = `Coach ${data.name} (${data.phone})`;
            templateKey = 'tutor_weekly';

            // Generate list jadwal weekly
            let schedList = data.schedule.map(s => `🗓️ ${s.day}, ${s.date}\n   ⏰ ${s.time} - ${s.class}`).join('\n\n');

            message = templates[templateKey].content
                .replace('{nama_tutor}', data.name)
                .replace('{list_jadwal_mingguan}', schedList);
        }

        document.getElementById('blastRecipient').value = recipient;
        document.getElementById('blastMessage').value = message;
        updateCharCount();
        
        var myModal = new bootstrap.Modal(document.getElementById('blastModal'));
        myModal.show();
    }
    
    function updateSelectedCount() {
        const count = document.querySelectorAll('.student-chk:checked').length;
        document.getElementById('selectedCountInfo').textContent = `Terpilih: ${count} Siswa`;
    }

    function editTemplate(key) {
        alert('Fitur edit template permanen akan menyimpan ke database. Saat ini hanya preview edit sebelum kirim.');
    }

    function sendBlast() {
        // Simulation
        const btn = document.querySelector('#blastModal .btn-success');
        const originalText = btn.innerHTML;
        
        // Check recipients
        let recipientCount = 1;
        let recipientText = 'penerima';
        
        const listGroup = document.getElementById('recipientListGroup');
        if (!listGroup.classList.contains('d-none')) {
            const selected = document.querySelectorAll('.student-chk:checked');
            recipientCount = selected.length;
            recipientText = 'siswa';
            
            if (recipientCount === 0) {
                alert('Pilih minimal 1 penerima!');
                return;
            }
        }
        
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
        btn.disabled = true;

        setTimeout(() => {
            alert(`Berhasil mengirim pesan ke ${recipientCount} ${recipientText}!`);
            btn.innerHTML = originalText;
            btn.disabled = false;
            bootstrap.Modal.getInstance(document.getElementById('blastModal')).hide();
        }, 1500);
    }

    document.getElementById('blastMessage').addEventListener('input', updateCharCount);

    function updateCharCount() {
        const len = document.getElementById('blastMessage').value.length;
        document.getElementById('charCount').textContent = len + ' karakter';
    }
</script>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    .last-no-mb:last-child { margin-bottom: 0 !important; }
    .last-no-border:last-child { border-bottom: 0 !important; }
    .last-no-pb:last-child { padding-bottom: 0 !important; }
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
