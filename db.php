<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'httponly' => true,
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'samesite' => 'Lax',
    ]);

    session_start();
}

date_default_timezone_set('Asia/Colombo');

$conn = new mysqli(
    'localhost',
    'root',
    '',
    'vehicle_service_prediction'
);

if ($conn->connect_error) {
    die('Database connection failed. Import sql/vehicle_service_prediction.sql first.');
}

$conn->set_charset('utf8mb4');

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function go(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function logged(): bool
{
    return isset($_SESSION['user_id']);
}

function is_admin(): bool
{
    return ($_SESSION['role'] ?? '') === 'admin';
}

function require_login(): void
{
    if (!logged()) {
        go('login.php');
    }
}

function require_admin(): void
{
    if (!logged() || !is_admin()) {
        go('login.php');
    }
}

function login_required(): void
{
    require_login();
}

function admin_required(): void
{
    require_admin();
}

function csrf(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf()) . '">';
}

function check_csrf(): void
{
    $sessionToken = $_SESSION['csrf'] ?? '';
    $submittedToken = $_POST['csrf'] ?? '';

    if (!$sessionToken || !hash_equals($sessionToken, $submittedToken)) {
        http_response_code(403);
        die('Security validation failed.');
    }
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = [$type, $message];
}

function pull_flash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);

    return $flash;
}

function notify(
    mysqli $conn,
    int $userId,
    string $title,
    string $message,
    string $type = 'system',
    string $link = 'notifications.php'
): void {
    $stmt = $conn->prepare(
        'INSERT INTO notifications (user_id, title, message, type, action_link)
         VALUES (?, ?, ?, ?, ?)'
    );

    $stmt->bind_param('issss', $userId, $title, $message, $type, $link);
    $stmt->execute();
}

function activity(
    mysqli $conn,
    int $userId,
    string $action,
    string $details = ''
): void {
    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'local';

    $stmt = $conn->prepare(
        'INSERT INTO activity_log (user_id, action, details, ip_address)
         VALUES (?, ?, ?, ?)'
    );

    $stmt->bind_param('isss', $userId, $action, $details, $ipAddress);
    $stmt->execute();
}
