#!/bin/sh

set -e

printf "Preparing cache:\n"

/app/bin/console cache:warmup || exit 1

printf "Run migrations:\n"

/app/bin/console do:mi:mi --no-interaction || exit 1

sh /usr/local/bin/docker-entrypoint.sh
