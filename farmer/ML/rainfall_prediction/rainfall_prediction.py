import pandas as pd
import sys
import os

# 1. Dynamically find the CSV file relative to this script
script_dir = os.path.dirname(os.path.abspath(__file__))
# MAKE SURE THIS FILENAME MATCHES YOUR CSV EXACTLY
csv_path = os.path.join(script_dir, 'rainfall_in_india_1901-2015.csv')

def predict_rainfall(state, month):
    try:
        # Check if CSV exists
        if not os.path.exists(csv_path):
            return f"Error: CSV file not found at {csv_path}"

        # Load the dataset
        df = pd.read_csv(csv_path)
        
        # Filter by subdivision (ensuring case-insensitive match)
        state_data = df[df['SUBDIVISION'].str.upper() == state.upper()]

        if state_data.empty:
            return f"No data found for region: {state}"

        # Calculate average for the month (ensuring month is uppercase)
        # We assume the CSV has columns like 'JAN', 'FEB', etc.
        avg_rainfall = state_data[month.upper()].mean()
        
        if pd.isna(avg_rainfall):
            return "0.00"
            
        return str(round(avg_rainfall, 2))

    except Exception as e:
        return f"Python Error: {str(e)}"

# 2. Get arguments from PHP
if len(sys.argv) > 2:
    Jregion = sys.argv[1]
    Jmonth = sys.argv[2]
    
    result = predict_rainfall(Jregion, Jmonth)
    print(result)
else:
    print("Error: Missing arguments provided to Python script.")