<?php
require_once 'db.php';
require_login();
if($_SERVER['REQUEST_METHOD']!=='POST' || !isset($_POST['predict'])) go('prediction.php');
check_csrf();
$uid=(int)$_SESSION['user_id'];
$prefix=strtoupper(trim($_POST['plate_prefix']??''));
$number=trim($_POST['plate_number']??'');
$vehicleNumber=$prefix.'-'.$number;
$brand=trim($_POST['vehicle_brand']??'');
$model=trim($_POST['vehicle_model']??'');
$type='Car';
$year=(int)($_POST['manufacture_year']??0);
$mileage=(int)($_POST['mileage']??0);
$service=trim($_POST['service_type']??'');
$repair=trim($_POST['repair_category']??'');
$age=max(0,(int)date('Y')-$year);
$error='';
$allowed=['Toyota','Honda','Nissan','Suzuki','Mazda','Mitsubishi','BMW','Mercedes-Benz','Audi','Kia','Hyundai'];
if(!in_array($brand,$allowed,true)) $error='Unsupported vehicle brand.';
elseif(!preg_match('/^[A-Z0-9-]{1,20}$/',$prefix)) $error='Invalid plate prefix.';
elseif(!preg_match('/^[0-9]{1,6}$/',$number)) $error='Plate number must contain digits only.';
elseif($year<1992 || $year>(int)date('Y')) $error='Invalid manufacture year.';
elseif($mileage<0 || $mileage>1000000) $error='Invalid mileage value.';
$exists=null;
if(!$error){
    $s=$conn->prepare('SELECT vehicle_id,user_id FROM vehicles WHERE plate_prefix=? AND plate_number=?');
    $s->bind_param('ss',$prefix,$number);
    $s->execute();
    $exists=$s->get_result()->fetch_assoc();
    if($exists && (int)$exists['user_id']!==$uid) $error='This complete number plate is already registered to another customer.';
}
if(!$error){
    $input=[
    'Vehicle_Brand'=>$brand,'Vehicle_Model'=>$model,'Vehicle_Type'=>'Car','Manufacture_Year'=>$year,
    'Vehicle_Age'=>$age,'Mileage'=>$mileage,'Service_Type'=>$service,'Repair_Category'=>$repair
    ];
    $python='python';
    $cmd=$python.' '.escapeshellarg(__DIR__.DIRECTORY_SEPARATOR.'ml'.DIRECTORY_SEPARATOR.'predict.py').' '.escapeshellarg(json_encode($input)).' 2>&1';
    $raw=(string)@shell_exec($cmd);
    $prediction=json_decode(trim($raw),true);
    if(is_array($prediction) && isset($prediction['predicted_cost'],$prediction['predicted_duration'],$prediction['predicted_delay'])){
        $cost=(float)$prediction['predicted_cost'];
        $duration=(float)$prediction['predicted_duration'];
        $delay=(float)$prediction['predicted_delay'];
        $engine='Random Forest ML Models';
    } else {
        // Fallback keeps the local application usable before Python is configured.
        $base=['Full Service'=>48000,'Oil Change'=>22000,'Brake Repair'=>65000,'Engine Repair'=>190000,'AC Repair'=>72000,'Battery Replacement'=>58000,'Suspension Repair'=>98000,'Transmission Repair'=>230000][$service]??50000;
        $brandM=in_array($brand,['BMW','Mercedes-Benz','Audi'],true)?1.75:($brand==='Suzuki'?.90:1.05);
        $repairM=['Minor'=>1,'Moderate'=>1.35,'Major'=>1.85][$repair]??1;
        $cost=($base+$mileage*.14+$age*2400)*$brandM*$repairM;
        $duration=max(1,($base/35000)*$repairM+$age*.09);
        $delay=min(95,8+$age*1.4+$mileage/22000+($repair==='Major'?23:($repair==='Moderate'?10:0)));
        $engine='Local fallback — train Python models for ML predictions';
    }
    if($exists){
        $vehicleId=(int)$exists['vehicle_id'];
        $s=$conn->prepare('UPDATE vehicles SET vehicle_number=?,vehicle_brand=?,vehicle_model=?,manufacture_year=?,mileage=? WHERE vehicle_id=? AND user_id=?');
        $s->bind_param('sssiiii',$vehicleNumber,$brand,$model,$year,$mileage,$vehicleId,$uid);
        $s->execute();
    }else{
        $s=$conn->prepare('INSERT INTO vehicles(user_id,vehicle_number,plate_prefix,plate_number,vehicle_type,vehicle_brand,vehicle_model,manufacture_year,mileage) VALUES(?,?,?,?,?,?,?,?,?)');
        $s->bind_param('issssssii',$uid,$vehicleNumber,$prefix,$number,$type,$brand,$model,$year,$mileage);
        $s->execute();
        $vehicleId=$conn->insert_id;
    }
    $s=$conn->prepare('INSERT INTO predictions(user_id,vehicle_id,vehicle_brand,vehicle_model,vehicle_age,mileage,service_type,repair_category,predicted_cost,predicted_duration_hours,predicted_delay_probability) VALUES(?,?,?,?,?,?,?,?,?,?,?)');
    $s->bind_param('iissiissddd',$uid,$vehicleId,$brand,$model,$age,$mileage,$service,$repair,$cost,$duration,$delay);
    $s->execute();
    $predictionId=$conn->insert_id;
    notify($conn,$uid,'Prediction Completed',"Your prediction for $brand $model has been completed successfully.",'prediction','prediction_details.php?id='.$predictionId);
    activity($conn,$uid,'Prediction created',"$brand $model - $service");
}
include 'header.php';
?>

