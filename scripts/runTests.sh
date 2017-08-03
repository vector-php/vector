#! /bin/bash

echo "Runing tests in PHP7.1..."
docker run -v $PWD:/home/vector/ vector/tests-php7.1

echo "Runing tests in PHP-Nightly..."
docker run -v $PWD:/home/vector/ vector/tests-php-nightly
