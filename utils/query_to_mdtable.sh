#!/bin/bash

# Function to execute and process SQL query
execute_sql() {
    local query="$1"
    local command="$2"
    local conn_string="$3"

    if [[ "$command" == "psql" ]]; then
        echo "$query" | psql "$conn_string" --pset="footer=off" --pset="format=aligned" --pset="border=2" --pset="null=(null)" --quiet | tr '+' '|' | sed '1d;N;$!P;$!D;$d'
    else
        # Properly handling the Docker command, ensuring SQL is passed as a string argument to -c
        echo "$query" | docker run -i --platform linux/amd64 --rm jbergknoff/postgresql-client "$conn_string" psql -c "$(cat)"  --pset="footer=off" --pset="format=aligned" --pset="border=2" --pset="null=(null)" --quiet | tr '+' '|' | sed '1d;N;$!P;$!D;$d'
    fi
}

# Prompt user for SQL query and use ';' on a single line as a delimiter to finish input
echo "Enter SQL query (end input with ';' on a single line):"
SQL_QUERY=""
while IFS= read -r line; do
    if [[ "$line" == ";" ]]; then
        break
    fi
    SQL_QUERY+="$line"$'\n'
done

# Choose environment: Local or Docker
echo -e "\nRun locally or in Docker? (local/docker):"
read ENV_CHOICE

# Default to local if no input is provided
ENV_CHOICE=${ENV_CHOICE:-local}

# Display the SQL query properly formatted as Markdown
printf "\`\`\`sql\n%s\`\`\`\n\n" "$SQL_QUERY"

# Execute the SQL query based on the environment choice
case "$ENV_CHOICE" in
    local)
        # Local execution with psql
        execute_sql "$SQL_QUERY" "psql" "postgresql://admin:quest@localhost:8812/qdb"
        ;;
    docker)
        # Docker execution
        execute_sql "$SQL_QUERY" "docker run -i --platform linux/amd64 --rm jbergknoff/postgresql-client" "postgresql://admin:quest@host.docker.internal:8812/qdb"
        ;;
    *)
        echo "Invalid choice. Please run the script again and type 'local' or 'docker'."
        ;;
esac


