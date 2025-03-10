#!/bin/bash

CONFIG_FILE="project/config.json"

if [[ ! -f "$CONFIG_FILE" ]]; then
    echo "Error: config.json not found in project/"
    exit 1
fi

PORT=$(jq -r '.local_testing_port' "$CONFIG_FILE")

if [[ -z "$PORT" || "$PORT" == "null" ]]; then
    echo "Error: local_testing_port is not set in config.json"
    exit 1
fi

URL="http://localhost:$PORT"

# Check if a process is already using the port and kill it
EXISTING_PID=$(lsof -ti :"$PORT")

if [[ -n "$EXISTING_PID" ]]; then
    echo "Closing existing PHP server on port $PORT..."
    kill "$EXISTING_PID"
    sleep 1  # Allow time for the process to terminate
fi

echo "Serving project/ on $URL..."
php -S localhost:"$PORT" -t project/ &

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
