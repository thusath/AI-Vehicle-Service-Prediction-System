<?php
require_once 'db.php';
require_admin();

$q = trim($_GET['q'] ?? '');
$status = trim($_GET['status'] ?? '');
$sql = "SELECT * FROM users WHERE role = 'customer'";
$params = [];
$types = '';

if ($q !== '') {
    $sql .= ' AND (full_name LIKE ? OR email LIKE ? OR phone LIKE ?)';
    $like = '%' . $q . '%';
    array_push($params, $like, $like, $like);
    $types .= 'sss';
}
if ($status !== '') {
    $sql .= ' AND status = ?';
    $params[] = $status;
    $types .= 's';
}
$sql .= ' ORDER BY created_at DESC';
$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$totalUsers = (int) $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='customer'")->fetch_assoc()['total'];
include 'header.php';
?>
<section class="admin-page-head">
    <div class="container">
        <div class="kicker">Administration Panel</div>
        <h1>Registered <span class="gold">Users</span></h1>
        <p>View and delete registered user accounts within the AI-Based Vehicle Service Cost and Time Prediction System.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="admin-count reveal">
            <strong><?= $totalUsers ?></strong>
            <span>Total Registered Users</span>
        </div>
        <div class="admin-split reveal">
            <aside class="admin-photo">
                <img src="images/admin/user-management.jpg" alt="Dark luxury vehicle for user management">
                <div class="admin-photo-copy">
                    <h3>User Management</h3>
                    <p>View registered customers and remove unnecessary accounts from the system.</p>
                </div>
            </aside>
            <div class="admin-records">
                <h2>User Directory</h2>
                <p class="muted">Complete list of registered system users.</p>
                <form class="admin-filter-box row g-2 mb-3" method="get">
                    <div class="col-md-7"><input class="form-control" name="q" value="<?= e($q) ?>" placeholder="Search name, email or phone"></div>
                    <div class="col-md-3"><select class="form-select" name="status"><option value="">All Statuses</option><option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option><option value="disabled" <?= $status === 'disabled' ? 'selected' : '' ?>>Disabled</option></select></div>
                    <div class="col-md-2"><button class="btn btn-gold w-100">Search</button></div>
                </form>
                <div class="table-shell">
                    <table class="lux-table">
                        <thead><tr><th>User</th><th>Email</th><th>Phone</th><th>Role</th><th>Created Date</th><th>Status</th><th>Action</th></tr></thead>
                        <tbody>
                        <?php while ($user = $result->fetch_assoc()): ?>
                            <tr>
                                <td><span class="user-avatar" style="display:inline-grid;width:25px;height:25px;margin-right:6px"><i class="bi bi-person-fill"></i></span><?= e($user['full_name']) ?></td>
                                <td><?= e($user['email']) ?></td><td><?= e($user['phone']) ?></td>
                                <td><span class="pill gold">Customer</span></td><td><?= e($user['created_at']) ?></td>
                                <td><span class="pill <?= $user['status'] === 'active' ? 'green' : 'red' ?>"><?= e($user['status']) ?></span></td>
                                <td><a class="<?= $user['status'] === 'active' ? 'btn-danger-lux' : 'btn-success-lux' ?>" href="actions/toggle_user.php?id=<?= $user['user_id'] ?>"><?= $user['status'] === 'active' ? 'Disable' : 'Enable' ?></a> <a class="btn-danger-lux" href="actions/delete_user.php?id=<?= $user['user_id'] ?>" data-confirm="Delete this customer account?">Delete</a></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>
