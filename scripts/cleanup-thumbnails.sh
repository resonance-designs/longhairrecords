#!/bin/bash
# cleanup-thumbnails.sh
# Deletes unwanted WooCommerce/WordPress thumbnail sizes

UPLOADS_DIR="/var/www/html/longhairrecords/wp-content/uploads"

# Array of unwanted size patterns
SIZES=(
  "1024x1024"
  "1080x1080"
  "1080x675"
  "1280x1280"
  "1536x1536"
  "1920x1800"
  "400x250"
  "400x284"
  "400x516"
  "480x480"
  "510x382"
  "768x768"
  "980x980"
)

# Loop through each size pattern and delete matching files
for size in "${SIZES[@]}"; do
  find "$UPLOADS_DIR" -type f -name "*$size*" -print -delete
done

# Optional: log action
echo "$(date '+%Y-%m-%d %H:%M:%S') - Cleanup completed." >> /var/log/cleanup-thumbnails.log
