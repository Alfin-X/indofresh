#!/usr/bin/env python3
"""
Configuration file for AI Fruit Prediction System
"""

import os
from dotenv import load_dotenv

# Load environment variables from Laravel .env file
load_dotenv(os.path.join(os.path.dirname(__file__), '..', '.env'))

# Database configuration
DB_CONFIG = {
    'host': os.getenv('DB_HOST', 'localhost'),
    'user': os.getenv('DB_USERNAME', 'root'),
    'password': os.getenv('DB_PASSWORD', ''),
    'database': os.getenv('DB_DATABASE', 'indofresh'),
    'charset': 'utf8mb4'
}

# AI Model configuration
MODEL_CONFIG = {
    'n_estimators': 100,
    'random_state': 42,
    'sequence_length': 7,  # Days to look back for patterns
    'prediction_cache_hours': 1,  # How long to cache predictions
}

# Fruit categories and keywords for filtering
FRUIT_KEYWORDS = [
    'buah', 'fruit', 'apel', 'apple', 'jeruk', 'orange', 'pisang', 'banana',
    'mangga', 'mango', 'anggur', 'grape', 'strawberry', 'stroberi',
    'melon', 'semangka', 'watermelon', 'nanas', 'pineapple', 'pepaya', 'papaya',
    'jambu', 'guava', 'rambutan', 'leci', 'lychee', 'durian', 'salak',
    'kelengkeng', 'longan', 'markisa', 'passion fruit', 'kiwi', 'pir', 'pear'
]

# Logging configuration
LOGGING_CONFIG = {
    'level': 'INFO',
    'format': '%(asctime)s - %(levelname)s - %(message)s',
    'file': 'ai_prediction.log'
}
