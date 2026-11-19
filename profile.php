<?php
require_once 'db.php';
require_login();
$uid=(int)$_SESSION['user_id'];
$msg='';
$error='';
if(isset($_POST['save_profile'])){
    check_csrf();
    $name=trim($_POST['full_name']??'');
    $phone=trim($_POST['phone']??'');
    $address=trim($_POST['address']??'');
    if($name===''){
        $error='Full name is required.';
    }
    else{
        $s=$conn->prepare('UPDATE users SET full_name=?, phone=?, address=? WHERE user_id=?');
        $s->bind_param('sssi',$name,$phone,$address,$uid);
        $s->execute();
        $_SESSION['full_name']=$name;
        $msg='Profile updated successfully.';
    }
}
if(isset($_POST['change_password'])){
    check_csrf();
    $current=$_POST['current_password']??'';
    $new=$_POST['new_password']??'';
    $confirm=$_POST['confirm_password']??'';
    $s=$conn->prepare('SELECT password FROM users WHERE user_id=?');
    $s->bind_param('i',$uid);
    $s->execute();
    $hash=$s->get_result()->fetch_assoc()['password']??'';
    if(!password_verify($current,$hash)){
        $error='Current password is incorrect.';
    }
    elseif(strlen($new)<8){
        $error='New password must be at least 8 characters.';
    }
    elseif($new!==$confirm){
        $error='New password and confirmation do not match.';
    }
    else{
        $newHash=password_hash($new,PASSWORD_DEFAULT);
        $s=$conn->prepare('UPDATE users SET password=? WHERE user_id=?');
        $s->bind_param('si',$newHash,$uid);
        $s->execute();
        $msg='Password changed successfully.';
    }
}
$s=$conn->prepare('SELECT * FROM users WHERE user_id=?');
$s->bind_param('i',$uid);
$s->execute();
$u=$s->get_result()->fetch_assoc();
include 'header.php';
?>

<section class="hero-strip">
<div class="container">
<div class="kicker">Account Management</div>
<h1>My <span class="gold">Profile</span>
</h1>
<p>View your account information, update profile details and manage password security.</p>
</div>
</section>
<section class="section">
<div class="container">
<div class="row g-4">
<div class="col-lg-5">
<div class="panel reveal">
<img src="images/home/hero-luxury-car.jpg" class="photo" style="height:280px;border-radius:0">
<div class="mt-4">
<div class="kicker">Account Information</div>
<h2 class="section-title"><?=e($u['full_name'])?></h2>
<p class="muted mb-1"><?=e($u['email'])?></p>
<p class="muted mb-1">Role: <?=e(ucfirst($u['role']))?></p>
<p class="muted mb-1">Status: <?=e(ucfirst($u['status']))?></p>
<p class="muted">Registered: <?=e($u['created_at'])?></p>
</div>
</div>
</div>
<div class="col-lg-7">
<div class="panel reveal mb-4">
<h2 class="section-title">Edit Profile Details</h2><?php if($msg):?>
<div class="alert alert-success"><?=e($msg)?></div><?php endif;
?>
<?php if($error):?>
<div class="alert alert-danger"><?=e($error)?></div><?php endif;
?>

<form method="post"><?=csrf_field()?>
<label class="form-label">Full Name</label>
<input class="form-control mb-3" name="full_name" value="<?=e($u['full_name'])?>" required>
<label class="form-label">Email</label>
<input class="form-control mb-3" value="<?=e($u['email'])?>" readonly>
<label class="form-label">Phone</label>
<input class="form-control mb-3" name="phone" value="<?=e($u['phone'])?>">
<label class="form-label">Address</label>
<input class="form-control mb-4" name="address" value="<?=e($u['address'])?>">
<button class="btn btn-gold" name="save_profile">Update Profile</button>
</form>
</div>
<div class="panel reveal">
<h2 class="section-title">Change Password</h2>
<p class="muted">Confirm your current password before setting a new password.</p>
<form method="post"><?=csrf_field()?>
<div class="row g-3">
<div class="col-12">
<label class="form-label">Current Password</label>
<input class="form-control" type="password" name="current_password" required>
</div>
<div class="col-md-6">
<label class="form-label">New Password</label>
<input class="form-control" type="password" name="new_password" minlength="8" required>
</div>
<div class="col-md-6">
<label class="form-label">Confirm New Password</label>
<input class="form-control" type="password" name="confirm_password" minlength="8" required>
</div>
<div class="col-12">
<button class="btn btn-gold" name="change_password">Change Password</button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</section>
<?php include 'footer.php';
?>
