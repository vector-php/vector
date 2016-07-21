#! /bin/bash
echo "Building testing environment for PHP5.6..."
docker build -t vector/tests-php5.6 ./testing/php5.6/

echo "Building testing environment for PHP7.0..."
docker build -t vector/tests-php7.0 ./testing/php7.0/
