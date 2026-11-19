<?php
require_once 'db.php';
require_login();

if (is_admin()) {
    go('admin_dashboard.php');
}

include 'header.php';
?>

<section class="dashboard-head">
    <div class="container reveal">
        <div class="kicker">Customer Dashboard</div>

        <h1>
            Welcome, <span class="gold"><?= e($_SESSION['full_name']) ?></span>
        </h1>

        <p>
            Manage your AI-powered car service predictions, view previous estimation
            history, save favorite vehicles, and contact support for service-related inquiries.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="action-grid">
            <a class="action-card reveal" href="prediction.php">
                <div
                    class="action-img"
                    style="background-image: url('images/dashboard/prediction-service.jpg');"
                ></div>

                <div class="action-body">
                    <h3>New Prediction</h3>
                    <p>
                        Predict car service cost, repair duration, and delay risk using AI.
                    </p>
                    <span class="btn btn-gold">Start Now</span>
                </div>
            </a>

            <a class="action-card reveal" href="history.php">
                <div
                    class="action-img"
                    style="background-image: url('images/dashboard/history-vehicle.jpg');"
                ></div>

                <div class="action-body">
                    <h3>Prediction History</h3>
                    <p>
                        View saved car service prediction results and previous estimates.
                    </p>
                    <span class="btn btn-gold">View History</span>
                </div>
            </a>

            <a class="action-card reveal" href="favorites.php">
                <div
                    class="action-img"
                    style="background-image: url('images/home/hero-luxury-car.jpg');"
                ></div>

                <div class="action-body">
                    <h3>Favorite Vehicles</h3>
                    <p>
                        Save frequently used vehicles and make predictions with one click.
                    </p>
                    <span class="btn btn-gold">View Favorites</span>
                </div>
            </a>

            <a class="action-card reveal" href="contact.php">
                <div
                    class="action-img"
                    style="background-image: url('images/support/contact-service.jpg');"
                ></div>

                <div class="action-body">
                    <h3>Contact Support</h3>
                    <p>
                        Send questions, feedback, or support requests to the system admin.
                    </p>
                    <span class="btn btn-gold">Contact Us</span>
                </div>
            </a>
        </div>

        <div class="guide reveal">
            <h4>System Guide</h4>

            <p>
                Start by selecting New Prediction, enter your car brand, model,
                manufacture year, mileage, service type and repair category. The system
                will generate estimated service cost, service duration, and delay probability
                instantly. You can also save frequently used vehicles in Favorite Vehicles
                and reuse them for future predictions.
            </p>
        </div>
    </div>
</section>

<?php
include 'footer.php';
?>
