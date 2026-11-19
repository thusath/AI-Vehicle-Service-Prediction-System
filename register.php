<?php
require_once 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();

    $fullName = trim($_POST['full_name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (!$fullName || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter valid registration details.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        $checkStmt = $conn->prepare(
            'SELECT user_id
             FROM users
             WHERE email = ?'
        );

        $checkStmt->bind_param('s', $email);
        $checkStmt->execute();

        if ($checkStmt->get_result()->num_rows > 0) {
            $error = 'Email already registered.';
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $insertStmt = $conn->prepare(
                "INSERT INTO users
                    (full_name, email, phone, password, role, status)
                 VALUES
                    (?, ?, ?, ?, 'customer', 'active')"
            );

            $insertStmt->bind_param(
                'ssss',
                $fullName,
                $email,
                $phone,
                $passwordHash
            );
            $insertStmt->execute();

            $success = 'Registration successful. You can now login.';
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
                        Create Your Service
                        <span class="gold">Prediction Account</span>
                    </h1>

                    <p>
                        Register to access AI-powered car service cost prediction,
                        repair duration estimation, delay risk analysis, and prediction history.
                    </p>

                    <ul class="auth-list">
                        <li>Secure customer account</li>
                        <li>AI-based cost and time prediction</li>
                        <li>Car-only prediction system</li>
                        <li>Prediction history tracking</li>
                    </ul>
                </div>
            </div>

            <div class="auth-form">
                <h2>Create Account</h2>
                <p class="intro">Register to use the car service prediction system.</p>

                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?= e($error) ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <?= e($success) ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <?= csrf_field() ?>

                    <label class="form-label" for="full_name">Full Name</label>
                    <input id="full_name" class="form-control mb-3" name="full_name" required>

                    <label class="form-label" for="email">Email Address</label>
                    <input id="email" class="form-control mb-3" type="email" name="email" required>

                    <label class="form-label" for="phone">Phone Number</label>
                    <input id="phone" class="form-control mb-3" name="phone">

                    <label class="form-label" for="password">Password</label>
                    <input
                        id="password"
                        class="form-control mb-3"
                        type="password"
                        name="password"
                        minlength="8"
                        required
                    >

                    <label class="form-label" for="confirm_password">Confirm Password</label>
                    <input
                        id="confirm_password"
                        class="form-control mb-4"
                        type="password"
                        name="confirm_password"
                        minlength="8"
                        required
                    >

                    <button class="btn btn-gold w-100" type="submit">
                        Register
                    </button>
                </form>

                <p class="text-center muted mt-3 mb-0">
                    Already have an account?
                    <a class="gold fw-bold" href="login.php">Login here</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php';
?>
