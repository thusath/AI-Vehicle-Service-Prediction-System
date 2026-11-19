<?php
require_once 'db.php';
require_login();
$uid=(int)$_SESSION['user_id'];
$pid=(int)($_GET['id']??$_POST['prediction_id']??0);
$msg='';
$s=$conn->prepare('SELECT p.*,v.vehicle_number FROM predictions p JOIN vehicles v ON p.vehicle_id=v.vehicle_id WHERE p.prediction_id=? AND p.user_id=?');
$s->bind_param('ii',$pid,$uid);
$s->execute();
$p=$s->get_result()->fetch_assoc();
if(!$p)die('Prediction not found.');
if($_SERVER['REQUEST_METHOD']==='POST'){
    check_csrf();
    $cost=(float)($_POST['actual_cost']??0);
    $duration=(float)($_POST['actual_duration']??0);
    $rating=(int)($_POST['accuracy_rating']??0);
    $comment=trim($_POST['comment']??'');
    if($cost<0||$duration<0||$rating<1||$rating>5)$msg='Please enter valid actual service details.';
    else{
        $s=$conn->prepare("INSERT INTO service_records(prediction_id,user_id,actual_cost,actual_duration,accuracy_rating,comment,status) VALUES(?,?,?,?,?,?,'pending') ON DUPLICATE KEY UPDATE actual_cost=VALUES(actual_cost),actual_duration=VALUES(actual_duration),accuracy_rating=VALUES(accuracy_rating),comment=VALUES(comment),status='pending'");
        $s->bind_param('iiddis',$pid,$uid,$cost,$duration,$rating,$comment);
        $s->execute();
        $admins=$conn->query("SELECT user_id FROM users WHERE role='admin' AND status='active'");
        while($a=$admins->fetch_assoc())notify($conn,(int)$a['user_id'],'New Actual Service Feedback',$_SESSION['full_name'].' submitted actual service details for '.$p['vehicle_brand'].' '.$p['vehicle_model'].'.','feedback','admin_feedback.php');
        $msg='Actual service details submitted successfully.';
    }
}
include 'header.php';
?>

<section class="hero-strip">
<div class="container">
<div class="kicker">Prediction Accuracy Feedback</div>
<h1>Actual Service <span class="gold">Details</span>
</h1>
</div>
</section>
<section class="section">
<div class="container">
<div class="feedback-layout">
<div class="support-panel reveal">
<img src="images/support/contact-service.jpg">
<div class="body">
<div class="kicker">Prediction Reference</div>
<h3 class="section-title"><?=e($p['vehicle_brand'].' '.$p['vehicle_model'])?></h3>
<p class="muted">Predicted Cost: Rs. <?=number_format($p['predicted_cost'],0)?><br>Predicted Duration: <?=number_format($p['predicted_duration_hours'],1)?>h</p>
</div>
</div>
<div class="feedback-box reveal">
<h2 class="section-title">Submit Actual Service Details</h2><?php if($msg):?>
<div class="alert alert-info"><?=e($msg)?></div><?php endif;
?>
<form method="post"><?=csrf_field()?><input type="hidden" name="prediction_id" value="<?=$pid?>">
<div class="row g-3">
<div class="col-md-6">
<label class="form-label">Actual Service Cost</label>
<input class="form-control" type="number" min="0" step=".01" name="actual_cost" required>
</div>
<div class="col-md-6">
<label class="form-label">Actual Service Duration</label>
<input class="form-control" type="number" min="0" step=".1" name="actual_duration" required>
</div>
<div class="col-md-6">
<label class="form-label">Accuracy Rating</label>
<select class="form-select" name="accuracy_rating">
<option value="5">5 - Excellent</option>
<option value="4">4 - Good</option>
<option value="3">3 - Average</option>
<option value="2">2 - Poor</option>
<option value="1">1 - Very Poor</option>
</select>
</div>
<div class="col-12">
<label class="form-label">Comments</label>
<textarea class="form-control" rows="5" name="comment">
</textarea>
</div>
<div class="col-12">
<button class="btn btn-gold">Submit Feedback</button>
</div>
</div>
</form>
</div>
</div>
</div>
</section><?php include 'footer.php';
?>
