<?php
require_once __DIR__ . '/../config.php';
require_login(['superadmin']);

$user         = current_user();
$title        = 'Superadmin Dashboard';
$currentPage  = 'dashboard';
$roleBasePath = '/superadmin';
$baseUrl      = '/siakad';

// Dummy Stats
$stats = [
    [
        'label' => 'Total LPK',
        'value' => '4',
        'sub'   => '1 New this month',
        'icon'  => 'bi-buildings-fill',
        'color' => 'primary',
        'bg'    => 'primary-subtle'
    ],
    [
        'label' => 'Total Users',
        'value' => '180',
        'sub'   => 'Across all companies',
        'icon'  => 'bi-people-fill',
        'color' => 'info',
        'bg'    => 'info-subtle'
    ],
    [
        'label' => 'Active Licenses',
        'value' => '3',
        'sub'   => '1 Trial / 0 Expired',
        'icon'  => 'bi-patch-check-fill',
        'color' => 'success',
        'bg'    => 'success-subtle'
    ],
    [
        'label' => 'System Load',
        'value' => '24%',
        'sub'   => 'Optimal Performance',
        'icon'  => 'bi-cpu-fill',
        'color' => 'warning',
        'bg'    => 'warning-subtle'
    ]
];

ob_start();
?>

<style>
    :root {
        --super-gradient: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%); /* Blue-Grey to Teal */
        --card-shadow: 0 5px 15px rgba(0,0,0,0.05);
        --hover-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    /* Animations */
    .fade-in-up {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }
    @keyframes fadeInUp {
        to { opacity: 1; transform: translateY(0); }
    }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }

    /* Custom Elements */
    .welcome-banner {
        background: var(--super-gradient);
        color: white;
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 1rem;
    }
    .welcome-decor {
        position: absolute;
        right: -50px;
        top: -50px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }
    
    .stat-card {
        border: none;
        border-radius: 1rem;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        height: 100%;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.5rem;
    }
    
    .modern-table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
        border-bottom: 2px solid #e9ecef;
    }
</style>

<div class="row g-4">
    <!-- Welcome Section -->
    <div class="col-12 fade-in-up">
        <div class="card welcome-banner p-4 shadow-sm">
            <div class="welcome-decor"></div>
            <div class="d-flex justify-content-between align-items-center position-relative z-1">
                <div>
                    <h2 class="fw-bold mb-1">Superadmin Control Center</h2>
                    <p class="mb-0 opacity-75">Overview of all LPK instances and system health.</p>
                </div>
                <div class="d-none d-md-block text-end">
                    <div class="fs-6 opacity-75"><?= date('l, d F Y') ?></div>
                    <div class="fw-semibold">System v1.0.0 (Prototype)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <?php foreach ($stats as $index => $stat): ?>
    <div class="col-6 col-lg-3 fade-in-up delay-100">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-<?= $stat['bg'] ?> text-<?= $stat['color'] ?>">
                    <i class="bi <?= $stat['icon'] ?>"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;"><?= $stat['label'] ?></div>
                    <div class="fs-4 fw-bold text-dark"><?= $stat['value'] ?></div>
                    <div class="text-<?= $stat['color'] ?> extra-small fw-semibold">
                        <?= $stat['sub'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Main Content Split -->
    <div class="col-lg-8 fade-in-up delay-200">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Registered LPKs</h5>
                <a href="<?= $baseUrl . $roleBasePath ?>/companies.php" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    View All
                </a>
            </div>
            <div class="card-body px-4">
                <div class="table-responsive">
                    <table class="table modern-table align-middle">
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Code</th>
                                <th class="text-center">Admins</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary-subtle text-primary rounded px-2 py-1 fw-bold small">DA</div>
                                        <div>
                                            <div class="fw-semibold text-dark">Depati Akademi</div>
                                            <div class="extra-small text-muted">Created 2024</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border">DEPATI</span></td>
                                <td class="text-center">2</td>
                                <td><span class="badge bg-success-subtle text-success rounded-pill px-2">Active</span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-light text-primary"><i class="bi bi-gear-fill"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-info-subtle text-info rounded px-2 py-1 fw-bold small">SC</div>
                                        <div>
                                            <div class="fw-semibold text-dark">Smart Course</div>
                                            <div class="extra-small text-muted">Created Jan 2025</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border">SMART</span></td>
                                <td class="text-center">1</td>
                                <td><span class="badge bg-warning-subtle text-warning rounded-pill px-2">Trial</span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-light text-primary"><i class="bi bi-gear-fill"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-secondary-subtle text-secondary rounded px-2 py-1 fw-bold small">KM</div>
                                        <div>
                                            <div class="fw-semibold text-dark">Karya Mandiri</div>
                                            <div class="extra-small text-muted">Created Dec 2024</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border">KARYA</span></td>
                                <td class="text-center">1</td>
                                <td><span class="badge bg-danger-subtle text-danger rounded-pill px-2">Inactive</span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-light text-primary"><i class="bi bi-gear-fill"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & System -->
    <div class="col-lg-4 fade-in-up delay-300">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Quick Actions</h5>
                <div class="d-grid gap-2">
                    <a href="<?= $baseUrl . $roleBasePath ?>/companies.php" class="btn btn-primary py-2 shadow-sm">
                        <i class="bi bi-plus-circle me-2"></i> New Company
                    </a>
                    <a href="<?= $baseUrl . $roleBasePath ?>/users.php" class="btn btn-outline-secondary py-2 border-2">
                        <i class="bi bi-person-plus me-2"></i> Add Admin Account
                    </a>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold mb-0">System Activity</h5>
            </div>
            <div class="card-body p-4">
                <div class="timeline">
                    <div class="d-flex gap-3 mb-3">
                        <div class="mt-1 text-primary"><i class="bi bi-circle-fill small"></i></div>
                        <div>
                            <div class="small fw-bold">New Login</div>
                            <div class="extra-small text-muted">Superadmin logged in from 127.0.0.1</div>
                            <div class="extra-small text-muted opacity-75">Just now</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <div class="mt-1 text-success"><i class="bi bi-check-circle-fill small"></i></div>
                        <div>
                            <div class="small fw-bold">Company Created</div>
                            <div class="extra-small text-muted">LPK Karya Mandiri registered</div>
                            <div class="extra-small text-muted opacity-75">2 hours ago</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="mt-1 text-danger"><i class="bi bi-x-circle-fill small"></i></div>
                        <div>
                            <div class="small fw-bold">Failed Login</div>
                            <div class="extra-small text-muted">admin@depati.test (Bad Password)</div>
                            <div class="extra-small text-muted opacity-75">Yesterday</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
