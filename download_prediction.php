<?php require_once 'db.php';
require_login();
$uid=(int)$_SESSION['user_id'];
$id=(int)($_GET['id']??0);
$s=$conn->prepare('SELECT p.*,v.vehicle_number FROM predictions p JOIN vehicles v ON p.vehicle_id=v.vehicle_id WHERE p.prediction_id=? AND p.user_id=?');
$s->bind_param('ii',$id,$uid);
$s->execute();
$p=$s->get_result()->fetch_assoc();
if(!$p)die('Prediction not found.');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Vehicle AI Prediction Report</title>
<style>body{font-family:Arial;background:#eef1f4;padding:32px;color:#0b1f3a}.report{max-width:760px;margin:auto;background:#fff;padding:40px;border-top:8px solid #c9a24d}.brand{font-size:24px;font-weight:900}.gold{color:#c9a24d}.box{border:1px solid #d7dde4;padding:17px;margin:12px 0}.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}.big{font-size:21px;font-weight:900}.muted{color:#728093;font-size:12px}@media print{button{display:none}body{padding:0;background:#fff}}</style>
</head>
<body>
<div class="report">
<div class="brand">VEHICLE <span class="gold">AI SYSTEM</span>
</div>
<div class="muted">SMART SERVICE PREDICTION</div>
<hr>
<h1>Vehicle Service Prediction Report</h1>
<div class="box">
<b>Vehicle:</b> <?=e($p['vehicle_brand'].' '.$p['vehicle_model'])?><br>
<b>Number Plate:</b> <?=e($p['vehicle_number'])?><br>
<b>Service Type:</b> <?=e($p['service_type'])?><br>
<b>Repair Category:</b> <?=e($p['repair_category'])?><br>
<b>Prediction Date:</b> <?=e($p['prediction_date'])?></div>
<div class="grid">
<div class="box">
<span class="muted">Predicted Cost</span>
<div class="big">Rs. <?=number_format($p['predicted_cost'],0)?></div>
</div>
<div class="box">
<span class="muted">Duration</span>
<div class="big"><?=number_format($p['predicted_duration_hours'],1)?> Hrs</div>
</div>
<div class="box">
<span class="muted">Delay Risk</span>
<div class="big"><?=number_format($p['predicted_delay_probability'],1)?>%</div>
</div>
</div>
<p class="muted">This is an AI-generated estimate based on historical service patterns. Final workshop values may vary.</p>
<button onclick="window.print()">Download / Save as PDF</button>
</div>
</body>
</html>
