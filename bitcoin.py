import pandas as pd
import matplotlib.pyplot as plt
import seaborn as sns

# Load CSVs
sentiment_df = pd.read_csv("fear_greed_index.csv")
trader_df = pd.read_csv("historical_data.csv")

# Clean and rename columns
sentiment_df.columns = sentiment_df.columns.str.strip().str.lower()
trader_df.columns = trader_df.columns.str.strip()

# Parse dates
sentiment_df['date'] = pd.to_datetime(sentiment_df['date'], errors='coerce')
trader_df['Timestamp IST'] = pd.to_datetime(trader_df['Timestamp IST'], format="%d-%m-%Y %H:%M", errors='coerce')
trader_df['Date'] = trader_df['Timestamp IST'].dt.normalize()

# Normalize sentiment labels
def classify_sentiment(label):
    if "extreme" in label.lower():
        return 0  # Extreme Fear
    elif "fear" in label.lower():
        return 1  # Fear
    else:
        return 2  # Greed

sentiment_df['Sentiment'] = sentiment_df['classification'].apply(classify_sentiment)

# Merge datasets on date
merged_df = pd.merge(trader_df, sentiment_df[['date', 'Sentiment']], left_on='Date', right_on='date', how='left')
merged_df.dropna(subset=['Sentiment'], inplace=True)

# Add a win/loss column
merged_df['win'] = merged_df['Closed PnL'] > 0

# Summary statistics
print("Average Closed PnL by Sentiment:")
print(merged_df.groupby('Sentiment')['Closed PnL'].mean(), '\n')

print("Win Rate by Sentiment:")
print(merged_df.groupby('Sentiment')['win'].mean(), '\n')

# Visualization: PnL distribution by Sentiment
plt.figure(figsize=(10, 6))
sns.boxplot(x='Sentiment', y='Closed PnL', data=merged_df)
plt.xticks([0, 1, 2], ['Extreme Fear', 'Fear', 'Greed'])
plt.title('Closed PnL by Market Sentiment')
plt.xlabel('Market Sentiment')
plt.ylabel('Closed PnL')
plt.grid(True)
plt.tight_layout()
plt.show()

# Save results
merged_df.to_csv("merged_trader_sentiment.csv", index=False)
print("Merged dataset saved as merged_trader_sentiment.csv.")
