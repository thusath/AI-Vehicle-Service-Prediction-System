<?php
require_once 'db.php';
require_login();
$uid=(int)$_SESSION['user_id'];
$s=$conn->prepare('SELECT f.favorite_id,v.* FROM favorite_vehicles f JOIN vehicles v ON f.vehicle_id=v.vehicle_id WHERE f.user_id=? ORDER BY f.created_at DESC');
$s->bind_param('i',$uid);
$s->execute();
$r=$s->get_result();
include 'header.php';
?>

<section class="hero-strip">
<div class="container">
<div class="kicker">Saved Vehicle Garage</div>
<h1>Favorite <span class="gold">Vehicles</span>
</h1>
<p>Save frequently used vehicles and reuse their details for one-click prediction.</p>
</div>
</section>
<section class="section">
<div class="container">
<div class="row g-4"><?php if(!$r->num_rows):?>
<div class="panel text-center">
<h2 class="section-title">No Favorite Vehicles</h2>
<p class="muted">Save a vehicle from the prediction result page.</p>
<a class="btn btn-gold" href="prediction.php">Make Prediction</a>
</div><?php endif;
?>
<?php while($v=$r->fetch_assoc()):?>
<div class="col-lg-6">
<div class="panel reveal">
<div class="row g-3 align-items-center">
<div class="col-4">
<img src="images/dashboard/history-vehicle.jpg" class="w-100 rounded" style="height:130px;object-fit:cover">
</div>
<div class="col-8">
<div class="kicker">Favorite Vehicle</div>
<h3 class="section-title"><?=e($v['vehicle_brand'].' '.$v['vehicle_model'])?></h3>
<p class="muted"><?=e($v['vehicle_number'])?> • <?=$v['manufacture_year']?> • <?=number_format($v['mileage'])?> km</p>
<a class="btn btn-gold" href="prediction.php?favorite_id=<?=$v['favorite_id']?>">Predict Again</a>
<a class="btn btn-danger-lux" href="actions/delete_favorite.php?id=<?=$v['favorite_id']?>" data-confirm="Remove this favorite vehicle?">Remove</a>
</div>
</div>
</div>
</div><?php endwhile;
?>
</div>
</div>
</section><?php include 'footer.php';
?>
