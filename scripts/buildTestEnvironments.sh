#! /bin/bash

echo "Building testing environment for PHP8.0..."
docker build -t vector/tests-php8.0 ./environments/php8.0/
