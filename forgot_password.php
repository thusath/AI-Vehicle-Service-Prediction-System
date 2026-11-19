<?php
require_once 'db.php';

$error = '';
$resetLink = '';
$expectedEmail = $_SESSION['reset_login_email'] ?? '';

if (isset($_POST['go'])) {
    check_csrf();

    $email = strtolower(trim($_POST['email'] ?? ''));

    if ($expectedEmail && strcasecmp($expectedEmail, $email) !== 0) {
        $error = 'The email address does not match the email entered on the login page.';
    } else {
        $stmt = $conn->prepare(
            'SELECT user_id
             FROM users
             WHERE email = ?'
        );

        $stmt->bind_param('s', $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if (!$user) {
            $error = 'No account found.';
        } else {
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', time() + 3600);

            $updateStmt = $conn->prepare(
                'UPDATE users
                 SET reset_token = ?,
                     reset_expires = ?
                 WHERE user_id = ?'
            );

            $updateStmt->bind_param(
                'ssi',
                $token,
                $expiry,
                $user['user_id']
            );
            $updateStmt->execute();

            $resetLink = 'reset_password.php?token=' . $token;
        }
    }
}

include 'header.php';
?>

<section class="recovery-page">
    <div class="container">
        <div class="recovery-card reveal">
            <div class="kicker">Account Recovery</div>
            <h1>Forgot Password</h1>
            <p class="intro">
                Confirm the same email you entered on the login page.
            </p>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($resetLink): ?>
                <div class="alert alert-success">
                    Reset link generated successfully.<br>
                    <a class="fw-bold" href="<?= e($resetLink) ?>">
                        Continue to Reset Password
                    </a>
                </div>
            <?php endif; ?>

            <form method="post">
                <?= csrf_field() ?>

                <label class="form-label" for="login_email">Email Entered On Login Page</label>
                <input
                    id="login_email"
                    class="form-control mb-3"
                    type="email"
                    value="<?= e($expectedEmail) ?>"
                    readonly
                >

                <label class="form-label" for="email">Confirm Registered Email</label>
                <input
                    id="email"
                    class="form-control mb-4"
                    type="email"
                    name="email"
                    value="<?= e($expectedEmail) ?>"
                    placeholder="Re-enter your email"
                    required
                >

                <button class="btn btn-gold w-100" type="submit" name="go">
                    Generate Reset Link
                </button>
            </form>

            <p class="text-center mt-3 mb-0">
                <a class="gold fw-bold" href="login.php">Back to Login</a>
            </p>
        </div>
    </div>
</section>

<?php
include 'footer.php';
?>
