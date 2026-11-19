<?php
require_once 'db.php';
require_admin();
$output='';
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['retrain'])){
    check_csrf();
    $uid=(int)$_SESSION['user_id'];
    $cmd='python '.escapeshellarg(__DIR__.'/ml/train_model.py').' 2>&1';
    $output=(string)shell_exec($cmd);
    $status=str_contains($output,'TRAINING_COMPLETED')?'completed':'failed';
    if($status==='completed' && file_exists(__DIR__.'/ml/models/metrics.json')){
        $mjson=json_decode(file_get_contents(__DIR__.'/ml/models/metrics.json'),true);
        if($mjson){
            $s=$conn->prepare('INSERT INTO model_metrics(cost_r2,cost_mae,cost_rmse,duration_r2,duration_mae,duration_rmse,delay_r2,delay_mae,delay_rmse,dataset_records) VALUES(?,?,?,?,?,?,?,?,?,?)');
            $s->bind_param('dddddddddi',$mjson['cost']['r2'],$mjson['cost']['mae'],$mjson['cost']['rmse'],$mjson['duration']['r2'],$mjson['duration']['mae'],$mjson['duration']['rmse'],$mjson['delay']['r2'],$mjson['delay']['mae'],$mjson['delay']['rmse'],$mjson['records']);
            $s->execute();
        }
    }$s=$conn->prepare('INSERT INTO model_training_log(trained_by,status,notes) VALUES(?,?,?)');
    $s->bind_param('iss',$uid,$status,$output);
    $s->execute();
}
$m=$conn->query('SELECT * FROM model_metrics ORDER BY trained_at DESC LIMIT 1')->fetch_assoc();
$d=$conn->query('SELECT * FROM dataset_uploads WHERE is_active=1 ORDER BY uploaded_at DESC LIMIT 1')->fetch_assoc();
$logs=$conn->query('SELECT l.*,u.full_name FROM model_training_log l LEFT JOIN users u ON l.trained_by=u.user_id ORDER BY l.trained_at DESC LIMIT 10');
include 'header.php';
?>

<section class="hero-strip">
<div class="container">
<div class="kicker">Machine Learning Control</div>
<h1>ML Model <span class="gold">Management</span>
</h1>
<p>Monitor R², MAE, RMSE, dataset size, training date and retrain all three Random Forest models.</p>
</div>
</section>
<section class="section">
<div class="container">
<div class="stats mb-4"><?php foreach([['Cost R²',isset($m['cost_r2'])?number_format($m['cost_r2']*100,1).'%':'N/A'],['Duration R²',isset($m['duration_r2'])?number_format($m['duration_r2']*100,1).'%':'N/A'],['Delay R²',isset($m['delay_r2'])?number_format($m['delay_r2']*100,1).'%':'N/A'],['Dataset Records',number_format($d['record_count']??($m['dataset_records']??0))]] as $x):?>
<div class="stat-card">
<div class="count" style="font-size:24px"><?=$x[1]?></div>
<div class="label"><?=$x[0]?></div>
</div><?php endforeach;
?>
</div>
<div class="row g-4">
<div class="col-lg-7">
<div class="panel reveal">
<h2 class="section-title">Current Model Metrics</h2>
<div class="table-shell">
<table class="lux-table">
<tr>
<th>Model</th>
<th>R²</th>
<th>MAE</th>
<th>RMSE</th>
</tr>
<tr>
<td>Cost</td>
<td><?=e($m['cost_r2']??'N/A')?></td>
<td><?=e($m['cost_mae']??'N/A')?></td>
<td><?=e($m['cost_rmse']??'N/A')?></td>
</tr>
<tr>
<td>Duration</td>
<td><?=e($m['duration_r2']??'N/A')?></td>
<td><?=e($m['duration_mae']??'N/A')?></td>
<td><?=e($m['duration_rmse']??'N/A')?></td>
</tr>
<tr>
<td>Delay</td>
<td><?=e($m['delay_r2']??'N/A')?></td>
<td><?=e($m['delay_mae']??'N/A')?></td>
<td><?=e($m['delay_rmse']??'N/A')?></td>
</tr>
</table>
</div>
<p class="muted mt-3">Last Training Date: <?=e($m['trained_at']??'Not trained on this installation yet')?></p>
<form method="post"><?=csrf_field()?><button class="btn btn-gold" name="retrain" data-confirm="Retrain all three models now?">Retrain Model</button>
</form><?php if($output):?>
<div class="tip mt-3">
<strong>Training Output</strong>
<pre style="white-space:pre-wrap;font-size:8px;color:#d8dee9"><?=e($output)?></pre>
</div><?php endif;
?>
</div>
</div>
<div class="col-lg-5">
<div class="panel reveal">
<h2 class="section-title">Training History</h2><?php while($l=$logs->fetch_assoc()):?>
<div class="mb-3">
<span class="pill <?=$l['status']==='completed'?'green':'red'?>"><?=e($l['status'])?></span>
<div class="small-meta mt-1"><?=e($l['trained_at'])?> • <?=e($l['full_name']??'Admin')?></div>
</div><?php endwhile;
?>
</div>
</div>
</div>
</div>
</section><?php include 'footer.php';
?>
