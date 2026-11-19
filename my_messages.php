<?php require_once 'db.php';
require_login();
$uid=(int)$_SESSION['user_id'];
$s=$conn->prepare('SELECT * FROM contact_messages WHERE user_id=? ORDER BY created_at DESC');
$s->bind_param('i',$uid);
$s->execute();
$r=$s->get_result();
include 'header.php';
?>
<section class="hero-strip">
<div class="container">
<div class="kicker">Customer Support</div>
<h1>My <span class="gold">Messages</span>
</h1>
</div>
</section>
<section class="section">
<div class="container"><?php while($m=$r->fetch_assoc()):?>
<div class="message-card reveal">
<div class="d-flex justify-content-between">
<div>
<div class="kicker"><?=e($m['status'])?></div>
<h4><?=e($m['subject']?:'No Subject')?></h4>
</div>
<span class="small-meta"><?=e($m['created_at'])?></span>
</div>
<p class="muted">
<b>Your Message</b>
<br><?=nl2br(e($m['message']))?></p><?php if($m['reply']):?>
<div class="tip">
<strong>Admin Reply</strong>
<p><?=nl2br(e($m['reply']))?></p>
</div><?php else:?>
<span class="pill gold">No reply yet</span><?php endif;
?>
</div><?php endwhile;
?>
</div>
</section><?php include 'footer.php';
?>
