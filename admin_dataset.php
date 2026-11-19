<?php
require_once 'db.php';
require_admin();
$msg='';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_FILES['csv'])){
    check_csrf();
    $f=$_FILES['csv'];
    $ext=strtolower(pathinfo($f['name'],PATHINFO_EXTENSION));
    if($ext!=='csv'){
        $error='Only CSV files are accepted.';
    }
    elseif(($f['size']??0)>10*1024*1024){
        $error='Dataset file exceeds the 10 MB limit.';
    }
    elseif(($f['error']??UPLOAD_ERR_OK)!==UPLOAD_ERR_OK){
        $error='Dataset upload failed.';
    }
    else{
        $safe=date('Ymd_His').'_'.preg_replace('/[^A-Za-z0-9._-]/','_',basename($f['name']));
        $rel='uploads/datasets/'.$safe;
        $abs=__DIR__.'/'.$rel;
        if(!move_uploaded_file($f['tmp_name'],$abs)){
            $error='Could not store uploaded dataset.';
        }
        else{
            $rows=max(0,count(file($abs))-1);
            $version='DS-'.date('Ymd-His');
            $uid=(int)$_SESSION['user_id'];
            if(isset($_POST['replace'])){
                $conn->query('UPDATE dataset_uploads SET is_active=0');
            }
            $s=$conn->prepare('INSERT INTO dataset_uploads(file_name,file_path,record_count,version,uploaded_by,is_active) VALUES(?,?,?,?,?,1)');
            $s->bind_param('ssisi',$safe,$rel,$rows,$version,$uid);
            $s->execute();
            $msg='Dataset uploaded successfully.';
        }
    }
}
$r=$conn->query("SELECT d.*,u.full_name FROM dataset_uploads d LEFT JOIN users u ON d.uploaded_by=u.user_id ORDER BY d.uploaded_at DESC");
$active=$conn->query("SELECT * FROM dataset_uploads WHERE is_active=1 ORDER BY uploaded_at DESC LIMIT 1")->fetch_assoc();
include 'header.php';
?>

<section class="hero-strip">
<div class="container">
<div class="kicker">Data Control Centre</div>
<h1>Dataset <span class="gold">Management</span>
</h1>
<p>Upload CSV data, replace the active dataset, monitor record counts and maintain dataset version history.</p>
</div>
</section>
<section class="section">
<div class="container">
<div class="row g-4">
<div class="col-lg-4">
<div class="panel reveal">
<img src="images/admin/dataset-management.jpg" class="photo mb-4">
<h2 class="section-title">Upload Dataset</h2><?php if($msg):?>
<div class="alert alert-success"><?=e($msg)?></div><?php endif;
?>
<?php if($error):?>
<div class="alert alert-danger"><?=e($error)?></div><?php endif;
?>
<form method="post" enctype="multipart/form-data"><?=csrf_field()?><label class="form-label">CSV Dataset</label>
<input class="form-control mb-3" type="file" name="csv" accept=".csv,text/csv" required>
<label class="muted">
<input type="checkbox" name="replace"> Replace current active dataset</label>
<br>
<button class="btn btn-gold mt-3">Upload CSV</button>
</form>
</div>
</div>
<div class="col-lg-8">
<div class="stats mb-4">
<div class="stat-card">
<div class="count"><?=number_format($active['record_count']??0)?></div>
<div class="label">Active Records</div>
</div>
<div class="stat-card">
<div class="count" style="font-size:18px"><?=e($active['version']??'N/A')?></div>
<div class="label">Current Version</div>
</div>
<div class="stat-card">
<div class="count" style="font-size:15px"><?=e($active['uploaded_at']??'N/A')?></div>
<div class="label">Last Upload</div>
</div>
<div class="stat-card">
<div class="count"><?=number_format($r->num_rows)?></div>
<div class="label">Upload Versions</div>
</div>
</div>
<div class="panel reveal table-responsive">
<h2 class="section-title">Dataset Upload History</h2>
<table class="lux-table">
<tr>
<th>Version</th>
<th>File</th>
<th>Records</th>
<th>Administrator</th>
<th>Active</th>
<th>Date</th>
</tr><?php while($d=$r->fetch_assoc()):?>
<tr>
<td><?=e($d['version'])?></td>
<td><?=e($d['file_name'])?></td>
<td><?=number_format($d['record_count'])?></td>
<td><?=e($d['full_name']??'Admin')?></td>
<td>
<span class="pill <?=$d['is_active']?'green':'blue'?>"><?=$d['is_active']?'Active':'Archived'?></span>
</td>
<td><?=e($d['uploaded_at'])?></td>
</tr><?php endwhile;
?>
</table>
<a class="btn btn-gold mt-3" href="admin_model.php">Open Model Management</a>
</div>
</div>
</div>
</div>
</section><?php include 'footer.php';
?>
