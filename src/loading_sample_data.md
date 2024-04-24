 # Loading Sample Data

Most of the queries in this Playbook use tables from the finance dataset at the
[QuestDB Sample Datasets](https://github.com/questdb/sample-datasets/tree/main)
repository. Specifically, we use the `btc_trades` and the `nasdaq_trades` tables.

Those two tables represent real trading data, one for a crypto exchange, one for
a finance exchange, for an hour of data starting from `2023-09-05T16:00:00Z`.

Refer to the samples repository for more info, but if you just want to create and
import the datasets using `curl`, you can do it via:

## btc_trades

This will create and upload 5882 rows into the btc_trades table with the structure

```sql
CREATE TABLE IF NOT EXISTS 'btc_trades' (
    symbol SYMBOL capacity 256 CACHE,
    side SYMBOL capacity 256 CACHE,
    price DOUBLE,
    amount DOUBLE,
    timestamp TIMESTAMP
) timestamp (timestamp) PARTITION BY DAY WAL
DEDUP UPSERT KEYS(timestamp, symbol, price, amount);
```

The following commands assume you have internet connectivity and a QuestDB instance with the default configuration.

```bash
curl --silent https://raw.githubusercontent.com/questdb/sample-datasets/main/finance/btc_trades_create_table.sql|curl -G --data-urlencode query@- http://localhost:9000/exec

curl --silent https://raw.githubusercontent.com/questdb/sample-datasets/main/finance/btc_trades.csv|curl -F data=@- "http://localhost:9000/imp?name=btc_trades"
```

This is a sample from the table:

```sql
SELECT * FROM btc_trades LIMIT 5;
```

 symbol  | side |  price   |   amount   |         timestamp
---------|------|----------|------------|----------------------------
 BTC-USD | sell | 25741.02 | 0.02188038 | 2023-09-05 16:00:01.281719
 BTC-USD | buy  | 25741.03 | 0.00184646 | 2023-09-05 16:00:01.775613
 BTC-USD | buy  | 25741.03 |   3.844E-5 | 2023-09-05 16:00:02.722748
 BTC-USD | sell | 25741.02 | 0.00588556 | 2023-09-05 16:00:03.465915
 BTC-USD | buy  | 25741.03 | 0.01233132 | 2023-09-05 16:00:03.830519

## nasdaq_trades

This will create and upload 14842 rows into the nasdaq_trades table with the structure

```sql
CREATE TABLE IF NOT EXISTS nasdaq_trades(
    timestamp TIMESTAMP,
    'id' SYMBOL capacity 256 CACHE,
    exchange SYMBOL capacity 256 CACHE,
    quoteType LONG,
    price DOUBLE,
    marketHours LONG,
    changePercent DOUBLE,
    dayVolume DOUBLE,
    change DOUBLE,
    priceHint LONG
) TIMESTAMP (timestamp) PARTITION BY DAY WAL
DEDUP UPSERT KEYS(timestamp, id);
```

The following commands assume you have internet connectivity and a QuestDB instance with the default configuration.

```bash
curl --silent https://raw.githubusercontent.com/questdb/sample-datasets/main/finance/nasdaq_trades_create_table.sql|curl -G --data-urlencode query@- http://localhost:9000/exec

curl --silent https://raw.githubusercontent.com/questdb/sample-datasets/main/finance/nasdaq_trades.csv|curl -F data=@- "http://localhost:9000/imp?name=nasdaq_trades"

```

This is a sample from the table:

```sql
SELECT * FROM nasdaq_trades LIMIT 5;
```

|         timestamp          |  id  | exchange | quoteType |      price       | marketHours |  changePercent  |  dayVolume  |     change      | priceHint |
|----------------------------|------|----------|-----------|------------------|-------------|-----------------|-------------|-----------------|-----------|
| 2023-09-05 16:00:00.000000 | TSLA | NMS      |         8 | 252.785003662109 |           1 |  3.173343658447 | 6.8581834E7 |  7.775009155273 |         2 |
| 2023-09-05 16:00:00.000000 | AMD  | NMS      |         8 | 110.241096496582 |           1 |  0.722795426845 | 2.9575824E7 |  0.791099548339 |         2 |
| 2023-09-05 16:00:01.000000 | AMD  | NMS      |         8 | 110.349998474121 |           1 |  0.822294712066 |  2.958563E7 |  0.900001525878 |         2 |
| 2023-09-05 16:00:01.000000 | NVDA | NMS      |         8 | 482.644989013671 |           1 | -0.504031658172 | 2.0932402E7 | -2.445007324218 |         2 |
| 2023-09-05 16:00:01.000000 | AMZN | NMS      |         8 | 136.399993896484 |           1 |  -1.24529492855 | 1.8136002E7 | -1.720001220703 |         2 |
