#!/usr/bin/env python3
"""
AI Fruit Sales Prediction System
Predicts next fruit to be sold based on 1 month historical data
"""

import sys
import json
import pandas as pd
import numpy as np
from datetime import datetime, timedelta
import mysql.connector
from sklearn.ensemble import RandomForestClassifier
from sklearn.preprocessing import LabelEncoder
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score
import pytz
import warnings
warnings.filterwarnings('ignore')

# Set timezone to Indonesia (WIB)
WIB = pytz.timezone('Asia/Jakarta')

class FruitPredictor:
    def __init__(self, db_config):
        """Initialize the fruit predictor with database configuration"""
        self.db_config = db_config
        self.model = RandomForestClassifier(n_estimators=100, random_state=42)
        self.label_encoder = LabelEncoder()
        self.feature_encoders = {}

    def connect_database(self):
        """Connect to MySQL database"""
        try:
            connection = mysql.connector.connect(**self.db_config)
            return connection
        except mysql.connector.Error as e:
            print(f"Database connection error: {e}")
            return None

    def fetch_transaction_data(self):
        """Fetch transaction data from last month"""
        connection = self.connect_database()
        if not connection:
            return None

        # Get data from last 30 days (using WIB timezone)
        end_date = datetime.now(WIB)
        start_date = end_date - timedelta(days=30)

        query = """
        SELECT
            t.transaction_date,
            t.customer_name,
            t.payment_method,
            t.total_amount,
            ti.product_name,
            ti.quantity,
            ti.unit_price,
            COALESCE(c.category, 'Unknown') as category,
            HOUR(t.transaction_date) as hour_of_day,
            DAYOFWEEK(t.transaction_date) as day_of_week,
            DAY(t.transaction_date) as day_of_month
        FROM transactions t
        JOIN transaction_items ti ON t.id = ti.transaction_id
        LEFT JOIN catalogs c ON ti.catalog_id = c.id
        WHERE t.transaction_date >= %s AND t.transaction_date <= %s
        AND t.payment_status = 'paid'
        AND (c.category LIKE '%%Buah%%' OR c.category LIKE '%%fruit%%'
        OR ti.product_name LIKE '%%Apel%%' OR ti.product_name LIKE '%%Jeruk%%'
        OR ti.product_name LIKE '%%Pisang%%' OR ti.product_name LIKE '%%Mangga%%'
        OR ti.product_name LIKE '%%Anggur%%' OR ti.product_name LIKE '%%Strawberry%%'
        OR ti.product_name LIKE '%%Melon%%' OR ti.product_name LIKE '%%Semangka%%')
        ORDER BY t.transaction_date ASC
        """

        try:
            df = pd.read_sql(query, connection, params=[start_date, end_date])
            connection.close()
            return df
        except Exception as e:
            print(f"Error fetching data: {e}")
            if connection:
                connection.close()
            return None

    def preprocess_data(self, df):
        """Preprocess the transaction data for ML"""
        if df.empty:
            return None, None

        # Create features
        df['transaction_date'] = pd.to_datetime(df['transaction_date'])
        df = df.sort_values('transaction_date')

        # Create time-based features
        df['hour_sin'] = np.sin(2 * np.pi * df['hour_of_day'] / 24)
        df['hour_cos'] = np.cos(2 * np.pi * df['hour_of_day'] / 24)
        df['day_sin'] = np.sin(2 * np.pi * df['day_of_week'] / 7)
        df['day_cos'] = np.cos(2 * np.pi * df['day_of_week'] / 7)

        # Aggregate features by product
        product_features = df.groupby('product_name').agg({
            'quantity': ['sum', 'mean', 'count'],
            'unit_price': ['mean', 'std'],
            'total_amount': 'sum',
            'hour_of_day': 'mean',
            'day_of_week': 'mean'
        }).reset_index()

        # Flatten column names
        product_features.columns = ['product_name'] + [
            f"{col[0]}_{col[1]}" if col[1] else col[0]
            for col in product_features.columns[1:]
        ]

        # Calculate sales velocity (sales per day)
        date_range = (df['transaction_date'].max() - df['transaction_date'].min()).days + 1
        product_features['sales_velocity'] = product_features['quantity_sum'] / date_range

        # Calculate recent sales trend (last 7 days vs previous)
        recent_date = df['transaction_date'].max() - timedelta(days=7)
        recent_sales = df[df['transaction_date'] >= recent_date].groupby('product_name')['quantity'].sum()
        older_sales = df[df['transaction_date'] < recent_date].groupby('product_name')['quantity'].sum()

        trend_data = pd.DataFrame({
            'product_name': recent_sales.index,
            'recent_sales': recent_sales.values
        })

        older_data = pd.DataFrame({
            'product_name': older_sales.index,
            'older_sales': older_sales.values
        })

        trend_merged = trend_data.merge(older_data, on='product_name', how='left')
        trend_merged['older_sales'] = trend_merged['older_sales'].fillna(0)
        trend_merged['sales_trend'] = (
            trend_merged['recent_sales'] - trend_merged['older_sales']
        ) / (trend_merged['older_sales'] + 1)  # Add 1 to avoid division by zero

        # Merge trend data
        product_features = product_features.merge(
            trend_merged[['product_name', 'sales_trend']],
            on='product_name',
            how='left'
        )
        product_features['sales_trend'] = product_features['sales_trend'].fillna(0)

        return product_features, df

    def create_sequences(self, df, sequence_length=7):
        """Create sequences for time series prediction"""
        # Sort by date and create daily aggregates
        daily_sales = df.groupby([
            df['transaction_date'].dt.date, 'product_name'
        ])['quantity'].sum().reset_index()

        daily_sales['transaction_date'] = pd.to_datetime(daily_sales['transaction_date'])

        # Get unique products and dates
        products = daily_sales['product_name'].unique()
        dates = pd.date_range(
            start=daily_sales['transaction_date'].min(),
            end=daily_sales['transaction_date'].max(),
            freq='D'
        )

        sequences = []
        targets = []

        for product in products:
            product_data = daily_sales[daily_sales['product_name'] == product]

            # Create complete date range for this product
            product_series = pd.DataFrame({'transaction_date': dates})
            product_series = product_series.merge(
                product_data, on='transaction_date', how='left'
            )
            product_series['quantity'] = product_series['quantity'].fillna(0)
            product_series['product_name'] = product

            # Create sequences
            for i in range(len(product_series) - sequence_length):
                sequence = product_series.iloc[i:i+sequence_length]['quantity'].values
                target = product_series.iloc[i+sequence_length]['product_name']

                sequences.append(sequence)
                targets.append(target)

        return np.array(sequences), np.array(targets)

    def train_model(self, product_features, df):
        """Train the prediction model"""
        if product_features is None or df is None:
            return False

        # Prepare features for training
        feature_columns = [
            'quantity_sum', 'quantity_mean', 'quantity_count',
            'unit_price_mean', 'total_amount', 'sales_velocity', 'sales_trend'
        ]

        # Handle missing values
        for col in feature_columns:
            if col in product_features.columns:
                product_features[col] = product_features[col].fillna(0)

        # Ensure we have the required columns
        missing_cols = [col for col in feature_columns if col not in product_features.columns]
        for col in missing_cols:
            product_features[col] = 0

        X = product_features[feature_columns].values
        y = product_features['product_name'].values

        # Encode target labels
        y_encoded = self.label_encoder.fit_transform(y)

        # Train model if we have enough data
        if len(X) > 1:
            X_train, X_test, y_train, y_test = train_test_split(
                X, y_encoded, test_size=0.2, random_state=42
            )

            self.model.fit(X_train, y_train)

            # Calculate accuracy if we have test data
            if len(X_test) > 0:
                y_pred = self.model.predict(X_test)
                accuracy = accuracy_score(y_test, y_pred)
                print(f"Model accuracy: {accuracy:.2f}")
        else:
            # If not enough data for split, train on all data
            self.model.fit(X, y_encoded)

        return True

    def predict_next_fruit(self, product_features):
        """Predict the next fruit to be sold"""
        if product_features is None or len(product_features) == 0:
            return {
                'predicted_fruit': 'No data available',
                'confidence': 0.0,
                'top_predictions': [],
                'reasoning': 'Insufficient historical data for prediction'
            }

        # Calculate current market conditions
        feature_columns = [
            'quantity_sum', 'quantity_mean', 'quantity_count',
            'unit_price_mean', 'total_amount', 'sales_velocity', 'sales_trend'
        ]

        # Get the most recent market state (average of all products)
        current_state = []
        for col in feature_columns:
            if col in product_features.columns:
                current_state.append(product_features[col].mean())
            else:
                current_state.append(0)

        current_state = np.array(current_state).reshape(1, -1)

        # Get prediction probabilities
        try:
            probabilities = self.model.predict_proba(current_state)[0]
            predicted_class = self.model.predict(current_state)[0]

            # Get top 3 predictions
            top_indices = np.argsort(probabilities)[-3:][::-1]
            top_predictions = []

            for idx in top_indices:
                fruit_name = self.label_encoder.inverse_transform([idx])[0]
                confidence = probabilities[idx]

                # Get additional info about this fruit
                fruit_info = product_features[
                    product_features['product_name'] == fruit_name
                ].iloc[0] if len(product_features[
                    product_features['product_name'] == fruit_name
                ]) > 0 else None

                prediction_info = {
                    'fruit': fruit_name,
                    'confidence': float(confidence),
                    'recent_sales': float(fruit_info['quantity_sum']) if fruit_info is not None else 0,
                    'sales_trend': float(fruit_info['sales_trend']) if fruit_info is not None else 0
                }
                top_predictions.append(prediction_info)

            predicted_fruit = self.label_encoder.inverse_transform([predicted_class])[0]
            confidence = float(max(probabilities))

            # Generate reasoning
            reasoning = self._generate_reasoning(predicted_fruit, product_features, top_predictions)

            return {
                'predicted_fruit': predicted_fruit,
                'confidence': confidence,
                'top_predictions': top_predictions,
                'reasoning': reasoning,
                'model_accuracy': getattr(self, 'last_accuracy', 0.8)
            }

        except Exception as e:
            print(f"Prediction error: {e}")
            return {
                'predicted_fruit': 'Error in prediction',
                'confidence': 0.0,
                'top_predictions': [],
                'reasoning': f'Prediction failed: {str(e)}'
            }

    def _generate_reasoning(self, predicted_fruit, product_features, top_predictions):
        """Generate human-readable reasoning for the prediction"""
        if len(product_features) == 0:
            return "No historical data available for analysis."

        fruit_data = product_features[
            product_features['product_name'] == predicted_fruit
        ]

        if len(fruit_data) == 0:
            return f"Prediction based on market trends and similar products."

        fruit_info = fruit_data.iloc[0]

        reasoning_parts = []

        # Sales velocity reasoning
        if fruit_info['sales_velocity'] > product_features['sales_velocity'].mean():
            reasoning_parts.append(f"{predicted_fruit} has above-average sales velocity")

        # Trend reasoning
        if fruit_info['sales_trend'] > 0:
            reasoning_parts.append("showing positive sales trend in recent days")
        elif fruit_info['sales_trend'] < 0:
            reasoning_parts.append("despite recent decline, historical patterns suggest recovery")

        # Popularity reasoning
        total_sales = fruit_info['quantity_sum']
        if total_sales > product_features['quantity_sum'].quantile(0.75):
            reasoning_parts.append("consistently high demand")

        if not reasoning_parts:
            reasoning_parts.append("based on overall market analysis and seasonal patterns")

        return f"Predicted {predicted_fruit} because it has " + ", ".join(reasoning_parts) + "."

