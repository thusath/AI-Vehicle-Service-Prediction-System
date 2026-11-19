VEHICLE AI — COMPLETE REBUILD PACKAGE

Project: AI-Based Transparent Vehicle Service Cost and Time Prediction System Using Historical Service Patterns in Sri Lanka

SETUP
1. Install XAMPP. Start Apache and MySQL.
2. Extract/copy folder to C:\xampp\htdocs\vehicle_service_prediction
3. Open http://localhost/phpmyadmin
4. Import sql\vehicle_service_prediction.sql
5. Browse http://localhost/vehicle_service_prediction/
6. Admin login: admin@vehicleai.lk / Admin@123
7. Install Python dependencies:
   py -m pip install pandas numpy scikit-learn joblib
8. Train models:
   cd C:\xampp\htdocs\vehicle_service_prediction
   py ml\train_model.py

IMPORTANT
- The PHP site has a built-in working prediction formula so it can run immediately.
- The Python files retrain Random Forest models and save .pkl files.
- This ZIP is a reconstruction from the project's established architecture/features, not byte-for-byte recovery of deleted XAMPP files.
- The included 3,500-row dataset is reconstructed/synthetic and localized for the project.
- Admin editing of customer details and vehicle details is intentionally NOT included, matching the final project decision.
- System broadcast notifications are intentionally not included as they were marked unnecessary.
- Recent activity is limited to user logins, matching the final project decision.

IMAGES
Put JPG files in /images with these names:
car-hero.jpg
admin-banner.jpg
profile-car.jpg
service-bay.jpg
support.jpg
admin-control.jpg
data-center.jpg
The pages already reference them using img src / CSS background URLs.

CORE MODULES INCLUDED
Customer: registration, login/logout, forgot/reset/change password, profile, disabled-user protection, unique plate validation, prediction, result, history, delete/delete-all, favorites, comparison, printable PDF report, actual-service feedback, notifications, mark-read/all-read, contact/support.
Admin: dashboard counters, login timeline, user search/disable/enable/delete, vehicle search/delete, prediction filtering/delete, message reply + notifications, actual feedback reply + notifications, CSV dataset upload/replacement/history/versioning/record count, ML model management/retraining structure, Chart.js analytics including monthly trends, and global search.
