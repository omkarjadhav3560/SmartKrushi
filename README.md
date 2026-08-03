<div align="center">

# 🌾 SmartKrushi — Intelligent Agritech & E-Commerce Platform

[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Python](https://img.shields.io/badge/Python-3.8%2B-3776AB?style=for-the-badge&logo=python&logoColor=white)](https://www.python.org/)
[![Scikit-Learn](https://img.shields.io/badge/Scikit--Learn-Machine%20Learning-F7931E?style=for-the-badge&logo=scikit-learn&logoColor=white)](https://scikit-learn.org/)
[![Stripe](https://img.shields.io/badge/Stripe-Payments-008CDD?style=for-the-badge&logo=stripe&logoColor=white)](https://stripe.com/)
[![OpenAI](https://img.shields.io/badge/OpenAI-GPT%20AI%20Assistant-412991?style=for-the-badge&logo=openai&logoColor=white)](https://openai.com/)

An end-to-end intelligent agricultural portal empowering farmers with AI/ML decision insights, real-time market prices, weather forecasting, and direct-to-consumer crop trading with integrated online payments.

[Key Features](#-key-features) • [Architecture](#-architecture) • [Quick Start](#-quick-start) • [Tech Stack](#%EF%B8%8F-tech-stack)

---

</div>

## 🌟 Key Features

### 🚜 For Farmers
- **🤖 AI Agriculture Assistant**: Integrated OpenAI GPT assistant for instant 24/7 crop disease, soil, and pest advice.
- **📊 Machine Learning Analytics**:
  - **Crop Recommendation**: Recommends optimal crops based on N-P-K soil values, pH, and climate.
  - **Fertilizer Guidance**: Smart fertilizer recommendations tailored to soil deficiencies.
  - **Yield & Rainfall Prediction**: Machine learning models for crop yield and seasonal rainfall forecasts.
- **🌾 Direct Crop Trading**: List harvested crops, set prices, and sell directly to customers without middlemen.
- **🔒 2FA Security**: Secure OTP email verification via Gmail SMTP.

### 🛒 For Customers
- **Fresh Marketplace**: Browse fresh farm produce directly from verified farmers.
- **💳 Instant Payments**: Seamless, secure online payment checkout via **Stripe API**.
- **Order Tracking**: Real-time order confirmation and purchasing history.

### 👨‍💼 For Administrators
- Comprehensive management dashboard for Farmers, Customers, Delivery Partners, Orders, and Platform Messages.

---

## 🛠️ Tech Stack

| Domain | Technologies Used |
| :--- | :--- |
| **Frontend** | HTML5, CSS3, JavaScript, Bootstrap, FontAwesome |
| **Backend** | PHP (Vanilla), MySQL Database |
| **Machine Learning** | Python, `scikit-learn`, `pandas`, `numpy`, `joblib` |
| **Integrations** | OpenAI API, Stripe Payment SDK, PHPMailer (SMTP), OpenWeatherMap API, News API |

---

## 🚀 Quick Start

### 1. Prerequisite Setup
Ensure you have [XAMPP](https://www.apachefriends.org/) (Apache + MySQL) and Python 3.8+ installed.

### 2. Clone Repository
```bash
git clone https://github.com/omkarjadhav3560/SmartKrushi.git
cd SmartKrushi
```

### 3. Database Setup
1. Open XAMPP Control Panel and start **Apache** and **MySQL**.
2. Go to `http://localhost/phpmyadmin`.
3. Create a new database named `agriculture_portal`.
4. Import `db/agriculture_portal.sql`.

### 4. Configuration (API Keys)
1. Copy `config.example.php` to `config.php`:
   ```bash
   cp config.example.php config.php
   ```
2. Open `config.php` and set your OpenAI API Key:
   ```php
   define('OPENAI_API_KEY', 'your_actual_openai_api_key_here');
   ```

### 5. Python ML Environment
Install Python dependencies for machine learning scripts:
```bash
pip install -r farmer/requirements.txt
```

---

## 🔒 Security & Best Practices
- **Credential Protection**: Sensitive API keys are isolated in `config.php` (ignored via `.gitignore`) to prevent secret leakage.
- **Authentication**: 2FA OTP verification for user accounts via SMTP.

---

<div align="center">
  <sub>Built with ❤️ for Indian Agriculture & Farmers</sub>
</div>
