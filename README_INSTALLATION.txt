VEHICLE AI SYSTEM — FINAL REFINED XAMPP BUILD

Project:
AI-Based Transparent Vehicle Service Cost and Time Prediction System Using Historical Service Patterns in Sri Lanka

INSTALLATION
1. Install XAMPP.
2. Start Apache and MySQL.
3. Copy/extract the complete folder to:
   C:\xampp\htdocs\vehicle_service_prediction
4. Open:
   http://localhost/phpmyadmin
5. Import:
   sql\vehicle_service_prediction.sql
6. Open:
   http://localhost/vehicle_service_prediction/

INITIAL ADMIN ACCOUNT
Email: admin@vehicleai.lk
Password: Admin@123

Change the admin password after the first successful login.

PYTHON / MACHINE LEARNING
Install Python packages:
   py -m pip install pandas numpy scikit-learn joblib

Train/retrain all models:
   cd C:\xampp\htdocs\vehicle_service_prediction
   py ml\train_model.py

The training pipeline uses:
   OneHotEncoder(handle_unknown="ignore")

Models are stored in:
   ml\models\cost_model.pkl
   ml\models\duration_model.pkl
   ml\models\delay_model.pkl

IMPORTANT XAMPP CHECK
PHP calls Python using the `python` command. If Python is not available on the Apache process PATH, update the Python executable setting in result.php/admin_model.php to the full Windows python.exe path.

IMAGE LICENSING/SOURCES
See IMAGE_SOURCES.md. Production photographs are stored locally inside the project; the live pages do not hotlink them.

REFINEMENT/TEST RECORD
See FINAL_REFINEMENT_REPORT.md.
