<?php
require_once 'db.php';
require_admin();
if($_SERVER['REQUEST_METHOD']==='POST'){
    check_csrf();
    $id=(int)$_POST['message_id'];
    $text=trim($_POST['reply']);
    $aid=(int)$_SESSION['user_id'];
    $s=$conn->prepare("UPDATE contact_messages SET reply=?,replied_by=?,replied_at=NOW(),status='replied' WHERE message_id=?");
    $s->bind_param('sii',$text,$aid,$id);
    $s->execute();
    $u=$conn->prepare('SELECT user_id FROM contact_messages WHERE message_id=?');
    $u->bind_param('i',$id);
    $u->execute();
    $row=$u->get_result()->fetch_assoc();
    if($row&&$row['user_id'])notify($conn,(int)$row['user_id'],'Admin Reply Received','Admin has replied to your support message.','reply','my_messages.php');
    flash('success','Reply sent successfully.');
    go('admin_messages.php');
}$r=$conn->query('SELECT * FROM contact_messages ORDER BY created_at DESC');
$total=$r->num_rows;
$pending=(int)$conn->query("SELECT COUNT(*) c FROM contact_messages WHERE status='pending'")->fetch_assoc()['c'];
$replied=(int)$conn->query("SELECT COUNT(*) c FROM contact_messages WHERE status='replied'")->fetch_assoc()['c'];
include 'header.php';
?>
<section class="admin-page-head"><div class="container"><div class="kicker">Administration Panel</div><h1>User <span class="gold">Messages</span></h1><p>Review all customer inquiries, monitor pending support requests, and send replies directly from the administrator message center.</p></div></section><section class="section"><div class="container"><div class="row g-3 mb-4"><?php foreach ([['Total Messages',$total],['Pending Messages',$pending],['Replied Messages',$replied]] as $item): ?><div class="col-md-4"><div class="admin-count mb-0"><strong><?= $item[1] ?></strong><span><?= $item[0] ?></span></div></div><?php endforeach; ?></div><div class="admin-message-layout"><aside class="admin-support reveal"><img src="images/admin/messages-headlight.jpg" alt="Vehicle headlight support control"><div class="body"><h3>Support Control</h3><p>Manage customer communication professionally and ensure every inquiry receives a clear admin response.</p><ul><li>View customer messages</li><li>Reply to inquiries</li><li>Track pending messages</li><li>Support prediction users</li></ul></div></aside><div><?php while ($m=$r->fetch_assoc()): ?><article class="admin-message-card reveal"><span class="message-status pill <?= $m['status']==='replied'?'green':'gold' ?>"><?= e($m['status']) ?></span><h3><?= e($m['subject'] ?: 'No Subject') ?></h3><span class="small-meta">Received on: <?= e($m['created_at']) ?></span><div class="message-info-grid"><div class="message-info"><strong>Name</strong><span><?= e($m['name']) ?></span></div><div class="message-info"><strong>Email</strong><span><?= e($m['email']) ?></span></div></div><div class="message-inset"><strong class="gold">Customer Message:</strong><br><?= nl2br(e($m['message'])) ?></div><?php if ($m['reply']): ?><div class="message-inset reply"><strong>Previous Reply:</strong><br><?= nl2br(e($m['reply'])) ?></div><?php endif; ?><form method="post"><?= csrf_field() ?><input type="hidden" name="message_id" value="<?= $m['message_id'] ?>"><textarea class="form-control" rows="3" name="reply" required><?= e($m['reply']) ?></textarea><button class="btn btn-gold mt-2">Send Reply</button></form></article><?php endwhile; ?></div></div></div></section><?php include 'footer.php'; ?>