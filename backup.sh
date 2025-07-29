#!/bin/bash

# Destination directory
DEST="/home/ubuntu/pdoucet_saves"
DATE=$(date +"%Y-%m-%d_%H-%M-%S")
ARCHIVE="$DEST/backup_$DATE.tar.gz"

# Create destination directory if it doesn't exist
mkdir -p "$DEST"

# Check if files to back up exist
if [ ! -d "./public/files" ]; then
  echo "Error: Directory ./public/files does not exist."
  exit 1
fi

if [ ! -f "./var/data.db" ]; then
  echo "Error: File ./var/data.db does not exist."
  exit 1
fi

# Create the archive
tar -czf "$ARCHIVE" ./public/files/* ./var/data.db

# Check result
if [ $? -eq 0 ]; then
  echo "Backup successful: $ARCHIVE"
else
  echo "Backup failed."
fi