#! /bin/bash
echo "Running tests in PHP5.6..."
docker run -v $PWD:/home/vector/ vector/tests-php5.6

echo "Runing tests in PHP7.0..."
docker run -v $PWD:/home/vector/ vector/tests-php7.0
