#!/usr/bin/env sh
set -eu

BASE_URL="${1:-http://localhost:8080}"

echo "Checking ${BASE_URL}/health"
response="$(curl --fail --silent "${BASE_URL}/health")"

echo "$response" | grep '"status": "ok"' >/dev/null
echo "Smoke test passed"
