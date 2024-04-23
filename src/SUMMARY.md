# Summary

[About this playbook]()

# Sample datasets
- [Loading Sample Data](./loading_sample_data.md)

# Querying with SQL

- [Force designated timestamp](./sql/force-designated-timestamp.md)
- [Pivoting Results](./sql/pivoting.md)
- [Working with time-ranges](./sql/time-ranges.md)
- [Window Functions](./sql/window-functions.md)
    - [Elapsed time](./sql/elapsed_time.md)
    - [Compare with row(s) before](./sql/lag_window_function.md)
    - [Filtering Window Functions Output]()
    - [Moving average by time or offset]()
- [Dealing with timezones]()
- [Finding Correlations]()
- [Sampling and Interpolation]()
- [Anomaly Detection]()
- [Find Latest Data]()
- [Joining by time (ASOF/LT/SPLICE)]()
- [Check configuration values](./sql/configuration_values.md)

---

# Programmatic QuestDB

- [Rest API]()
    - [Pagination]()
    - [Custom Schema]()
- [Python]()
    - [Async]()
- [Go]()
- [Java]()
    - [Embedded]()
- [Rust]()

---

# Integrations

- [Kafka Connect]()
- [Kafka Ksql]()
    - [Pre-processing JSON]()
- [Grafana]()
    - [Filtering by date]()
- [Pandas]()
    - [Writing data]()
- [Time-Series forecasting]()
    - [Prophet]()
    - [Scikit-learn]()

---

# Security and ACL

- [Read-only access]()
- [Granular Access]()

---

#  Performance tips and tricks

- [Materialize views]()
- [Symbols, Strings, and Varchars]()
- [Early filtering]()
- [Flushing]()

---

# Operations

- [Disable Auto Table/Column Creation]()
    - [Via Configuration]()
    - [Via ACLs]()
- [ZFS file compression]()
- [Partitions lifecycle]()
- [Snapshotting]()
- [Double ingestion]()
    - [Using client libraries]()
    - [Using Kafka Connect]()
- [Resuming Suspended Tables]()
- [Checking Transactions]()
- [Checking Active Queries]()
- [Persisting Monitoring Metrics]()
    - [Using Prometheus]()
    - [Using Telegraf]()
