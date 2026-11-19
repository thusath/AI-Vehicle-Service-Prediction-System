<?php
require_once 'db.php';

$flash = pull_flash();
$unread = 0;
$currentPage = basename($_SERVER['PHP_SELF'] ?? '');

if (logged()) {
    $userId = (int) $_SESSION['user_id'];

    $stmt = $conn->prepare(
        'SELECT COUNT(*) AS total
         FROM notifications
         WHERE user_id = ?
           AND is_read = 0'
    );

    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $unread = (int) $stmt->get_result()->fetch_assoc()['total'];
}

function nav_active(string|array $pages, string $currentPage): string
{
    $pages = (array) $pages;
    return in_array($currentPage, $pages, true) ? ' active' : '';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#07111f">

    <title>Vehicle AI System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div id="loader" class="page-loader" aria-hidden="true">
        <div class="ring"></div>
        <div class="kicker mb-0">Vehicle AI</div>
    </div>

    <nav class="navbar navbar-expand-xl navbar-dark luxury-nav sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php" aria-label="Vehicle AI System home">
                <span class="brand-emblem">
                    <i class="bi bi-car-front-fill"></i>
                </span>

                <span class="brand-copy">
                    <strong>VEHICLE AI SYSTEM</strong>
                    <small>SMART SERVICE PREDICTION</small>
                </span>
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavigation"
                aria-controls="mainNavigation"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="mainNavigation" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto align-items-xl-center">
                    <li class="nav-item">
                        <a class="nav-link<?= nav_active('index.php', $currentPage) ?>" href="index.php">
                            Home
                        </a>
                    </li>

                    <?php if (logged() && !is_admin()): ?>
                        <li class="nav-item">
                            <a class="nav-link<?= nav_active('contact.php', $currentPage) ?>" href="contact.php">
                                Contact
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= nav_active('dashboard.php', $currentPage) ?>" href="dashboard.php">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= nav_active(['prediction.php', 'result.php'], $currentPage) ?>" href="prediction.php">
                                Prediction
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= nav_active(['history.php', 'prediction_details.php', 'compare_predictions.php'], $currentPage) ?>" href="history.php">
                                History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= nav_active('favorites.php', $currentPage) ?>" href="favorites.php">
                                Favorite Vehicles
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= nav_active('my_messages.php', $currentPage) ?>" href="my_messages.php">
                                My Messages
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= nav_active('profile.php', $currentPage) ?>" href="profile.php">
                                Profile
                            </a>
                        </li>
                    <?php elseif (logged() && is_admin()): ?>
                        <li class="nav-item">
                            <a class="nav-link<?= nav_active('admin_dashboard.php', $currentPage) ?>" href="admin_dashboard.php">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= nav_active('admin_search.php', $currentPage) ?>" href="admin_search.php">
                                Search
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= nav_active('admin_analytics.php', $currentPage) ?>" href="admin_analytics.php">
                                Analytics
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link<?= nav_active('contact.php', $currentPage) ?>" href="contact.php">
                                Contact
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (logged()): ?>
                        <li class="nav-item">
                            <a class="nav-link<?= nav_active('notifications.php', $currentPage) ?>" href="notifications.php">
                                Notifications
                                <?php if ($unread > 0): ?>
                                    <span class="badge-unread" aria-label="<?= $unread ?> unread notifications">
                                        <?= $unread ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>

                        <li class="nav-item ms-xl-2 my-2 my-xl-0">
                            <a class="user-chip" href="profile.php">
                                <span class="user-avatar">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                                <span class="text-truncate">
                                    <?= e($_SESSION['full_name']) ?>
                                </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link<?= nav_active('login.php', $currentPage) ?>" href="login.php">
                                Login
                            </a>
                        </li>

                        <li class="nav-item ms-xl-2 my-2 my-xl-0">
                            <a class="btn btn-gold" href="register.php">
                                Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php if ($flash): ?>
        <div class="toastbox" role="status" aria-live="polite">
            <?= e($flash[1]) ?>
        </div>
    <?php endif; ?>

    <main class="site-main">
