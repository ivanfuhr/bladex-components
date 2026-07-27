#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
OUT="$ROOT/docs/images"
BASE_URL="${BLADEX_SCREENSHOT_URL:-http://127.0.0.1:8001}"
VIEWPORT_WIDTH="${BLADEX_SCREENSHOT_WIDTH:-1440}"

mkdir -p "$OUT"

if ! command -v npx >/dev/null 2>&1; then
  echo "npx is required to capture screenshots." >&2
  exit 1
fi

capture() {
  local url="$1"
  local file="$2"

  npx --yes playwright@1.52.0 screenshot \
    --viewport-size="${VIEWPORT_WIDTH},900" \
    --wait-for-timeout=1500 \
    --full-page \
    "$url" \
    "$file"
}

echo "Capturing from ${BASE_URL} (viewport ${VIEWPORT_WIDTH}px)..."

for component in buttons input select typography icons; do
  capture "${BASE_URL}/playbook/media/${component}" "${OUT}/${component}-light.png"
  capture "${BASE_URL}/playbook/media/${component}?dark=1" "${OUT}/${component}-dark.png"
done

echo "Saved screenshots to docs/images/"