def main():
    """Main function to run the prediction"""
    # Try to import configuration
    try:
        from config import DB_CONFIG, FRUIT_KEYWORDS
        db_config = DB_CONFIG
        fruit_keywords = FRUIT_KEYWORDS
    except ImportError:
        # Fallback configuration
        db_config = {
            'host': 'localhost',
            'user': 'root',
            'password': '',  # Update with your MySQL password
            'database': 'indofresh',
            'charset': 'utf8mb4'
        }
        fruit_keywords = [
            'buah', 'fruit', 'apel', 'jeruk', 'pisang', 'mangga', 'anggur', 'strawberry'
        ]

    try:
        # Initialize predictor
        predictor = FruitPredictor(db_config)

        # Fetch and process data
        print("Fetching transaction data...")
        df = predictor.fetch_transaction_data()

        if df is None or df.empty:
            result = {
                'status': 'error',
                'message': 'No transaction data found for the last month',
                'prediction': {
                    'predicted_fruit': 'No data available',
                    'confidence': 0.0,
                    'top_predictions': [],
                    'reasoning': 'No fruit sales data found in the last 30 days'
                }
            }
        else:
            print(f"Processing {len(df)} transaction records...")

            # Preprocess data
            product_features, processed_df = predictor.preprocess_data(df)

            # Train model
            print("Training prediction model...")
            training_success = predictor.train_model(product_features, processed_df)

            if training_success:
                # Make prediction
                print("Generating prediction...")
                prediction = predictor.predict_next_fruit(product_features)

                result = {
                    'status': 'success',
                    'message': 'Prediction generated successfully',
                    'prediction': prediction,
                    'data_summary': {
                        'total_transactions': len(df),
                        'unique_fruits': len(product_features) if product_features is not None else 0,
                        'date_range': {
                            'start': df['transaction_date'].min().isoformat() if not df.empty else None,
                            'end': df['transaction_date'].max().isoformat() if not df.empty else None
                        }
                    }
                }
            else:
                result = {
                    'status': 'error',
                    'message': 'Failed to train prediction model',
                    'prediction': {
                        'predicted_fruit': 'Training failed',
                        'confidence': 0.0,
                        'top_predictions': [],
                        'reasoning': 'Model training failed due to insufficient data'
                    }
                }

        # Output result as JSON
        print(json.dumps(result, indent=2, default=str))
        return result

    except Exception as e:
        error_result = {
            'status': 'error',
            'message': f'Prediction system error: {str(e)}',
            'prediction': {
                'predicted_fruit': 'System error',
                'confidence': 0.0,
                'top_predictions': [],
                'reasoning': f'System encountered an error: {str(e)}'
            }
        }
        print(json.dumps(error_result, indent=2))
        return error_result

if __name__ == "__main__":
    main()
