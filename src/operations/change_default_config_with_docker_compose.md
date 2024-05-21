# Change Default Config with Docker Compose

You can overwrite any config parameters using docker compose. You need to prefix each variable with `QDB_`, capitalise
the variable name, and replace any dots by underscores. The docker compose file in this example overwrites the
parameters `pg.user` and `pg.password`.

```
version: "3.9"

services:
  questdb:
    image: questdb/questdb
    container_name: custom_questdb
    restart: always
    ports:
      - "8812:8812"
      - "9000:9000"
      - "9009:9009"
      - "9003:9003"
    extra_hosts:
      - "host.docker.internal:host-gateway"
    environment:
      - QDB_PG_USER=borat
      - QDB_PG_PASSWORD=clever_password
    volumes:
      - ./questdb/questdb_root:/var/lib/questdb/
   ```
