#!/bin/sh

set -e

stat() {
  printf "[ %s ] %s\n" "$2" "$1"
}

mkdir -p /app/resource >/dev/null && stat "Resource directory created" "OK" || stat "Failed to create resource directory" "FAIL"
touch /app/resource/events.log >/dev/null && stat "Events.log created" "OK" || stat "Failed to create events.log" "FAIL"
chmod 0760 -R /app/resource >/dev/null && stat "Fix resource directory chown" "OK" || stat "Failed to change resource directory permissions" "FAIL"

mkdir -p /app/var >/dev/null && stat "Var directory created" "OK" || stat "Failed to create var directory" "FAIL"
chmod 0777 -R /app/var >/dev/null && stat "Fix var directory chown" "OK" || stat "Failed to change var directory permissions" "FAIL"

chown www-data:www-data -R /app >/dev/null && stat "Fix application directory permission" "OK" || stat "Failed to fix application directory permissions" "FAIL"

/app/bin/console cache:warmup >/dev/null && stat "Warmup cache" "OK" || stat "Failed to warmup cache" "FAIL"
/app/bin/console do:mi:mi --no-interaction >/dev/null && stat "Run migrations" "OK" || stat "Failed to run migrations" "FAIL"

printf "\n\nStarting PHP-FPM daemon\n\n"
php-fpm --daemonize