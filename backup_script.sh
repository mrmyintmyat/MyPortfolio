#!/bin/bash

# Define MySQL credentials
DB_USER="root"
DB_PASSWORD="MyPortfolio345#$"
DB_NAME="portfolio"

# Define backup directory
BACKUP_DIR="/var/www/html/MyPortfolio/backup_mysql"

# Create backup filename with timestamp
BACKUP_FILENAME="$BACKUP_DIR/${DB_NAME}_$(date +"%Y%m%d%H%M%S").sql"

# Perform MySQL database backup
mysqldump -u $DB_USER -p$DB_PASSWORD $DB_NAME > $BACKUP_FILENAME
