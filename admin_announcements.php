<?php require_once 'db.php';
require_admin();
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    check_csrf();
    $title=trim($_POST['title']);
    $body=trim($_POST['message']);
    $aid=(int)$_SESSION['user_id'];
    $s=$conn->prepare('INSERT INTO system_announcements(title,message,created_by) VALUES(?,?,?)');
    $s->bind_param('ssi',$title,$body,$aid);
    $s->execute();
    $r=$conn->query("SELECT user_id FROM users WHERE role='customer' AND status='active'");
    while($u=$r->fetch_assoc())notify($conn,(int)$u['user_id'],$title,$body,'system_update','notifications.php');
    $msg='Announcement broadcast successfully.';
}$r=$conn->query('SELECT * FROM system_announcements ORDER BY created_at DESC');
include 'header.php';
?>
<section class="hero-strip">
<div class="container">
<h1>System <span class="gold">Announcements</span>
</h1>
</div>
</section>
<section class="section">
<div class="container">
<div class="row g-4">
<div class="col-lg-5">
<div class="panel">
<h2 class="section-title">Create Announcement</h2><?php if($msg):?>
<div class="alert alert-success"><?=$msg?></div><?php endif;
?>
<form method="post"><?=csrf_field()?><input class="form-control mb-3" name="title" placeholder="Title" required>
<textarea class="form-control mb-3" rows="6" name="message" placeholder="Message" required>
</textarea>
<button class="btn btn-gold">Broadcast</button>
</form>
</div>
</div>
<div class="col-lg-7">
<div class="panel">
<h2 class="section-title">History</h2><?php while($a=$r->fetch_assoc()):?>
<div class="notify-card">
<h4><?=e($a['title'])?></h4>
<p class="muted"><?=e($a['message'])?></p>
<span class="small-meta"><?=e($a['created_at'])?></span>
</div><?php endwhile;
?>
</div>
</div>
</div>
</div>
</section><?php include 'footer.php';
?>
