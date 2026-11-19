<?php
require_once 'db.php';
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    check_csrf();
    $uid=logged()?(int)$_SESSION['user_id']:null;
    $name=trim($_POST['name']??'');
    $email=strtolower(trim($_POST['email']??''));
    $subject=trim($_POST['subject']??'');
    $message=trim($_POST['message']??'');
    if(!$name||!filter_var($email,FILTER_VALIDATE_EMAIL)||!$message)$msg='Please complete all required fields correctly.';
    else{
        $s=$conn->prepare('INSERT INTO contact_messages(user_id,name,email,subject,message) VALUES(?,?,?,?,?)');
        $s->bind_param('issss',$uid,$name,$email,$subject,$message);
        $s->execute();
        $admins=$conn->query("SELECT user_id FROM users WHERE role='admin' AND status='active'");
        while($a=$admins->fetch_assoc())notify($conn,(int)$a['user_id'],'New Customer Message',$name.' sent a support message.','message','admin_messages.php');
        $msg='Message sent successfully.';
    }
}include 'header.php';
?>

<section class="hero-strip">
<div class="container">
<div class="kicker">Support Centre</div>
<h1>Get In <span class="gold">Touch</span>
</h1>
<p>Contact the administrator for prediction, account or service-related support.</p>
</div>
</section>
<section class="section">
<div class="container">
<div class="feedback-layout">
<div class="support-panel reveal">
<img src="images/support/contact-service.jpg">
<div class="body">
<h3 class="section-title">Customer Support</h3>
<p class="muted">Logged-in messages are linked to your account so you can see admin replies in My Messages.</p>
</div>
</div>
<div class="feedback-box reveal">
<h2 class="section-title">Send A Message</h2><?php if($msg):?>
<div class="alert alert-info"><?=e($msg)?></div><?php endif;
?>
<form method="post"><?=csrf_field()?><div class="row g-3">
<div class="col-md-6">
<input class="form-control" name="name" value="<?=e($_SESSION['full_name']??'')?>" placeholder="Your Name" required>
</div>
<div class="col-md-6">
<input class="form-control" type="email" name="email" placeholder="Your Email" required>
</div>
<div class="col-12">
<input class="form-control" name="subject" placeholder="Subject">
</div>
<div class="col-12">
<textarea class="form-control" rows="6" name="message" placeholder="Message" required>
</textarea>
</div>
<div class="col-12">
<button class="btn btn-gold">Send Message</button>
</div>
</div>
</form>
</div>
</div>
</div>
</section><?php include 'footer.php';
?>
