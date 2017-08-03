#! /bin/bash

echo "Building documentation..."
php ./bin/vector.php docs:generate \
    Vector\\Lib\\Arrays \
    Vector\\Lib\\Lambda \
    Vector\\Lib\\Logic \
    Vector\\Lib\\Math \
    Vector\\Lib\\Objects \
    Vector\\Lib\\Strings \
    Vector\\Control\\Applicative \
    Vector\\Control\\Functor \
    Vector\\Control\\Lens \
    Vector\\Control\\Monad
