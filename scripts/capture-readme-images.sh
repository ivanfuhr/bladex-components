#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
OUT="$ROOT/docs/images"
SCRIPTS="$ROOT/scripts"
BASE_URL="${STENCIL_SCREENSHOT_URL:-http://127.0.0.1:8001}"

mkdir -p "$OUT"

if [[ -f "${SCRIPTS}/package.json" ]]; then
  if [[ ! -d "${SCRIPTS}/node_modules/playwright-core" ]]; then
    echo "Installing capture dependencies in scripts/..."
    npm install --prefix "${SCRIPTS}" --no-fund --no-audit
  fi

  export STENCIL_SCREENSHOT_URL="${BASE_URL}"
  node "${SCRIPTS}/capture-readme-images.mjs"
  echo "Saved element screenshots to docs/images/"
  exit 0
fi

echo "scripts/capture-readme-images.mjs is missing; cannot capture." >&2
exit 1
