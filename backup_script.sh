#!/bin/bash

# MySQL credentials
DB_USER="root"
DB_PASSWORD="MyPortfolio345#$"

# Backup directory on the server
BACKUP_DIR="/var/www/html/MyPortfolio/backup_mysql"
# Create backup directory if it doesn't exist
if [ ! -d "$BACKUP_DIR" ]; then
    mkdir -p "$BACKUP_DIR"
fi

# Backup filename
BACKUP_FILENAME="backup_$(date +%Y%m%d%H%M%S).sql"

# mysqldump command for all databases
mysqldump -u $DB_USER -p$DB_PASSWORD --all-databases > "$BACKUP_DIR/$BACKUP_FILENAME"

# Optional: Compress the backup file
# gzip "$BACKUP_DIR/$BACKUP_FILENAME"

# Number of days to retain backups
NUM_RETAIN=7

# Remove older backup files
find "$BACKUP_DIR" -type f -name "backup_*.sql" -mtime +$NUM_RETAIN -exec rm {} \;
