#! /bin/bash

echo "Running tests in PHP8.0..."
docker run -v $PWD:/home/vector/ vector/tests-php8.0
