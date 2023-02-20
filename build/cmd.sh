#!/bin/sh

set -e

printf "Create directories:\n"

mkdir -p /app/resource
mkdir -p /app/var
chmod 0777 -R /app/var
chmod 0760 -R /app/resource
chown www-data:www-data -R /app

printf "Preparing cache:\n"

/app/bin/console cache:warmup

printf "Run migrations:\n"

/app/bin/console do:mi:mi --no-interaction

sh /usr/local/bin/docker-entrypoint.sh
