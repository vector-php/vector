#! /bin/bash

echo "Building testing environment for PHP7.0..."
docker build -t vector/tests-php7.0 ./environments/php7.0/

echo "Building testing environment for PHP7.1..."
docker build -t vector/tests-php7.1 ./environments/php7.1/

echo "Building testing environment for PHP7.1..."
docker build -t vector/tests-php-nightly ./environments/nightly/
