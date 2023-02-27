#!/bin/sh

set -e

stat() {
  printf "[ %s ] %s\n" "$2" "$1"

  if [ "$1" = "Fail" ]; then
    exit 1;
  fi
}

mkdir -p /app/resource > /dev/null && stat "Resource directory created" "OK" || stat "Failed to create resource directory" "FAIL"
mkdir -p /app/var > /dev/null && stat "Var directory created" "OK" || stat "Failed to create var directory" "FAIL"

chmod 0760 -R /app/resource > /dev/null && stat "Fix resource directory chown" "OK" || stat "Failed to change resource directory permissions" "FAIL"
chmod 0777 -R /app/var > /dev/null && stat "Fix var directory chown" "OK" || stat "Failed to change var directory permissions" "FAIL"

touch /app/resource/events.log > /dev/null && stat "Events.log created" "OK" || stat "Failed to create events.log" "FAIL"

/app/bin/console cache:warmup > /dev/null && stat "Warmup cache" "OK" || stat "Failed to warmup cache" "FAIL"
/app/bin/console do:mi:mi --no-interaction > /dev/null && stat "Run migrations" "OK" || stat "Failed to run migrations" "FAIL"

printf "Starting PHP-FPM daemon\n"
php-fpm --daemonize
