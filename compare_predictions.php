<?php require_once 'db.php';
require_login();
if($_SERVER['REQUEST_METHOD']!=='POST')go('history.php');
check_csrf();
$ids=array_values(array_unique(array_map('intval',$_POST['compare_ids']??[])));
if(count($ids)<2||count($ids)>3){
    flash('error','Select 2 or 3 predictions.');
    go('history.php');
}$uid=(int)$_SESSION['user_id'];
$ph=implode(',',array_fill(0,count($ids),'?'));
$types='i'.str_repeat('i',count($ids));
$params=array_merge([$uid],$ids);
$s=$conn->prepare("SELECT * FROM predictions WHERE user_id=? AND prediction_id IN ($ph)");
$s->bind_param($types,...$params);
$s->execute();
$r=$s->get_result();
include 'header.php';
?>
<section class="hero-strip">
<div class="container">
<h1>Prediction <span class="gold">Comparison</span>
</h1>
</div>
</section>
<section class="section">
<div class="container">
<div class="row g-3"><?php while($p=$r->fetch_assoc()):?>
<div class="col-lg">
<div class="panel reveal">
<div class="kicker"><?=e($p['service_type'])?></div>
<h3><?=e($p['vehicle_brand'].' '.$p['vehicle_model'])?></h3>
<div class="metric mt-3">
<div class="label">Cost</div>
<div class="value">Rs. <?=number_format($p['predicted_cost'],0)?></div>
</div>
<div class="metric mt-2">
<div class="label">Duration</div>
<div class="value"><?=number_format($p['predicted_duration_hours'],1)?>h</div>
</div>
<div class="metric mt-2">
<div class="label">Delay</div>
<div class="value"><?=number_format($p['predicted_delay_probability'],1)?>%</div>
</div>
</div>
</div><?php endwhile;
?>
</div>
</div>
</section><?php include 'footer.php';
?>
