# Forcing a designated timestamp

Sometimes you need to force a designated timestamp in your query. This happens if you want to run some operations, like
SAMPLE BY, with a non-designated timestamp column, but sometimes also when QuestDB applies some functions or joins and
fails to recognise the designated timestamp. In those cases we can force it using the `timestamp` keyword.

If you run this query on your web console, you will see the `time` column is not considered a designated timestamp, as
we casted it to String and then back to a timestamp.

```sql
  SELECT
    TO_TIMESTAMP(timestamp::STRING, 'yyyy-MM-ddTHH:mm:ss.SSSUUUZ') time,
    id,
    exchange,
    price
  FROM
    nasdaq_trades;

```

You can force the timestamp and run operations like `SAMPLE BY` using the `timestamp` keyword.

```sql
WITH t AS (
(
  SELECT
    TO_TIMESTAMP(timestamp::STRING, 'yyyy-MM-ddTHH:mm:ss.SSSUUUZ') time,
    id,
    exchange,
    price
  FROM
    nasdaq_trades
  ORDER BY time
) TIMESTAMP (time) )
SELECT time, COUNT() FROM t SAMPLE BY 10m;
```

|            time            | COUNT |
|----------------------------|-------|
| 2023-09-05 16:00:00.000000 |  2694 |
| 2023-09-05 16:10:00.000000 |  2604 |
| 2023-09-05 16:20:00.000000 |  2440 |
| 2023-09-05 16:30:00.000000 |  2406 |
| 2023-09-05 16:40:00.000000 |  2383 |
| 2023-09-05 16:50:00.000000 |  2315 |


The designated timestamp is often lost when doing a `UNION`. It makes sense, because QuestDB cannot know if the results
of the `UNION` are in order, and it is crucial designated timestamps are always in order. We can just apply the
`ORDER BY` and then force the designated timestamp, as in:

```sql
(
SELECT * FROM
(
SELECT timestamp, id FROM nasdaq_trades
UNION
SELECT timestamp, id FROM nasdaq_trades
) ORDER BY timestamp
)
TIMESTAMP(timestamp);
```

|         timestamp          |  id  |
|----------------------------|------|
| 2023-09-05 16:00:00.000000 | TSLA |
| 2023-09-05 16:00:00.000000 | AMD  |
| 2023-09-05 16:00:01.000000 | AMD  |
| 2023-09-05 16:00:01.000000 | NVDA |
| 2023-09-05 16:00:01.000000 | AMZN |
| 2023-09-05 16:00:01.000000 | MSFT |
| 2023-09-05 16:00:01.000000 | AAPL |
| 2023-09-05 16:00:02.000000 | TSLA |
| 2023-09-05 16:00:02.000000 | NVDA |
| 2023-09-05 16:00:02.000000 | AAPL |
