#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"

mkdir -p "$ROOT_DIR/public/admin"
rm -rf "$ROOT_DIR/public/admin"/*
cp -R "$ROOT_DIR/resources/admin/." "$ROOT_DIR/public/admin/"

echo "Admin assets synced from resources/admin to public/admin"
