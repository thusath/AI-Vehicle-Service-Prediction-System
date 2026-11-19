# AI-Based Vehicle Service Cost and Time Prediction System

A web-based Machine Learning application developed to estimate vehicle service cost, service duration and delay risk for passenger cars in Sri Lanka.

## Technologies
- PHP, HTML, CSS, JavaScript and Bootstrap
- MySQL
- Python, Pandas, NumPy, Scikit-learn and Joblib
- XAMPP

## Requirements
- XAMPP with Apache and MySQL
- Python 3
- A web browser

## Installation
1. Download or clone this repository.
2. Copy the project folder into `C:\xampp\htdocs\`.
3. Start Apache and MySQL in XAMPP.
4. Open `http://localhost/phpmyadmin/`.
5. Create a database using the database name expected by the PHP configuration.
6. Select the database, click Import, and import `database.sql`.
7. Open Command Prompt in the project folder and install the Python packages:
   `pip install pandas numpy scikit-learn joblib`
8. Update the database connection configuration for your local MySQL environment.
9. Confirm that the PHP-to-Python integration points to the correct Python executable and ML model files.
10. Open `http://localhost/YOUR_PROJECT_FOLDER/` in your browser.

## Features
- Service cost prediction
- Service duration prediction
- Delay risk estimation
- Customer registration and login
- Vehicle management
- Prediction history and comparison
- Favourite vehicles and PDF reports
- Actual service feedback and notifications
- Administrator dashboard and analytics
- Dataset and ML model management

## Notes
Predictions are preliminary estimates and do not replace professional vehicle inspection. The database file should contain only a safe schema and non-sensitive sample records.
