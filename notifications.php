<?php
require_once 'db.php';
require_login();

$userId = (int) $_SESSION['user_id'];

$stmt = $conn->prepare(
    'SELECT *
     FROM notifications
     WHERE user_id = ?
     ORDER BY created_at DESC'
);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

include 'header.php';
?>

<section class="hero-strip">
    <div class="container">
        <div class="kicker">System Communication</div>
        <h1>Notification <span class="gold">Hub</span></h1>
        <p>
            Prediction completions, support replies, feedback replies and system updates
            appear here.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="notification-layout">
            <aside class="notification-feature reveal">
                <img
                    src="images/admin/control-centre.jpg"
                    alt="Automotive diagnostic technology representing system notifications"
                >

                <div class="body">
                    <div class="kicker">My Notifications</div>
                    <h2 class="section-title">Stay Updated</h2>
                    <p class="muted">
                        Important prediction results and replies are stored here so they remain
                        available after you leave the page.
                    </p>

                    <a class="btn btn-gold" href="actions/mark_all_read.php">
                        Mark All As Read
                    </a>
                </div>
            </aside>

            <div>
                <?php if ($result->num_rows === 0): ?>
                    <div class="empty-state reveal">
                        <h2 class="section-title">No Notifications</h2>
                        <p>Your notification hub is currently empty.</p>
                    </div>
                <?php endif; ?>

                <?php while ($notification = $result->fetch_assoc()): ?>
                    <article
                        class="notify-card <?= $notification['is_read'] ? '' : 'unread' ?> reveal"
                    >
                        <div class="d-flex flex-wrap justify-content-between gap-3">
                            <div class="flex-grow-1">
                                <div class="kicker"><?= e($notification['type']) ?></div>
                                <h4><?= e($notification['title']) ?></h4>
                                <p class="muted mb-2"><?= e($notification['message']) ?></p>
                                <span class="small-meta"><?= e($notification['created_at']) ?></span>
                            </div>

                            <div class="d-flex flex-column align-items-start gap-2">
                                <?php if (!$notification['is_read']): ?>
                                    <a
                                        class="btn btn-outline-lux"
                                        href="actions/mark_read.php?id=<?= (int) $notification['notification_id'] ?>"
                                    >
                                        Mark As Read
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($notification['action_link'])): ?>
                                    <a
                                        class="btn btn-gold"
                                        href="<?= e($notification['action_link']) ?>"
                                    >
                                        Open
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
