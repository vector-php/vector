<?php

require __DIR__ . '/vendor/autoload.php';

class Benchmarker
{
    private $iterations;

    public function __construct($iterations)
    {
        $this->iterations = $iterations;
    }

    public function test($module, $function, ...$args)
    {
        $functionToTest = $module::using($function);

        $duration = 0;
        for ($i = 0; $i < $this->iterations; $i++) {
            $time = -microtime(true);
            call_user_func_array($functionToTest, $args);

            $duration += $time + microtime(true);
        }

        return $duration;
    }

    public function testRaw($rawExpression)
    {
        $duration = 0;
        $time = null;

        $start = function() use (&$time) {
            $time = - microtime(true);
        };

        $end = function() use (&$time) {
            return $time + microtime(true);
        };

        for ($i = 0; $i < $this->iterations; $i++) {
            $duration += call_user_func_array($rawExpression, [$start, $end]);
        }

        return $duration;
    }
}

$bench = new Benchmarker(1000);

$timeA = $bench->test('Vector\Control\Functor', 'fmap', function($a) { return $a + 1; }, [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

$timeB = $bench->testRaw(function($start, $end) {
    $start();

    $_ = array_map(function($a) { return $a + 1; }, [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

    return $end();
});

print_r($timeA); echo PHP_EOL;
print_r($timeB);
