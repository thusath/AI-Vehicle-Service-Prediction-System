<?php require_once 'db.php';if(logged())activity($conn,(int)$_SESSION['user_id'],'User logout');$_SESSION=[];session_destroy();go('login.php');?>
