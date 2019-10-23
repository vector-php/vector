#! /bin/bash

echo "Running tests in PHP7.4..."
docker run -v $PWD:/home/vector/ vector/tests-php7.4

echo "Running tests in PHP-Nightly..."
docker run -v $PWD:/home/vector/ vector/tests-php-nightly
