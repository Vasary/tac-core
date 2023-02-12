#!/usr/bin/env bash

# Clear cache

/app/bin cache:warmup

# Start nginx unit

unitd --no-daemon --control unix:/var/run/control.unit.sock
