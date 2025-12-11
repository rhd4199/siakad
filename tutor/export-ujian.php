<?php
require_once __DIR__ . '/../config.php';
require_login(['tutor']);

$type = $_GET['type'] ?? 'print'; // 'excel' or 'print' (pdf)
$examId = $_GET['id'] ?? null;

// Dummy Data (Same as penilaian-ujian.php)
$exams = [
    [
        'id' => 'EX-003',
        'title' => 'Ujian Tengah Semester - Desain Grafis',
        'module' => 'Paket Soal C: Teori Warna & Layout',
        'class_name' => 'Desain Grafis - Batch 08',
        'date' => date('d M Y', strtotime('-2 days')),
        'time' => '10:00 - 11:30 WIB',
        'duration' => '90 Menit',
        'total_students' => 12,
        'graded' => 10,
        'status' => 'pending',
        'avg_score' => 85
    ],
    [
        'id' => 'EX-005',
        'title' => 'Kuis Logika Pemrograman',
        'module' => 'Paket Soal F: Python Dasar',
        'class_name' => 'Python Master - Batch 01',
        'date' => date('d M Y', strtotime('-5 days')),
        'time' => '13:00 - 14:00 WIB',
        'duration' => '60 Menit',
        'total_students' => 15,
        'graded' => 15,
        'status' => 'completed',
        'avg_score' => 92
    ]
];

$activeExam = null;
if ($examId) {
    foreach ($exams as $e) {
        if ($e['id'] === $examId) {
            $activeExam = $e;
            break;
        }
    }
}

if (!$activeExam) {
    die("Ujian tidak ditemukan.");
}

// Dummy Students
$students = [
    ['id' => 1, 'name' => 'Andi Saputra', 'submitted_at' => '10:30', 'status' => 'graded', 'score' => 85, 'essay_needs_grading' => false, 'avatar' => 'AS'],
    ['id' => 2, 'name' => 'Budi Gunawan', 'submitted_at' => '10:35', 'status' => 'graded', 'score' => 90, 'essay_needs_grading' => false, 'avatar' => 'BG'],
    ['id' => 3, 'name' => 'Cindy Claudia', 'submitted_at' => '10:40', 'status' => 'pending', 'score' => 0, 'essay_needs_grading' => true, 'avatar' => 'CC'],
    ['id' => 4, 'name' => 'Dedi Mulyadi', 'submitted_at' => '10:42', 'status' => 'pending', 'score' => 0, 'essay_needs_grading' => true, 'avatar' => 'DM'],
    ['id' => 5, 'name' => 'Eka Pertiwi', 'submitted_at' => '10:45', 'status' => 'graded', 'score' => 88, 'essay_needs_grading' => false, 'avatar' => 'EP'],
    ['id' => 6, 'name' => 'Fajar Shodiq', 'submitted_at' => '10:48', 'status' => 'pending', 'score' => 0, 'essay_needs_grading' => true, 'avatar' => 'FS'],
];

if ($type == 'excel') {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Nilai_Ujian_" . str_replace(' ', '_', $activeExam['title']) . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Nilai Ujian</title>
    <?php if ($type != 'excel'): ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: sans-serif; -webkit-print-color-adjust: exact; }
        @media print {
            .no-print { display: none; }
            .card { border: none !important; box-shadow: none !important; }
        }
    </style>
    <?php endif; ?>
</head>
<body class="bg-white p-4">

    <?php if ($type != 'excel'): ?>
    <div class="no-print mb-4">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i> Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" class="btn btn-secondary">
            Tutup
        </button>
    </div>
    <?php endif; ?>

    <div class="text-center mb-5">
        <h3 style="margin-bottom: 5px; font-weight: bold;"><?= $activeExam['title'] ?></h3>
        <p style="margin: 0; color: #666;"><?= $activeExam['class_name'] ?> | <?= $activeExam['module'] ?></p>
        <p style="margin: 0; color: #666;">Tanggal: <?= $activeExam['date'] ?> | Waktu: <?= $activeExam['time'] ?></p>
    </div>

    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse; border-color: #ddd;">
        <thead>
            <tr style="background-color: #f8f9fa;">
                <th style="text-align: left;">No</th>
                <th style="text-align: left;">Nama Peserta</th>
                <th style="text-align: center;">Waktu Submit</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $index => $student): ?>
            <tr>
                <td style="text-align: left;"><?= $index + 1 ?></td>
                <td style="text-align: left;">
                    <strong><?= $student['name'] ?></strong>
                </td>
                <td style="text-align: center;"><?= $student['submitted_at'] ?></td>
                <td style="text-align: center;">
                    <?php if ($student['essay_needs_grading']): ?>
                        <span style="color: #d63384;">Belum Dinilai</span>
                    <?php else: ?>
                        <span style="color: #198754;">Selesai</span>
                    <?php endif; ?>
                </td>
                <td style="text-align: center; font-weight: bold;">
                    <?= $student['score'] > 0 ? $student['score'] : '-' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="background-color: #f8f9fa;">
                <td colspan="4" style="text-align: right; font-weight: bold;">Rata-rata Nilai</td>
                <td style="text-align: center; font-weight: bold; color: #0d6efd;"><?= $activeExam['avg_score'] ?></td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 50px;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 70%;"></td>
                <td style="text-align: center;">
                    <p>Mengetahui,<br>Instruktur Pengampu</p>
                    <br><br><br>
                    <p style="font-weight: bold; text-decoration: underline;"><?= $user['name'] ?? 'Tutor Siakad' ?></p>
                </td>
            </tr>
        </table>
    </div>

    <?php if ($type != 'excel'): ?>
    <script>
        // Auto print logic can be annoying, let user click button
        // window.print();
    </script>
    <?php endif; ?>
</body>
</html>