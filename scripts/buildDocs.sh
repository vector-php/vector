#! /bin/bash

php ./bin/vector.php docs:generate \
    Vector\\Lib\\ArrayList \
    Vector\\Lib\\Lambda \
    Vector\\Lib\\Logic \
    Vector\\Lib\\Math \
    Vector\\Lib\\Object \
    Vector\\Lib\\Strings \
    Vector\\Core\\Applicative \
    Vector\\Core\\Functor \
    Vector\\Core\\Lens \
    Vector\\Core\\Monad
