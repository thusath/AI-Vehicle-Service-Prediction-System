<?php require_once "db.php";
login_required();
$uid=(int)$_SESSION["user_id"];
$id=(int)($_GET["id"]??0);
$p=$conn->query("SELECT vehicle_id FROM predictions WHERE prediction_id=$id AND user_id=$uid")->fetch_assoc();
if($p){
    $v=(int)$p["vehicle_id"];
    $conn->query("INSERT IGNORE INTO favorite_vehicles(user_id,vehicle_id) VALUES($uid,$v)");
}header("Location: favorites.php");
exit;
?>
