<?php

use Vector\Control\Pattern;
use Vector\Data\Result\Err;
use Vector\Data\Result\Ok;
use Vector\Data\Result\Result;

require __DIR__ . '/vendor/autoload.php';

class QueryException extends Exception {};
class DBException extends Exception {};

class User {
    private $attrs;

    public function __get($name)
    {
        return $this->attrs[$name];
    }

    public function __construct($attrs)
    {
        $this->attrs = $attrs;
    }

    public static function findOrFail($id) {
        if ($id === 1) {
            return new User(['name' => 'logan']);
        }

        if ($id === 3) {
            throw new DBException('DB error');
        }

        throw new QueryException('Not Found');
    }
}

//function throws(callable $callable) {
//    try {
//        return Result::ok($callable());
//    } catch (Exception $e) {
//        return Result::err($e);
//    }
//}

$handler = Pattern::match([
    fn(Ok $value) => fn(User $user) => $user->name,
    fn(Err $err) => Pattern::match([
        fn(QueryException $exception) => 'QueryException: ' . $exception->getMessage(),
        fn(DBException $exception) => 'DBException: ' . $exception->getMessage(),
    ])
]);

echo $handler(Result::attempt(fn() => User::findOrFail(1))) . PHP_EOL;
echo $handler(Result::attempt(fn() => User::findOrFail(2))) . PHP_EOL;
echo $handler(Result::attempt(fn() => User::findOrFail(3))) . PHP_EOL;

// Output:
// logan
// QueryException: Not Found
// DBException: DB error


// The above would be a replaement control flow for the try/catch methods e.g.
try {
    echo User::findOrFail(1)->name;
} catch (QueryException $exception) {
    echo 'QueryException: ' . $exception->getMessage();
} catch (DBException $exception) {
    echo 'DBException: ' . $exception->getMessage();
}
