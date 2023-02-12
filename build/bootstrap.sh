#!/usr/bin/env bash

# Clear cache

/app/bin cache:warmup
chown www-data:www-data -R /app/var
chmod 777 -R /app/var

# Start nginx unit

unitd --no-daemon --control unix:/var/run/control.unit.sock
