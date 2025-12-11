<?php
require_once __DIR__ . '/../config.php';
require_login(['superadmin']);

$user         = current_user();
$title        = 'System Logs';
$currentPage  = 'logs';
$roleBasePath = '/superadmin';
$baseUrl      = '/siakad';

// Dummy Logs
$logs = [
    [
        'time' => '2025-12-08 09:15:21',
        'level' => 'INFO',
        'message' => 'Login berhasil',
        'detail' => 'User admin Depati berhasil login',
        'user' => 'admin@depati.test',
        'role' => 'admin',
        'context' => ['LPK' => 'Depati Akademi', 'IP' => '127.0.0.1']
    ],
    [
        'time' => '2025-12-08 08:57:03',
        'level' => 'WARNING',
        'message' => 'Percobaan login gagal',
        'detail' => 'Password salah untuk email admin@smartcourse.test',
        'user' => 'Unknown',
        'role' => '-',
        'context' => ['LPK' => 'Smart Course', 'IP' => '127.0.0.1']
    ],
    [
        'time' => '2025-12-08 08:00:00',
        'level' => 'SYSTEM',
        'message' => 'Cron Job Executed',
        'detail' => 'Daily cleanup & subscription check completed',
        'user' => 'System',
        'role' => 'system',
        'context' => ['Duration' => '0.45s', 'Status' => 'OK']
    ]
];

ob_start();
?>
<style>
    .log-card {
        border-left: 4px solid transparent;
        transition: background-color 0.2s;
    }
    .log-card:hover {
        background-color: #f8f9fa;
    }
    .log-INFO { border-left-color: #0dcaf0; }
    .log-WARNING { border-left-color: #ffc107; }
    .log-ERROR { border-left-color: #dc3545; }
    .log-SYSTEM { border-left-color: #6c757d; }
</style>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h4 class="fw-bold text-primary mb-1">System Audit Logs</h4>
        <p class="text-muted small mb-0">Pantau aktivitas penting, keamanan, dan event sistem secara real-time.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <button class="btn btn-outline-secondary btn-sm shadow-sm rounded-pill px-3">
            <i class="bi bi-download me-1"></i> Export Logs
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-body p-3 bg-light">
        <div class="row g-2">
            <div class="col-md-2">
                <select class="form-select border-0 shadow-sm">
                    <option value="">Level</option>
                    <option>INFO</option>
                    <option>WARNING</option>
                    <option>ERROR</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control border-0 shadow-sm">
            </div>
            <div class="col-md-5">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control border-0" placeholder="Search logs...">
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100 shadow-sm"><i class="bi bi-arrow-clockwise"></i> Refresh</button>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-white border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-muted small text-uppercase fw-bold">Timestamp</th>
                        <th class="text-muted small text-uppercase fw-bold">Level</th>
                        <th class="text-muted small text-uppercase fw-bold">Message</th>
                        <th class="text-muted small text-uppercase fw-bold">User</th>
                        <th class="text-muted small text-uppercase fw-bold">Context</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): 
                        $badgeClass = match($log['level']) {
                            'INFO' => 'bg-info-subtle text-info',
                            'WARNING' => 'bg-warning-subtle text-warning',
                            'ERROR' => 'bg-danger-subtle text-danger',
                            default => 'bg-secondary-subtle text-secondary'
                        };
                    ?>
                    <tr class="log-card log-<?= $log['level'] ?>">
                        <td class="ps-4 py-3 text-nowrap font-monospace small text-muted">
                            <?= $log['time'] ?>
                        </td>
                        <td>
                            <span class="badge <?= $badgeClass ?> rounded-pill px-2"><?= $log['level'] ?></span>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark"><?= $log['message'] ?></div>
                            <div class="extra-small text-muted"><?= $log['detail'] ?></div>
                        </td>
                        <td>
                            <div class="small fw-semibold"><?= $log['user'] ?></div>
                            <div class="extra-small text-muted"><?= $log['role'] ?></div>
                        </td>
                        <td>
                            <?php foreach($log['context'] as $k => $v): ?>
                                <div class="extra-small text-muted"><span class="fw-semibold"><?= $k ?>:</span> <?= $v ?></div>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
