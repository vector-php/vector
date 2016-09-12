#! /bin/bash

echo "Runing tests in PHP7.0..."
docker run -v $PWD:/home/vector/ vector/tests-php7.0

echo "Runing tests in PHP7.1..."
docker run -v $PWD:/home/vector/ vector/tests-php7.1
