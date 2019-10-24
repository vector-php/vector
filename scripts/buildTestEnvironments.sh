#! /bin/bash

echo "Building testing environment for PHP7.4..."
docker build -t vector/tests-php7.4 ./environments/php7.4/