<section class="hero-strip">
<div class="container">
<div class="kicker">AI Prediction Completed</div>
<h1>Your <span class="gold">Service Estimate</span>
</h1>
<p>The system has analyzed your car details and generated estimated service cost, duration and delay probability.</p>
</div>
</section>
<section class="section">
<div class="container">
<?php if($error):?>
<div class="panel text-center reveal">
<h2 class="section-title">Prediction Error</h2>
<p class="muted"><?=e($error)?></p>
<a class="btn btn-gold" href="prediction.php">Go Back</a>
</div><?php else:?>
<div class="split reveal">
<div class="visual result-visual">
<div class="visual-copy">
<h3>Transparent Service Insight</h3>
<p>These values are AI-generated estimates designed to support better planning before visiting a garage or service center.</p>
</div>
</div>
<div class="form-side">
<h2>Prediction Result</h2>
<p class="intro">Review your generated car service estimation below. Engine: <?=e($engine)?></p>
<div class="summary">
<div class="kicker">Vehicle Summary</div>
<div class="summary-row">
<span>Vehicle Number</span>
<strong><?=e($vehicleNumber)?></strong>
</div>
<div class="summary-row">
<span>Vehicle</span>
<strong><?=e($brand.' '.$model)?></strong>
</div>
<div class="summary-row">
<span>Manufacture Year</span>
<strong><?=$year?></strong>
</div>
<div class="summary-row">
<span>Mileage</span>
<strong><?=number_format($mileage)?> km</strong>
</div>
<div class="summary-row">
<span>Service Type</span>
<strong><?=e($service)?></strong>
</div>
<div class="summary-row">
<span>Repair Category</span>
<strong><?=e($repair)?></strong>
</div>
</div>
<div class="metric-grid">
<div class="metric">
<div class="label">Estimated Cost</div>
<div class="value">Rs. <?=number_format($cost,0)?></div>
</div>
<div class="metric">
<div class="label">Estimated Duration</div>
<div class="value"><?=number_format($duration,1)?> Hrs</div>
</div>
<div class="metric">
<div class="label">Delay Risk</div>
<div class="value"><?=number_format($delay,1)?>%</div>
</div>
</div>
<div class="tip">
<strong>Note</strong>
<p>This result is an estimated prediction based on historical car service patterns. Final service cost and time may vary depending on actual vehicle condition, spare parts availability and garage inspection.</p>
</div>
<div class="d-flex flex-wrap gap-2 mt-3">
<a class="btn btn-gold" href="prediction.php">Make Another Prediction</a>
<a class="btn btn-outline-lux" href="save_favorite.php?id=<?=$predictionId?>">Save as Favorite</a>
<a class="btn btn-outline-lux" href="history.php">View History</a>
</div>
</div>
</div><?php endif;
?>

</div>
</section><?php include 'footer.php';
?>
