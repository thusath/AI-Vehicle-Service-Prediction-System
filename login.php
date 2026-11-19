<?php
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    check_csrf();

    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $_SESSION['reset_login_email'] = $email;

    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'local';

    $attemptStmt = $conn->prepare(
        "SELECT COUNT(*) AS total
         FROM login_attempts
         WHERE email = ?
           AND success = 0
           AND attempted_at > DATE_SUB(NOW(), INTERVAL 10 MINUTE)"
    );

    $attemptStmt->bind_param('s', $email);
    $attemptStmt->execute();
    $failedAttempts = (int) $attemptStmt->get_result()->fetch_assoc()['total'];

    if ($failedAttempts >= 6) {
        $error = 'Too many failed login attempts. Please wait 10 minutes and try again.';
    } else {
        $userStmt = $conn->prepare(
            'SELECT *
             FROM users
             WHERE email = ?'
        );

        $userStmt->bind_param('s', $email);
        $userStmt->execute();
        $user = $userStmt->get_result()->fetch_assoc();

        $passwordCorrect = $user && password_verify($password, $user['password']);
        $successValue = $passwordCorrect ? 1 : 0;

        $logStmt = $conn->prepare(
            'INSERT INTO login_attempts (email, ip_address, success)
             VALUES (?, ?, ?)'
        );

        $logStmt->bind_param('ssi', $email, $ipAddress, $successValue);
        $logStmt->execute();

        if (!$user) {
            $error = 'User not found.';
        } elseif ($user['status'] === 'disabled') {
            $error = 'Your account has been disabled. Please contact admin.';
        } elseif (!$passwordCorrect) {
            $error = 'Invalid password.';
        } else {
            session_regenerate_id(true);

            $_SESSION['user_id'] = (int) $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            activity($conn, (int) $user['user_id'], 'User login');

            go($user['role'] === 'admin' ? 'admin_dashboard.php' : 'dashboard.php');
        }
    }
}

include 'header.php';
?>

<section class="auth-page">
    <div class="container">
        <div class="auth-shell reveal">
            <div class="auth-intro">
                <div>
                    <div class="kicker">Premium AI Vehicle Service Platform</div>

                    <h1>
                        Welcome Back To
                        <span class="gold">Smart Prediction</span>
                    </h1>

                    <p>
                        Login to access your AI-powered car service cost estimation,
                        repair duration prediction, delay risk analysis, and saved prediction history.
                    </p>

                    <ul class="auth-list">
                        <li>Secure customer dashboard</li>
                        <li>AI-based cost and time prediction</li>
                        <li>View previous prediction history</li>
                        <li>Car-only intelligent service estimation</li>
                    </ul>
                </div>
            </div>

            <div class="auth-form">
                <h2>Login</h2>
                <p class="intro">Access your car service prediction dashboard.</p>

                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?= e($error) ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <?= csrf_field() ?>

                    <label class="form-label" for="email">Email Address</label>
                    <input
                        id="email"
                        class="form-control mb-3"
                        type="email"
                        name="email"
                        placeholder="Enter your email address"
                        required
                    >

                    <label class="form-label" for="password">Password</label>
                    <input
                        id="password"
                        class="form-control mb-4"
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >

                    <button class="btn btn-gold w-100" type="submit" name="login">
                        Login
                    </button>
                </form>

                <p class="text-center mt-3 mb-2">
                    <a class="gold fw-bold" href="forgot_password.php">
                        Forgot Password?
                    </a>
                </p>

                <p class="text-center muted mb-0">
                    Don't have an account?
                    <a class="gold fw-bold" href="register.php">Create account</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php';
?>
