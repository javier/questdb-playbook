# Inserting via ILP

QuestDB doesn't maintain an official PHP library, but since the ILP protocol is text-based, you can easily send your
data using PHP.

## ILP Protocol Overview

You can get all the details about ILP at [the QuestDB Docs](https://questdb.io/docs/reference/api/ilp/advanced-settings/),
but in a nutshell you need to compose a line like this:

```
table_name,comma_separated_symbols comma_separated_non_symbols optional_timestamp\n
```

These two lines would be well-formed ILP messages.

```
readings,city=London,make=Omron temperature=23.5,humidity=0.343 1465839830100400000\n
readings,city=Bristol,make=Honeywell temperature=23.2,humidity=0.443\n
```

## ILP Over HTTP

QuestDB supports ILP data via HTTP or TCP. HTTP is the recommended way, so we will cover it first.

You need to send your ILP-formatted rows to the API port (defaults to `9000`) and `/write` endpoint, as in `http://localhost:9000/write`. For higher throughput, it is advisable to send batches of rows.

The following script gives you a basic way of batching rows in a buffer, and flushing when either a maximum number of rows, or a maximum elapsed time has passed. The script tries to flush on exit, but if you are controlling execution it would be advisable to flush manually on exit.



```php
{{#include ilp_http_buffering.php}}
```



## ILP Over TCP Socket

TCP over Socket is less reliable but gives you higher throughput. The message format is the same, you just need to change the transport.

Find below a basic example, with no batching or ILP parsing.

```php
{{#include ilp_tcp.php}}
```
