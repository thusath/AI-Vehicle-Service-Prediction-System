<?php
require_once 'db.php';
require_admin();
$users=(int)$conn->query("SELECT COUNT(*) c FROM users WHERE role='customer'")->fetch_assoc()['c'];
$vehicles=(int)$conn->query('SELECT COUNT(*) c FROM vehicles')->fetch_assoc()['c'];
$pred=(int)$conn->query('SELECT COUNT(*) c FROM predictions WHERE is_deleted_by_admin=0')->fetch_assoc()['c'];
$msgs=(int)$conn->query('SELECT COUNT(*) c FROM contact_messages')->fetch_assoc()['c'];
$recent=$conn->query('SELECT p.*,u.full_name FROM predictions p JOIN users u ON p.user_id=u.user_id WHERE p.is_deleted_by_admin=0 ORDER BY p.prediction_date DESC LIMIT 8');
$act=$conn->query("SELECT a.*,u.full_name FROM activity_log a LEFT JOIN users u ON a.user_id=u.user_id WHERE a.action IN ('User login','User logout') ORDER BY a.created_at DESC LIMIT 8");
include 'header.php';
?>
<section class="hero-strip" style="background-image:linear-gradient(90deg,rgba(2,12,24,.96),rgba(6,27,50,.78)),url('images/admin/control-centre.jpg')">
<div class="container">
<div class="kicker">Administration Control Centre</div>
<h1>Admin <span class="gold">Dashboard</span>
</h1>
<p>Monitor users, vehicles, predictions, customer communication, analytics, datasets and machine learning model status.</p>
</div>
</section>
<section class="section">
<div class="container">
<div class="stats mb-4"><?php foreach([['Registered Users',$users,'admin_users.php'],['Checked Vehicles',$vehicles,'admin_vehicles.php'],['Predictions',$pred,'admin_predictions.php'],['Messages',$msgs,'admin_messages.php']] as $x):?>
<a class="stat-card reveal" href="<?=$x[2]?>">
<div class="count" data-count="<?=$x[1]?>">0</div>
<div class="label"><?=$x[0]?></div>
</a><?php endforeach;
?>
</div>
<div class="admin-tools mb-4"><?php foreach([['admin_users.php','bi-people','User Management'],['admin_vehicles.php','bi-car-front','Vehicle Management'],['admin_predictions.php','bi-cpu','Prediction Management'],['admin_messages.php','bi-chat-left-text','User Messages'],['admin_feedback.php','bi-clipboard-data','Actual Feedback'],['admin_analytics.php','bi-bar-chart','Analytics Dashboard'],['admin_dataset.php','bi-database-up','Dataset Management'],['admin_model.php','bi-diagram-3','ML Model Management'],['admin_announcements.php','bi-megaphone','Announcements']] as $t):?>
<a class="admin-tool reveal" href="<?=$t[0]?>">
<i class="bi <?=$t[1]?>">
</i>
<h4><?=$t[2]?></h4>
<p>Open the <?=$t[2]?> module.</p>
</a><?php endforeach;
?>
</div>
<div class="row g-4">
<div class="col-lg-8">
<div class="panel reveal">
<h2 class="section-title">Recent Predictions</h2>
<div class="table-shell">
<table class="lux-table">
<tr>
<th>User</th>
<th>Vehicle</th>
<th>Service</th>
<th>Cost</th>
<th>Duration</th>
<th>Delay</th>
</tr><?php while($p=$recent->fetch_assoc()):?>
<tr>
<td><?=e($p['full_name'])?></td>
<td><?=e($p['vehicle_brand'].' '.$p['vehicle_model'])?></td>
<td><?=e($p['service_type'])?></td>
<td>Rs. <?=number_format($p['predicted_cost'],0)?></td>
<td><?=number_format($p['predicted_duration_hours'],1)?>h</td>
<td><?=number_format($p['predicted_delay_probability'],1)?>%</td>
</tr><?php endwhile;
?>
</table>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="panel reveal">
<h2 class="section-title">Recent Activity</h2>
<p class="muted">Login/logout timeline only.</p><?php while($a=$act->fetch_assoc()):?>
<div class="mb-3">
<div class="small-meta"><?=e($a['created_at'])?></div>
<div style="font-size:9px"><?=e($a['full_name']??'Unknown')?> — <?=e($a['action'])?></div>
</div><?php endwhile;
?>
</div>
</div>
</div>
</div>
</section><?php include 'footer.php';
?>
