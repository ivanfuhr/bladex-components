#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
OUT="$ROOT/docs/images"
BASE_URL="${STENCIL_SCREENSHOT_URL:-http://127.0.0.1:8001}"
VIEWPORT_WIDTH="${STENCIL_SCREENSHOT_WIDTH:-1440}"
VIEWPORT_HEIGHT="${STENCIL_SCREENSHOT_HEIGHT:-720}"

mkdir -p "$OUT"

chromium_bin() {
  if command -v chromium >/dev/null 2>&1; then
    command -v chromium
    return
  fi

  if command -v chromium-browser >/dev/null 2>&1; then
    command -v chromium-browser
    return
  fi

  if command -v google-chrome >/dev/null 2>&1; then
    command -v google-chrome
    return
  fi

  return 1
}

capture_playwright() {
  local url="$1"
  local file="$2"

  npx --yes playwright@1.52.0 screenshot \
    --viewport-size="${VIEWPORT_WIDTH},${VIEWPORT_HEIGHT}" \
    --wait-for-selector="#readme-media" \
    --wait-for-timeout=1200 \
    "$url" \
    "$file"
}

capture_chromium() {
  local url="$1"
  local file="$2"
  local browser

  browser="$(chromium_bin)" || return 1

  "$browser" \
    --headless \
    --disable-gpu \
    --hide-scrollbars \
    --window-size="${VIEWPORT_WIDTH},${VIEWPORT_HEIGHT}" \
    --screenshot="$file" \
    "$url" \
    >/dev/null 2>&1
}

capture() {
  local url="$1"
  local file="$2"

  if capture_chromium "$url" "$file"; then
    return
  fi

  if command -v npx >/dev/null 2>&1; then
    capture_playwright "$url" "$file"
    return
  fi

  echo "Install Chromium or npx (Playwright) to capture screenshots." >&2
  exit 1
}

echo "Capturing from ${BASE_URL} (viewport ${VIEWPORT_WIDTH}×${VIEWPORT_HEIGHT})..."

for component in buttons input select typography icons; do
  capture "${BASE_URL}/playbook/media/${component}" "${OUT}/${component}-light.png"
  capture "${BASE_URL}/playbook/media/${component}?dark=1" "${OUT}/${component}-dark.png"
done

echo "Saved screenshots to docs/images/"
