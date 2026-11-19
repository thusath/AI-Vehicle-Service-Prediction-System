<?php require_once 'db.php';
require_login();
$uid=(int)$_SESSION['user_id'];
$id=(int)($_GET['id']??0);
$s=$conn->prepare('SELECT p.*,v.vehicle_number FROM predictions p JOIN vehicles v ON p.vehicle_id=v.vehicle_id WHERE p.prediction_id=? AND p.user_id=?');
$s->bind_param('ii',$id,$uid);
$s->execute();
$p=$s->get_result()->fetch_assoc();
if(!$p)die('Prediction not found.');
include 'header.php';
?>
<section class="hero-strip">
<div class="container">
<h1>Prediction <span class="gold">Details</span>
</h1>
</div>
</section>
<section class="section">
<div class="container">
<div class="panel reveal">
<div class="summary">
<div class="summary-row">
<span>Vehicle Number</span>
<b><?=e($p['vehicle_number'])?></b>
</div>
<div class="summary-row">
<span>Vehicle</span>
<b><?=e($p['vehicle_brand'].' '.$p['vehicle_model'])?></b>
</div>
<div class="summary-row">
<span>Service</span>
<b><?=e($p['service_type'])?></b>
</div>
</div>
<div class="metric-grid">
<div class="metric">
<div class="label">Estimated Cost</div>
<div class="value">Rs. <?=number_format($p['predicted_cost'],0)?></div>
</div>
<div class="metric">
<div class="label">Duration</div>
<div class="value"><?=number_format($p['predicted_duration_hours'],1)?> Hrs</div>
</div>
<div class="metric">
<div class="label">Delay Risk</div>
<div class="value"><?=number_format($p['predicted_delay_probability'],1)?>%</div>
</div>
</div>
</div>
</div>
</section><?php include 'footer.php';
?>
