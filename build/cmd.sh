#!/bin/sh

set -e

stat(){
    local message="$1"
    local status="$2"
    local columns=$((COLUMNS-8))
    printf "%-*s [%s] \n" "$columns" "$message" "$status"
}

rm mkdir -p /app/resource && stat "Resource directory created" " OK " || stat "Failed to create resource directory" " ERROR "
touch /app/resource/events.log && stat "Events.log created" " OK " || stat "Failed to create events.log" " ERROR "
chmod 0760 -R /app/resource && stat "Fix resource directory chown" " OK " || stat "Failed to change resource directory permissions" " ERROR "

rm mkdir -p /app/var && stat "Var directory created" " OK " || stat "Failed to create var directory" " ERROR "
chmod 0777 -R /app/var && stat "Fix var directory chown" " OK " || stat "Failed to change var directory permissions" " ERROR "

chown www-data:www-data -R /app && stat "Fix application directory permission" " OK " || stat "Failed to fix application directory permissions" " ERROR "

/app/bin/console cache:warmup && stat "Warmup cache" " OK " || stat "Failed to warmup cache" " ERROR "
/app/bin/console do:mi:mi --no-interaction && stat "Run migrations" " OK " || stat "Failed to run migrations" " ERROR "

sh /usr/local/bin/docker-entrypoint.sh
