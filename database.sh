#!/bin/bash
if [ ! -f "/var/www/storage/unreal-asset-store.db" ]; then
    echo "database not found, creating"
    sqlite3 "/var/www/storage/unreal-asset-store.db" ""
    echo "seeding database"
    php "/var/www/html/seed.php"
    echo "successfully seeded database"
else
    echo "database found"
fi