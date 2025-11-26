#!/bin/bash

# Base local directory
BASE_LOCAL="/var/www/html/longhairrecords/wp-content/uploads"
# Base R2 bucket path
BASE_R2="r2:lhrecords-media"
# Log file
LOG_FILE="/var/log/rclone_upload.log"

# File patterns to include
PATTERNS=(
  "*-100x100.jpeg"
  "*-150x150.jpeg"
  "*-300x300.jpeg"
  "*-450x600.jpeg"
  "*-600x600.jpeg"
)

# Loop through all subdirectories inside uploads
find "$BASE_LOCAL" -type d | while read -r DIR; do
  # Compute relative path from wp-content
  REL_DIR="${DIR#*/wp-content/}"
  DEST_DIR="$BASE_R2/wp-content/$REL_DIR"

  # Loop through all patterns
  for pattern in "${PATTERNS[@]}"; do
    # Copy matching files in this directory to R2
    rclone copy "$DIR" "$DEST_DIR" --include "$pattern" --log-file "$LOG_FILE" --log-level INFO
  done
done

