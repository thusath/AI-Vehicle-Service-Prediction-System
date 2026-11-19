<?php require_once 'db.php';
require_admin();
$q=trim($_GET['q']??'');
$sets=[];
if($q!==''){
    $like='%'.$q.'%';
    $s=$conn->prepare("SELECT full_name,email,status FROM users WHERE role='customer' AND (full_name LIKE ? OR email LIKE ?) LIMIT 12");
    $s->bind_param('ss',$like,$like);
    $s->execute();
    $sets['Users']=$s->get_result()->fetch_all(MYSQLI_ASSOC);
    $s=$conn->prepare('SELECT vehicle_number,vehicle_brand,vehicle_model FROM vehicles WHERE vehicle_number LIKE ? OR vehicle_brand LIKE ? OR vehicle_model LIKE ? LIMIT 12');
    $s->bind_param('sss',$like,$like,$like);
    $s->execute();
    $sets['Vehicles']=$s->get_result()->fetch_all(MYSQLI_ASSOC);
    $s=$conn->prepare('SELECT vehicle_brand,vehicle_model,service_type,predicted_cost FROM predictions WHERE vehicle_brand LIKE ? OR vehicle_model LIKE ? OR service_type LIKE ? LIMIT 12');
    $s->bind_param('sss',$like,$like,$like);
    $s->execute();
    $sets['Predictions']=$s->get_result()->fetch_all(MYSQLI_ASSOC);
    $s=$conn->prepare('SELECT name,email,subject,status FROM contact_messages WHERE name LIKE ? OR email LIKE ? OR subject LIKE ? LIMIT 12');
    $s->bind_param('sss',$like,$like,$like);
    $s->execute();
    $sets['Messages']=$s->get_result()->fetch_all(MYSQLI_ASSOC);
}include 'header.php';
?>
<section class="hero-strip">
<div class="container">
<div class="kicker">Global Administration Search</div>
<h1>Search <span class="gold">Center</span>
</h1>
<p>Search users, vehicles, predictions and messages from one secure admin interface.</p>
</div>
</section>
<section class="section">
<div class="container">
<div class="panel mb-4 reveal">
<form class="d-flex gap-2">
<input class="form-control" name="q" value="<?=e($q)?>" placeholder="Search the system">
<button class="btn btn-gold">Search</button>
</form>
</div>
<div class="row g-4"><?php foreach($sets as $name=>$rows):?>
<div class="col-lg-6">
<div class="panel reveal">
<h2 class="section-title"><?=$name?></h2><?php if(!$rows):?>
<p class="muted">No results found.</p><?php endif;
?>
<?php foreach($rows as $row):?>
<div class="tip">
<p><?=e(implode(' • ',array_values($row)))?></p>
</div><?php endforeach;
?>
</div>
</div><?php endforeach;
?>
</div>
</div>
</section><?php include 'footer.php';
?>
