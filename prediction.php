<?php
require_once 'db.php';
require_login();

$favorite = null;

if (isset($_GET['favorite_id'])) {
    $favoriteId = (int) $_GET['favorite_id'];
    $userId = (int) $_SESSION['user_id'];

    $stmt = $conn->prepare(
        'SELECT f.*, v.*
         FROM favorite_vehicles f
         INNER JOIN vehicles v
             ON f.vehicle_id = v.vehicle_id
         WHERE f.favorite_id = ?
           AND f.user_id = ?'
    );

    $stmt->bind_param('ii', $favoriteId, $userId);
    $stmt->execute();
    $favorite = $stmt->get_result()->fetch_assoc();
}

$brands = [
    'Toyota',
    'Honda',
    'Nissan',
    'Suzuki',
    'Mazda',
    'Mitsubishi',
    'BMW',
    'Mercedes-Benz',
    'Audi',
    'Kia',
    'Hyundai',
];

include 'header.php';
?>

<section class="hero-strip">
    <div class="container">
        <div class="kicker">AI Service Estimation</div>

        <h1>
            Predict Your <span class="gold">Car Service</span>
        </h1>

        <p>
            Enter your car details and service information to generate an AI-based
            estimate for service cost, repair duration, and delay probability.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">

        <div class="split reveal">

            <!-- LEFT IMAGE SECTION -->
            <div
                class="visual prediction-visual"
                style="
                    position: relative !important;
                    overflow: hidden !important;
                    background: #050b12 !important;
                    padding: 0 !important;
                    margin: 0 !important;
                    min-height: 100% !important;
                "
            >

                <!-- BMW IMAGE -->
                <img
                    src="/vehicle_service_prediction/images/prediction/bmw-m3.jpg"
                    alt="BMW M3"
                    style="
                        position: absolute !important;
                        top: 0 !important;
                        left: 0 !important;
                        right: 0 !important;
                        bottom: 0 !important;
                        width: 100% !important;
                        height: 100% !important;
                        min-width: 100% !important;
                        min-height: 100% !important;
                        object-fit: cover !important;
                        object-position: center center !important;
                        display: block !important;
                        margin: 0 !important;
                        padding: 0 !important;
                        z-index: 1 !important;
                    "
                >

                <!-- DARK OVERLAY -->
                <div
                    style="
                        position: absolute !important;
                        top: 0 !important;
                        left: 0 !important;
                        right: 0 !important;
                        bottom: 0 !important;
                        width: 100% !important;
                        height: 100% !important;
                        background:
                            linear-gradient(
                                to bottom,
                                rgba(2, 8, 15, 0.03) 0%,
                                rgba(2, 8, 15, 0.05) 40%,
                                rgba(2, 8, 15, 0.30) 65%,
                                rgba(2, 8, 15, 0.92) 100%
                            ) !important;
                        z-index: 2 !important;
                        pointer-events: none !important;
                    "
                ></div>

                <!-- BOTTOM TEXT -->
                <div
                    class="visual-copy"
                    style="
                        position: absolute !important;
                        left: 0 !important;
                        right: 0 !important;
                        bottom: 0 !important;
                        top: auto !important;
                        width: 100% !important;
                        padding: 28px 28px 30px 28px !important;
                        margin: 0 !important;
                        transform: none !important;
                        z-index: 3 !important;
                        text-align: left !important;
                    "
                >

                    <h3
                        style="
                            margin: 0 0 8px 0 !important;
                            padding: 0 !important;
                            color: #ffffff !important;
                        "
                    >
                        Smart Garage Insight
                    </h3>

                    <p
                        style="
                            margin: 0 !important;
                            padding: 0 !important;
                            color: #ffffff !important;
                            line-height: 1.6 !important;
                        "
                    >
                        Use historical car service patterns to receive transparent,
                        data-driven predictions before visiting a service center.
                    </p>

                </div>

            </div>
            <!-- END LEFT IMAGE SECTION -->


            <!-- RIGHT FORM SECTION -->
            <div class="form-side">

                <h2>Vehicle Service Prediction</h2>

                <p class="intro">
                    Fill the form below with accurate car and service details for better
                    prediction results.
                </p>

                <form method="post" action="result.php">

                    <?= csrf_field() ?>

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label
                                class="form-label"
                                for="plate_prefix"
                            >
                                Plate Prefix
                            </label>

                            <input
                                id="plate_prefix"
                                class="form-control"
                                name="plate_prefix"
                                value="<?= e($favorite['plate_prefix'] ?? '') ?>"
                                placeholder="Example: CBI"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label
                                class="form-label"
                                for="plate_number"
                            >
                                Plate Number
                            </label>

                            <input
                                id="plate_number"
                                class="form-control"
                                name="plate_number"
                                value="<?= e($favorite['plate_number'] ?? '') ?>"
                                placeholder="Example: 6218"
                                inputmode="numeric"
                                pattern="[0-9]{1,6}"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label
                                class="form-label"
                                for="vehicle_brand"
                            >
                                Vehicle Brand
                            </label>

                            <select
                                id="vehicle_brand"
                                class="form-select"
                                name="vehicle_brand"
                                required
                            >

                                <option value="">Select Brand</option>

                                <?php foreach ($brands as $brand): ?>

                                    <option
                                        value="<?= e($brand) ?>"
                                        <?= $favorite && $favorite['vehicle_brand'] === $brand ? 'selected' : '' ?>
                                    >
                                        <?= e($brand) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <div class="col-md-6">

                            <label
                                class="form-label"
                                for="vehicle_model"
                            >
                                Vehicle Model
                            </label>

                            <input
                                id="vehicle_model"
                                class="form-control"
                                name="vehicle_model"
                                value="<?= e($favorite['vehicle_model'] ?? '') ?>"
                                placeholder="Example: Prius, Civic, Prado 150"
                                required
                            >

                            <div class="note">
                                Enter the model manually. Unseen models remain supported by the ML encoder.
                            </div>

                        </div>


                        <div class="col-md-6">

                            <label
                                class="form-label"
                                for="vehicle_type_display"
                            >
                                Vehicle Type
                            </label>

                            <input
                                id="vehicle_type_display"
                                class="form-control"
                                value="Car"
                                disabled
                            >

                            <input
                                type="hidden"
                                name="vehicle_type"
                                value="Car"
                            >

                        </div>


                        <div class="col-md-6">

                            <label
                                class="form-label"
                                for="manufacture_year"
                            >
                                Manufacture Year
                            </label>

                            <input
                                id="manufacture_year"
                                class="form-control"
                                type="number"
                                name="manufacture_year"
                                min="1992"
                                max="<?= date('Y') ?>"
                                value="<?= e($favorite['manufacture_year'] ?? '') ?>"
                                placeholder="Example: 2015"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label
                                class="form-label"
                                for="mileage"
                            >
                                Mileage
                            </label>

                            <input
                                id="mileage"
                                class="form-control"
                                type="number"
                                name="mileage"
                                min="0"
                                max="1000000"
                                value="<?= e($favorite['mileage'] ?? '') ?>"
                                placeholder="Example: 85000"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label
                                class="form-label"
                                for="service_type"
                            >
                                Service Type
                            </label>

                            <select
                                id="service_type"
                                class="form-select"
                                name="service_type"
                                required
                            >

                                <option value="">Select Service</option>
                                <option>Full Service</option>
                                <option>Oil Change</option>
                                <option>Brake Repair</option>
                                <option>Engine Repair</option>
                                <option>AC Repair</option>
                                <option>Battery Replacement</option>
                                <option>Suspension Repair</option>
                                <option>Transmission Repair</option>

                            </select>

                        </div>


                        <div class="col-md-6">

                            <label
                                class="form-label"
                                for="repair_category"
                            >
                                Repair Category
                            </label>

                            <select
                                id="repair_category"
                                class="form-select"
                                name="repair_category"
                                required
                            >

                                <option value="">Select Category</option>
                                <option>Minor</option>
                                <option>Moderate</option>
                                <option>Major</option>

                            </select>

                        </div>


                        <div class="col-12">

                            <button
                                class="btn btn-gold w-100"
                                type="submit"
                                name="predict"
                            >
                                Predict Now
                            </button>

                        </div>

                    </div>

                </form>


                <div class="tip">

                    <strong>Prediction Tip</strong>

                    <p>
                        Accurate mileage, manufacture year, service type and repair category
                        help the AI model generate more realistic cost and time estimates.
                    </p>

                </div>

            </div>

        </div>

    </div>
</section>

<?php
include 'footer.php';
?>