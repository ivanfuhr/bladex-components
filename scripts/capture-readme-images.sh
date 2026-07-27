#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
OUT="$ROOT/docs/images"
BASE_URL="${BLADEX_SCREENSHOT_URL:-http://127.0.0.1:8001}"

mkdir -p "$OUT"

if ! command -v npx >/dev/null 2>&1; then
  echo "npx is required to capture screenshots." >&2
  exit 1
fi

capture() {
  local url="$1"
  local file="$2"
  local width="${3:-1100}"

  npx --yes playwright@1.52.0 screenshot \
    --viewport-size="${width},800" \
    --wait-for-timeout=1500 \
    "$url" \
    "$file"
}

echo "Capturing from ${BASE_URL}..."

capture "${BASE_URL}/playbook/media/buttons" "${OUT}/button-variants-light.png" 1100
capture "${BASE_URL}/playbook/media/buttons?dark=1" "${OUT}/button-variants-dark.png" 1100
capture "${BASE_URL}/playbook/media/overview" "${OUT}/components-overview-light.png" 1100
capture "${BASE_URL}/playbook/media/overview?dark=1" "${OUT}/components-overview-dark.png" 1100

echo "Saved screenshots to docs/images/"
