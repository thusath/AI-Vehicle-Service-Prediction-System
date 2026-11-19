<?php
require_once 'db.php';
require_admin();
if($_SERVER['REQUEST_METHOD']==='POST'){
    check_csrf();
    $id=(int)$_POST['record_id'];
    $text=trim($_POST['admin_reply']);
    $s=$conn->prepare("UPDATE service_records SET admin_reply=?,replied_at=NOW(),status='replied' WHERE record_id=?");
    $s->bind_param('si',$text,$id);
    $s->execute();
    $u=$conn->prepare('SELECT user_id FROM service_records WHERE record_id=?');
    $u->bind_param('i',$id);
    $u->execute();
    $row=$u->get_result()->fetch_assoc();
    if($row)notify($conn,(int)$row['user_id'],'Actual Feedback Reply Received','Admin has replied to your actual service feedback.','feedback_reply','notifications.php');
    flash('success','Feedback reply sent successfully.');
    go('admin_feedback.php');
}$r=$conn->query('SELECT s.*,u.full_name,p.vehicle_brand,p.vehicle_model,p.predicted_cost,p.predicted_duration_hours FROM service_records s JOIN users u ON s.user_id=u.user_id JOIN predictions p ON s.prediction_id=p.prediction_id ORDER BY s.created_at DESC');
include 'header.php';
?>
<section class="section"><div class="container"><h1 class="admin-feedback-title">Actual Service Feedback</h1><p class="muted mb-4">View customer actual service details and reply to feedback.</p><?php while ($f=$r->fetch_assoc()): ?><article class="admin-feedback-card reveal"><h3><?= e($f['vehicle_brand'].' '.$f['vehicle_model']) ?></h3><p><strong>User:</strong> <?= e($f['full_name']) ?></p><p><strong>Predicted Cost:</strong> Rs. <?= number_format($f['predicted_cost'],2) ?></p><p><strong>Actual Cost:</strong> Rs. <?= number_format($f['actual_cost'],2) ?></p><p><strong>Predicted Duration:</strong> <?= number_format($f['predicted_duration_hours'],1) ?> Hours</p><p><strong>Actual Duration:</strong> <?= number_format($f['actual_duration'],2) ?> Hours</p><p><strong>User Note:</strong> <?= e($f['comment']) ?></p><?php if ($f['admin_reply']): ?><div class="reply-view"><strong>Admin Reply:</strong> <?= e($f['admin_reply']) ?></div><?php endif; ?><form method="post"><?= csrf_field() ?><input type="hidden" name="record_id" value="<?= $f['record_id'] ?>"><textarea class="form-control" rows="3" name="admin_reply" placeholder="Thank you for your feedback" required><?= e($f['admin_reply']) ?></textarea><button class="btn btn-gold mt-2">Send Reply</button></form></article><?php endwhile; ?></div></section><?php include 'footer.php'; ?>