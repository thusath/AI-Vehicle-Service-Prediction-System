<?php
require_once 'db.php';

$token = $_GET['token'] ?? ($_POST['token'] ?? '');
$error = '';
$success = '';

$stmt = $conn->prepare(
    'SELECT user_id
     FROM users
     WHERE reset_token = ?
       AND reset_expires > NOW()'
);

$stmt->bind_param('s', $token);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    $error = 'Invalid or expired reset link. Please request a new reset link.';
}

if (isset($_POST['go']) && $user) {
    check_csrf();

    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm'] ?? '';

    if ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 8) {
        $error = 'Minimum 8 characters required.';
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $updateStmt = $conn->prepare(
            'UPDATE users
             SET password = ?,
                 reset_token = NULL,
                 reset_expires = NULL
             WHERE user_id = ?'
        );

        $updateStmt->bind_param('si', $passwordHash, $user['user_id']);
        $updateStmt->execute();

        $success = 'Password reset successfully.';
    }
}

include 'header.php';
?>

<section class="recovery-page">
    <div class="container">
        <div class="recovery-card reveal">
            <div class="kicker">Secure Password Reset</div>
            <h1>Reset Password</h1>
            <p class="intro">Create your new password below.</p>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?= e($success) ?>
                    <a class="fw-bold" href="login.php">Login now</a>
                </div>
            <?php elseif ($user): ?>
                <form method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="token" value="<?= e($token) ?>">

                    <label class="form-label" for="password">New Password</label>
                    <input
                        id="password"
                        class="form-control mb-3"
                        type="password"
                        name="password"
                        minlength="8"
                        placeholder="Enter new password"
                        required
                    >

                    <label class="form-label" for="confirm">Confirm Password</label>
                    <input
                        id="confirm"
                        class="form-control mb-4"
                        type="password"
                        name="confirm"
                        minlength="8"
                        placeholder="Confirm new password"
                        required
                    >

                    <button class="btn btn-gold w-100" type="submit" name="go">
                        Reset Password
                    </button>
                </form>
            <?php endif; ?>

            <p class="text-center mt-3 mb-0">
                <a class="gold fw-bold" href="login.php">Back to Login</a>
            </p>
        </div>
    </div>
</section>

<?php
include 'footer.php';
?>
