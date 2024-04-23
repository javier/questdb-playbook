# About this playbook

Welcome to the QuestDB Playbook! Developed by the QuestDB team, this guide complements
the comprehensive official documentation of QuestDB by focusing on practical, real-world applications of QuestDB’s features. It provides concise examples that demonstrate how to effectively use the database in various projects.

# About QuestDB

QuestDB is an open-source time-series database for high throughput ingestion and fast
SQL queries with operational simplicity.

QuestDB is well-suited for financial market data, IoT sensor data, ad-tech and real-time dashboards. It shines for datasets with high cardinality and is a drop-in replacement for InfluxDB via support for the InfluxDB Line Protocol.

## When to use QuestDB

QuestDB is a perfect choice if you need to keep track of changes of data over time, potentially with fast and ever-growing datasets, and you need to query your data with
time-based filters and aggregations.

## When not to use QuestDB

When your data is unstructured or heavily nested. When most of your queries don't need
filter or aggregations based on your timestamp. When your use case requires an ACID
compliant database.


# Getting Started with QuestDB

To use the examples provided in this playbook, you'll need QuestDB installed on
your system. For detailed installation instructions, please visit
[QuestDB.io](https://questdb.io).

### Quick Start with Docker

If you have Docker in your system, the quickest way to start is with the following command:

```bash
docker run -p 9000:9000 -p 9009:9009 -p 8812:8812 -p 9003:9003 questdb/questdb
```

This command starts QuestDB with all necessary ports open, making it ready for
immediate use on your local machine for development and testing. Note that this
setup uses ephemeral storage, meaning all data will be lost when the container
is stopped.

## Using This Book

The playbook is structured to guide you through using QuestDB with concrete
examples. It is suitable for both new users and those who have experience with
time series databases, enhancing your ability to manage and analyze time series
data effectively.
