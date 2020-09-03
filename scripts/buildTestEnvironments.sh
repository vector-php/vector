#! /bin/bash

echo "Building testing environment for PHP7.4..."
docker build -t vector/tests-php7.4 ./environments/php7.4/
echo "Building testing environment for PHP8.0..."
docker build -t vector/tests-php8.0 ./environments/php8.0/
