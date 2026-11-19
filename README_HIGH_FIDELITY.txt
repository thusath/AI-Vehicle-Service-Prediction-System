VEHICLE AI SYSTEM — HIGH-FIDELITY REBUILD

This reconstruction was built from the uploaded interim report, the screenshots embedded in that report, and the functionality developed during the earlier project work. The original deleted XAMPP source files cannot be recovered byte-for-byte, but this package intentionally recreates the documented design language, page structure, animations/transitions and feature architecture instead of replacing it with a generic template.

INSTALL
1. Install XAMPP and start Apache + MySQL.
2. Copy this folder to C:\xampp\htdocs\vehicle_service_prediction
3. In phpMyAdmin import sql\vehicle_service_prediction.sql
4. Browse http://localhost/vehicle_service_prediction/
5. Admin: admin@vehicleai.lk / Admin@123
6. Change the admin password after first login.

PYTHON ML
cd C:\xampp\htdocs\vehicle_service_prediction
py -m pip install pandas numpy scikit-learn joblib
py ml\train_model.py

The trainer uses OneHotEncoder(handle_unknown="ignore") so a manually entered vehicle model that was not present during training does not crash encoding, provided the selected brand is supported.

REFERENCE
The folder docs\reference_screenshots contains the screenshots extracted from the uploaded interim report. They are supplied as a visual design reference.

PRESERVED PROJECT DECISIONS
- Passenger cars only.
- Main brands: Toyota, Honda, Nissan, Suzuki, Mazda, Mitsubishi, BMW, Mercedes-Benz, Audi, Kia, Hyundai.
- Customer manually types vehicle model.
- Admin does NOT edit customer details.
- Admin does NOT edit vehicle details.
- Disable/enable status persists in MySQL and prevents login while disabled.
- Notification read actions execute before header output, fixing the earlier headers-already-sent warning.
- Recent activity is focused on login/logout activity.
- Announcements are included because this feature was later confirmed as available.
