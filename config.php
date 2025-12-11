<?php
// config.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$USERS = [
    [
        'email' => 'superadmin@lpk.test',
        'password' => 'super123',
        'role' => 'superadmin',
        'name' => 'Super Admin'
    ],
    [
        'email' => 'admin@lpk.test',
        'password' => 'admin123',
        'role' => 'admin',
        'name' => 'Admin LPK'
    ],
    [
        'email' => 'tutor@lpk.test',
        'password' => 'tutor123',
        'role' => 'tutor',
        'name' => 'Tutor LPK'
    ],
    [
        'email' => 'peserta@lpk.test',
        'password' => 'peserta123',
        'role' => 'peserta',
        'name' => 'Peserta Pelatihan'
    ],
];

function attempt_login(string $email, string $password): bool
{
    global $USERS;

    foreach ($USERS as $user) {
        if (strtolower($user['email']) === strtolower($email) && $user['password'] === $password) {
            $_SESSION['user'] = [
                'email' => $user['email'],
                'name'  => $user['name'],
                'role'  => $user['role'],
            ];
            return true;
        }
    }

    return false;
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function require_login(array $allowedRoles = []): void
{
    $user = current_user();

    if (!$user) {
        header('Location: /login.php');
        exit;
    }

    if (!empty($allowedRoles) && !in_array($user['role'], $allowedRoles)) {
        http_response_code(403);
        echo "<h1>403 Forbidden</h1><p>Anda tidak memiliki akses ke halaman ini.</p>";
        exit;
    }
}

function logout(): void
{
    $_SESSION = [];
    session_destroy();
}
