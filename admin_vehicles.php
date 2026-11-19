<?php
require_once 'db.php';
require_admin();
$q = trim($_GET['q'] ?? '');
$brand = trim($_GET['brand'] ?? '');
$sql = 'SELECT v.*, u.full_name, u.email FROM vehicles v JOIN users u ON v.user_id = u.user_id WHERE 1';
$params = [];
$types = '';
if ($q !== '') { $sql .= ' AND (v.vehicle_number LIKE ? OR v.vehicle_model LIKE ? OR u.full_name LIKE ?)'; $like = '%' . $q . '%'; array_push($params, $like, $like, $like); $types .= 'sss'; }
if ($brand !== '') { $sql .= ' AND v.vehicle_brand = ?'; $params[] = $brand; $types .= 's'; }
$sql .= ' ORDER BY v.created_at DESC';
$stmt = $conn->prepare($sql); if ($params) { $stmt->bind_param($types, ...$params); } $stmt->execute(); $result = $stmt->get_result();
$totalVehicles = (int) $conn->query('SELECT COUNT(*) AS total FROM vehicles')->fetch_assoc()['total'];
$brands = ['Toyota','Honda','Nissan','Suzuki','Mazda','Mitsubishi','BMW','Mercedes-Benz','Audi','Kia','Hyundai'];
include 'header.php';
?>
<section class="admin-page-head"><div class="container"><div class="kicker">Administration Panel</div><h1>Vehicle <span class="gold">Management</span></h1><p>View, search, and delete customer-submitted vehicles used for AI service cost, repair duration, and delay probability predictions.</p></div></section>
<section class="section"><div class="container">
<div class="admin-count reveal"><strong><?= $totalVehicles ?></strong><span>Vehicle Records Found</span></div>
<div class="admin-split reveal">
<aside class="admin-photo"><img src="images/admin/vehicle-management.jpg" alt="Luxury vehicle management"><div class="admin-photo-copy"><h3>Vehicle Control</h3><p>Search vehicle records by owner, number plate, brand, or model and remove duplicate or unnecessary vehicle entries.</p></div></aside>
<div class="admin-records"><h2>Vehicle Records</h2><p class="muted">Manage all vehicles submitted by users.</p>
<form class="admin-search-row" method="get"><input class="form-control" name="q" value="<?= e($q) ?>" placeholder="Search by user, plate, brand or model..."><select class="form-select" name="brand" style="max-width:170px"><option value="">All Brands</option><?php foreach ($brands as $item): ?><option <?= $brand === $item ? 'selected' : '' ?>><?= e($item) ?></option><?php endforeach; ?></select><button class="btn btn-gold">Search</button><a class="btn btn-gold" href="admin_vehicles.php">Reset</a></form>
<div class="table-shell"><table class="lux-table"><thead><tr><th>User</th><th>Vehicle No</th><th>Brand</th><th>Model</th><th>Year</th><th>Mileage</th><th>Date</th><th>Action</th></tr></thead><tbody><?php while ($vehicle = $result->fetch_assoc()): ?><tr><td><?= e($vehicle['full_name']) ?></td><td><strong class="gold"><?= e($vehicle['vehicle_number']) ?></strong></td><td><span class="pill gold"><?= e($vehicle['vehicle_brand']) ?></span></td><td><?= e($vehicle['vehicle_model']) ?></td><td><?= (int) $vehicle['manufacture_year'] ?></td><td><?= number_format($vehicle['mileage']) ?> km</td><td><?= e($vehicle['created_at']) ?></td><td><a class="btn-danger-lux" href="actions/delete_vehicle.php?id=<?= $vehicle['vehicle_id'] ?>" data-confirm="Delete this vehicle and its linked records?">Delete</a></td></tr><?php endwhile; ?></tbody></table></div>
<div class="insight-box"><strong>Vehicle Management Insight</strong><p>This page allows admin to search and manage all vehicle records connected to user prediction activity. Admin can remove duplicate or unnecessary records without editing customer vehicle details.</p></div>
</div></div></div></section>
<?php include 'footer.php'; ?>
