#!/usr/bin/env bash

set -e

git clone https://github.com/nginx/unit && \
cd unit  && \
git checkout 1.29.0 && \
cd pkg/docker && \
make build-php82 VERSION_php=8.2.3 && \
cd ../../../ && \
rm -rf unit
