# 🤖 AI Fruit Prediction Setup Guide

## Overview
Sistem AI ini memprediksi buah yang akan dijual berikutnya berdasarkan data transaksi 1 bulan terakhir menggunakan Machine Learning dengan algoritma Random Forest.

## 📋 Prerequisites

### 1. Python Installation
Pastikan Python 3.8+ terinstall:
```bash
python --version
# atau
python3 --version
```

Jika belum terinstall, download dari: https://python.org/downloads/

### 2. MySQL Database
Pastikan database MySQL berjalan dan dapat diakses dari Laravel.

## 🚀 Installation Steps

### Step 1: Install Python Dependencies
```bash
# Masuk ke direktori project
cd "d:\KULIAH UNEJ\Semester 4\Pengembangan Perangkat Lunak Untuk Agroindustri Modern (F-TM-37541)-24252\Project\Indofresh"

# Install dependencies
pip install pandas numpy scikit-learn mysql-connector-python python-dotenv

# Atau menggunakan requirements file
pip install -r ai_scripts/requirements.txt
```

### Step 2: Test Python Script
```bash
# Test manual
python ai_scripts/fruit_prediction.py
```

### Step 3: Test Laravel Command
```bash
# Test dari Laravel
php artisan ai:predict-fruit

# Force regenerate prediction
php artisan ai:predict-fruit --force
```

## 🔧 Configuration

### Database Configuration
File `ai_scripts/config.py` akan otomatis membaca konfigurasi dari `.env` Laravel:
- `DB_HOST`
- `DB_USERNAME` 
- `DB_PASSWORD`
- `DB_DATABASE`

### Manual Configuration
Jika diperlukan, edit `ai_scripts/fruit_prediction.py` line 355-360:
```python
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': 'your_password',  # Sesuaikan dengan password MySQL
    'database': 'indofresh',
    'charset': 'utf8mb4'
}
```

## 📊 How It Works

### 1. Data Collection
- Mengambil data transaksi 30 hari terakhir
- Filter hanya produk buah-buahan
- Analisis pola penjualan harian

### 2. Feature Engineering
- Sales velocity (penjualan per hari)
- Sales trend (tren 7 hari terakhir vs sebelumnya)
- Time-based features (jam, hari dalam minggu)
- Aggregate statistics (total, rata-rata, dll)

### 3. Machine Learning Model
- **Algorithm**: Random Forest Classifier
- **Features**: 7 fitur utama (velocity, trend, statistics)
- **Target**: Nama produk buah
- **Training**: Otomatis setiap kali prediksi dijalankan

### 4. Prediction Output
- Prediksi buah yang akan dijual berikutnya
- Confidence score (0-100%)
- Top 3 prediksi alternatif
- Reasoning berbasis data

## 🎯 Usage

### Via Web Dashboard
1. Login sebagai admin
2. Buka menu "AI Analytics"
3. Lihat section "AI Fruit Prediction"
4. Klik "Update Prediction" untuk refresh

### Via Command Line
```bash
# Generate prediction
php artisan ai:predict-fruit

# Force regenerate (ignore cache)
php artisan ai:predict-fruit --force
```

### Via API
```javascript
// POST request to update prediction
fetch('/admin/ai/predict-fruit', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf_token
    }
})
```

## 📈 Features

### Dashboard Integration
- Real-time prediction display
- Confidence visualization
- Top 3 alternatives
- Data summary statistics
- Auto-refresh every 30 minutes

### Caching System
- Predictions cached for 1 hour
- Automatic cache invalidation
- Manual refresh capability

### Error Handling
- Graceful fallback if Python unavailable
- Database connection error handling
- Insufficient data scenarios

## 🔍 Troubleshooting

### Common Issues

#### 1. Python Not Found
```bash
# Windows
py --version

# Add Python to PATH or use full path
C:\Python39\python.exe ai_scripts/fruit_prediction.py
```

#### 2. MySQL Connection Error
- Check database credentials in `.env`
- Ensure MySQL service is running
- Verify database exists and accessible

#### 3. Missing Dependencies
```bash
# Install missing packages
pip install pandas numpy scikit-learn mysql-connector-python
```

#### 4. Permission Errors
```bash
# Windows: Run as Administrator
# Linux/Mac: Use sudo if needed
sudo pip install -r ai_scripts/requirements.txt
```

### Debug Mode
Enable debug output by modifying the Python script:
```python
# Add at top of main() function
import logging
logging.basicConfig(level=logging.DEBUG)
```

## 📝 Sample Output

### Successful Prediction
```json
{
  "status": "success",
  "prediction": {
    "predicted_fruit": "Apel Malang",
    "confidence": 0.85,
    "reasoning": "Predicted Apel Malang because it has above-average sales velocity, showing positive sales trend in recent days, consistently high demand.",
    "top_predictions": [
      {"fruit": "Apel Malang", "confidence": 0.85},
      {"fruit": "Jeruk Pontianak", "confidence": 0.72},
      {"fruit": "Pisang Cavendish", "confidence": 0.68}
    ]
  },
  "data_summary": {
    "total_transactions": 45,
    "unique_fruits": 8,
    "date_range": {
      "start": "2024-11-20",
      "end": "2024-12-20"
    }
  }
}
```

## 🔄 Automation

### Scheduled Updates
Tambahkan ke Laravel Scheduler (`app/Console/Kernel.php`):
```php
protected function schedule(Schedule $schedule)
{
    // Update prediction every hour
    $schedule->command('ai:predict-fruit')->hourly();
}
```

### Cron Job
```bash
# Add to crontab
0 * * * * cd /path/to/project && php artisan ai:predict-fruit
```

## 🎨 Customization

### Add More Fruit Keywords
Edit `ai_scripts/config.py`:
```python
FRUIT_KEYWORDS = [
    'buah', 'fruit', 'apel', 'jeruk', 'pisang',
    # Add more keywords here
    'durian', 'rambutan', 'mangosteen'
]
```

### Adjust Model Parameters
```python
MODEL_CONFIG = {
    'n_estimators': 200,  # More trees = better accuracy
    'random_state': 42,
    'sequence_length': 14,  # Look back 14 days instead of 7
}
```

## 📞 Support

Jika mengalami masalah:
1. Check log files di `storage/logs/laravel.log`
2. Run manual test: `python ai_scripts/fruit_prediction.py`
3. Verify database connection
4. Check Python dependencies

## 🎉 Success Indicators

✅ Python script runs without errors
✅ Laravel command executes successfully  
✅ Dashboard shows prediction results
✅ Cache system working (faster subsequent loads)
✅ Auto-refresh functioning
