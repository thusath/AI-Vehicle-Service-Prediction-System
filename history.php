<?php
require_once 'db.php';
require_login();

$userId = (int) $_SESSION['user_id'];
$search = trim($_GET['q'] ?? '');
$serviceType = trim($_GET['service'] ?? '');

$sql = "
    SELECT
        p.*,
        v.vehicle_number
    FROM predictions p
    INNER JOIN vehicles v
        ON p.vehicle_id = v.vehicle_id
    WHERE p.user_id = ?
      AND p.is_deleted_by_user = 0
";

$types = 'i';
$params = [$userId];

if ($search !== '') {
    $sql .= "
        AND (
            p.vehicle_brand LIKE ?
            OR p.vehicle_model LIKE ?
            OR v.vehicle_number LIKE ?
        )
    ";

    $like = '%' . $search . '%';
    array_push($params, $like, $like, $like);
    $types .= 'sss';
}

if ($serviceType !== '') {
    $sql .= " AND p.service_type = ? ";
    $params[] = $serviceType;
    $types .= 's';
}

$sql .= " ORDER BY p.prediction_date DESC ";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

include 'header.php';
?>

<section class="hero-strip">
    <div class="container">
        <div class="kicker">Prediction Records</div>
        <h1>Your <span class="gold">Service History</span></h1>
        <p>
            Review previous estimates, compare results, download reports and submit
            actual service feedback.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="content-split reveal">
            <aside class="content-visual">
                <img
                    src="images/dashboard/history-vehicle.jpg"
                    alt="Premium vehicle dashboard representing prediction history"
                >

                <div class="content-visual-copy">
                    <div class="kicker">Your Vehicle Records</div>
                    <h3>Track Every Estimate</h3>
                    <p>
                        Keep previous service predictions in one place, compare estimates
                        and carry a report to your garage when required.
                    </p>
                </div>
            </aside>

            <div class="content-main">
                <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
                    <div>
                        <h2 class="section-title">Prediction History</h2>
                        <p class="muted mb-0">All active customer-visible prediction records.</p>
                    </div>

                    <a
                        class="btn btn-danger-lux"
                        href="actions/delete_all_history.php"
                        data-confirm="Delete all prediction history?"
                    >
                        Delete All History
                    </a>
                </div>

                <form class="row g-3 mb-4" method="get">
                    <div class="col-lg-5">
                        <label class="form-label" for="historySearch">Search History</label>
                        <input
                            id="historySearch"
                            class="form-control"
                            name="q"
                            value="<?= e($search) ?>"
                            placeholder="Vehicle, model or plate"
                        >
                    </div>

                    <div class="col-lg-4">
                        <label class="form-label" for="serviceFilter">Service Type</label>
                        <select id="serviceFilter" class="form-select" name="service">
                            <option value="">All Services</option>
                            <?php
                            $services = [
                                'Full Service',
                                'Oil Change',
                                'Brake Repair',
                                'Engine Repair',
                                'AC Repair',
                                'Battery Replacement',
                                'Suspension Repair',
                                'Transmission Repair',
                            ];

                            foreach ($services as $service):
                            ?>
                                <option
                                    value="<?= e($service) ?>"
                                    <?= $serviceType === $service ? 'selected' : '' ?>
                                >
                                    <?= e($service) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-lg-3 d-flex align-items-end">
                        <button class="btn btn-gold w-100" type="submit">
                            Search / Filter
                        </button>
                    </div>
                </form>

                <?php if ($result->num_rows > 0): ?>
                    <form method="post" action="compare_predictions.php">
                        <?= csrf_field() ?>

                        <div class="table-shell">
                            <table class="lux-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Compare</th>
                                        <th scope="col">Vehicle No</th>
                                        <th scope="col">Vehicle</th>
                                        <th scope="col">Service</th>
                                        <th scope="col">Cost</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Delay</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="compare_ids[]"
                                                    value="<?= (int) $row['prediction_id'] ?>"
                                                    aria-label="Select prediction for comparison"
                                                >
                                            </td>
                                            <td><?= e($row['vehicle_number']) ?></td>
                                            <td><?= e($row['vehicle_brand'] . ' ' . $row['vehicle_model']) ?></td>
                                            <td><?= e($row['service_type']) ?></td>
                                            <td>
                                                <span class="pill gold">
                                                    Rs. <?= number_format((float) $row['predicted_cost'], 0) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="pill blue">
                                                    <?= number_format((float) $row['predicted_duration_hours'], 1) ?> Hrs
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $delayClass = (float) $row['predicted_delay_probability'] > 50
                                                    ? 'red'
                                                    : 'green';
                                                ?>
                                                <span class="pill <?= $delayClass ?>">
                                                    <?= number_format((float) $row['predicted_delay_probability'], 1) ?>%
                                                </span>
                                            </td>
                                            <td><?= e($row['prediction_date']) ?></td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                    <a
                                                        class="pill blue"
                                                        href="prediction_details.php?id=<?= (int) $row['prediction_id'] ?>"
                                                    >
                                                        View
                                                    </a>
                                                    <a
                                                        class="pill gold"
                                                        href="download_prediction.php?id=<?= (int) $row['prediction_id'] ?>"
                                                    >
                                                        PDF
                                                    </a>
                                                    <a
                                                        class="pill green"
                                                        href="prediction_feedback.php?id=<?= (int) $row['prediction_id'] ?>"
                                                    >
                                                        Feedback
                                                    </a>
                                                    <a
                                                        class="pill red"
                                                        href="actions/delete_history.php?id=<?= (int) $row['prediction_id'] ?>"
                                                        data-confirm="Delete this prediction from your history?"
                                                    >
                                                        Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                        <button class="btn btn-gold mt-3" type="submit">
                            Compare Selected Predictions
                        </button>
                    </form>
                <?php else: ?>
                    <div class="empty-state">
                        <h3 class="section-title">No Prediction History Found</h3>
                        <p>No matching prediction records are available.</p>
                        <a class="btn btn-gold" href="prediction.php">Make New Prediction</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
