    </main>

    <footer class="site-footer">
        <div class="footer-main">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <h2 class="footer-brand-title">
                            VEHICLE <span>AI SYSTEM</span>
                        </h2>

                        <p class="footer-description">
                            AI-based transparent vehicle service cost, duration and delay-risk
                            prediction using historical service patterns for Sri Lankan passenger cars.
                        </p>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <h3 class="footer-heading">Quick Links</h3>

                        <ul class="footer-links">
                            <li><a href="index.php">Home</a></li>

                            <?php if (logged() && !is_admin()): ?>
                                <li><a href="dashboard.php">Dashboard</a></li>
                                <li><a href="prediction.php">Prediction</a></li>
                                <li><a href="history.php">History</a></li>
                            <?php elseif (logged() && is_admin()): ?>
                                <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
                                <li><a href="admin_search.php">Search</a></li>
                                <li><a href="admin_analytics.php">Analytics</a></li>
                            <?php endif; ?>

                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <h3 class="footer-heading">Customer Services</h3>

                        <ul class="footer-links">
                            <li><a href="prediction.php">AI Cost Prediction</a></li>
                            <li><a href="prediction.php">Duration Prediction</a></li>
                            <li><a href="prediction.php">Delay Risk Analysis</a></li>
                            <li><a href="history.php">Prediction History</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <h3 class="footer-heading">Support</h3>

                        <ul class="footer-links">
                            <li><a href="contact.php">Contact</a></li>

                            <?php if (logged() && !is_admin()): ?>
                                <li><a href="my_messages.php">My Messages</a></li>
                            <?php endif; ?>

                            <?php if (logged()): ?>
                                <li><a href="notifications.php">Notifications</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <span>© 2026 Vehicle AI System. All Rights Reserved.</span>
                <span>AI-Based Transparent Vehicle Service Cost and Time Prediction System.</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
