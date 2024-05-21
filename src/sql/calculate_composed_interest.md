# Calculate composed interest

Imagine you want to calculate composed interest over 5 years, starting at amount 1, with an interest of 0.1, so we get a result like:

```csv
timestamp,initial_principal,interest_rate,year_principal,compounding_amount
2000,1000.0,0.1,1000.0,1100.0
2001,1000.0,0.1,1100.0,1210.0
2002,1000.0,0.1,1210.0,1331.0
2003,1000.0,0.1,1331.0,1464.1
2004,1000.0,0.1,1464.1,1610.51

```

We can use the `POWER` function to calculate the amount, then we can use the `FIRST_VALUE` window function to get the value from the row before.

You need to provide the initial year (twice), the initial_principal, the
annual interest rate, and the number of years (5 in the example)


```sql
WITH
year_series AS (
    SELECT 2000 as start_year, 2000 + (x - 1) AS timestamp,
    0.1 AS interest_rate, 1000.0 as initial_principal
    FROM long_sequence(5)
),
compounded_values AS (
    SELECT
        timestamp,
        initial_principal,
        interest_rate,
        initial_principal *
            POWER(
                  1 + interest_rate,
                  timestamp - start_year + 1
                  ) AS compounding
    FROM
        year_series
), compounding_year_before AS (
SELECT
    timestamp,
    initial_principal,
    interest_rate,
    FIRST_VALUE(cv.compounding)
        OVER (
              ORDER BY timestamp
              ROWS between 1 preceding and 1 preceding
              ) AS year_principal,
    cv.compounding as compounding_amount
FROM
    compounded_values cv
ORDER BY
    timestamp
    )
select timestamp, initial_principal, interest_rate,
coalesce(year_principal, initial_principal) as year_principal,
compounding_amount
from compounding_year_before

```
