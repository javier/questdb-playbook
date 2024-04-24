#!/bin/bash

# Prompt user for SQL query and use 'END' as a delimiter to finish input
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

# Display the SQL query properly formatted as Markdown
printf "\`\`\`sql\n%s\`\`\`\n\n" "$SQL_QUERY"

# Execute the SQL query based on the environment choice
if [[ -z "$ENV_CHOICE" ]] || [[ "$ENV_CHOICE" == "local" ]]; then
    # Local execution with psql
    echo "$SQL_QUERY" | psql "postgresql://admin:quest@localhost:8812/qdb" --pset="footer=off" --pset="format=aligned" --pset="border=1" --pset="null=(null)" --quiet | tr '+' '|'
elif [[ "$ENV_CHOICE" == "docker" ]]; then
    # Docker execution
    echo "$SQL_QUERY" | docker run -i --rm jbergknoff/postgresql-client "postgresql://admin:quest@host.docker.internal:8812/qdb" -c - --echo-all --pset="footer=off" --pset="format=aligned" --pset="border=1" --pset="null=(null)" --quiet | tr '+' '|'
else
    echo "Invalid choice. Please run the script again and type 'local' or 'docker'."
fi

