<?php
require_once __DIR__ . '/config.php';
require_login();

$user = current_user();

$page = $_GET['page'] ?? 'dummy';
$currentPage = $page;
$title = 'Halaman - ' . ucfirst(str_replace('-', ' ', $page));

ob_start();
?>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-1"><?= htmlspecialchars(ucfirst(str_replace('-', ' ', $page))) ?></h5>
        <p class="text-muted mb-3">
            Ini adalah halaman dummy untuk <strong><?= htmlspecialchars($page) ?></strong>.
            Nantinya di sini bisa diisi form, tabel, dan logic sesuai kebutuhan modul.
        </p>

        <div class="alert alert-info small">
            <strong>Catatan Dev:</strong> Halaman ini hanya template. Kamu bisa copy file ini,
            rename, dan mulai isi dengan form / table sesuai modul (Program, Kelas, Jadwal, dll).
        </div>

        <!-- Contoh: tabel placeholder -->
        <div class="table-responsive mt-3">
            <table class="table table-sm align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Item</th>
                    <th>Deskripsi Singkat</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Contoh Data 1</td>
                    <td>Isi data asli nanti sesuai kebutuhan modul.</td>
                    <td>
                        <button class="btn btn-outline-primary btn-sm" disabled>Edit</button>
                        <button class="btn btn-outline-danger btn-sm" disabled>Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Contoh Data 2</td>
                    <td>Prototype ini belum tersambung ke database.</td>
                    <td>
                        <button class="btn btn-outline-primary btn-sm" disabled>Edit</button>
                        <button class="btn btn-outline-danger btn-sm" disabled>Hapus</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
