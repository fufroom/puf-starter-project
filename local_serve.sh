#!/bin/bash

CONFIG_FILE="src/config.json"

if [[ ! -f "$CONFIG_FILE" ]]; then
    echo "Error: config.json not found in src/"
    exit 1
fi

PORT=$(jq -r '.local_testing_port' "$CONFIG_FILE")

if [[ -z "$PORT" || "$PORT" == "null" ]]; then
    echo "Error: local_testing_port is not set in config.json"
    exit 1
fi

URL="http://localhost:$PORT"

echo "Serving src/ on $URL..."
php -S localhost:"$PORT" -t src/ &

# Wait a moment for the server to start
sleep 1

# Open in the default browser
if command -v xdg-open >/dev/null; then
    xdg-open "$URL"  # Linux
elif command -v open >/dev/null; then
    open "$URL"  # macOS
elif command -v start >/dev/null; then
    start "$URL"  # Windows (if run in Git Bash or WSL)
else
    echo "Could not detect the system's default browser opener."
fi
