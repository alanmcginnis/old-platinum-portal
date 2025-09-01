#!/bin/bash

# Check if mysql service is running
if ! brew services list | grep -q "mysql\s*started"; then
  echo "MySQL is not running. Starting MySQL..."
  brew services start mysql
  # wait until mysql responds
  until mysqladmin ping &>/dev/null; do
    sleep 1
  done
  echo "MySQL started."
else
  echo "MySQL is already running."
fi

# Set your PHP app directory here
APP_DIR="./"

# Find a free port above 1024
PORT=5000
while lsof -i :$PORT >/dev/null 2>&1; do
  PORT=$((PORT+1))
done

echo "Serving PHP application at http://localhost:$PORT"
php -S localhost:$PORT -t "$APP_DIR"
