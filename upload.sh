#!/bin/bash

# Load environment variables
if [ -f .env ]; then
    export $(grep -v '^#' .env | xargs)
else
    echo "⚠️  WARNING: .env file not found!"
    exit 1
fi

# Upload files from src/ to server
rsync -avz --progress "src/" "${SERVER_USER}@${SERVER_HOST}:${SERVER_PATH}"
