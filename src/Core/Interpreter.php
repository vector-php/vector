<?php

namespace Vector\Core;

use Nette\Utils\Tokenizer;

class Interpreter
{
    private $tokenQueue;
    private $moduleDictionary;
    private $tokens = [
        'V_INTEGER'     => '\d+',
        'V_OPEN_PAREN'  => '\(',
        'V_CLOSE_PAREN' => '\)',
        'V_COMPOSE'     => ' \. ',
        'V_WHITESPACE'  => '\s+',
        'V_FUNCTION'    => '\w+'
    ];

    public function __construct()
    {
    }

    public function using($module)
    {
        $this->moduleDictionary[] = $module;

        return $this;
    }

    public function expand($expression)
    {
        $this->tokenQueue = array_reduce($this->tokenize($expression), function($carry, $token) {
            $carry->enqueue($token); return $carry;
        }, new \SplQueue());

        return $this->evaluateStackFrame();
    }

    public function evaluateStackFrame()
    {
        $executionState = \Vector\Lib\Lambda::using('id');
        $compose = \Vector\Lib\Lambda::using('compose');

        while (!$this->tokenQueue->isEmpty()) {
            $operator = $this->tokenQueue->dequeue();

            switch ($operator[Tokenizer::TYPE]) {
                case 'V_COMPOSE':
                    $operation = $this->evaluateStackFrame();
                    return $compose($executionState, $operation);
                    break;
                case 'V_FUNCTION':
                    $operation = $this->lookup($operator[Tokenizer::VALUE]);
                    break;
                case 'V_INTEGER':
                    $operation = $operator[Tokenizer::VALUE];
                    break;
                case 'V_OPEN_PAREN':
                    $operation = $this->evaluateStackFrame();
                    break;
                case 'V_CLOSE_PAREN';
                    return $executionState;
                    break;
            }

            $executionState = $executionState($operation);
        }

        return $executionState;
    }

    private function tokenize($expression)
    {
        $tokenizer = new Tokenizer($this->tokens);

        return array_filter($tokenizer->tokenize($expression), function($t) {
            return $t[Tokenizer::TYPE] !== 'V_WHITESPACE';
        });
    }

    private function lookup($functionName)
    {
        foreach ($this->moduleDictionary as $module) {
            $reflector = new \ReflectionClass($module);

            if ($reflector->hasMethod($functionName))
                return $module::using($functionName);
        }

        throw new \Exception($functionName . ' was not found in the supplied interpreter modules.');
    }
}

/*
EXAMPLE 1
=========

GIVEN
add 1 2

BECOMES:

QUEUE:
add
1
2

EXECUTE:
ITERATION 1 =>
    QUEUE:
    1
    2

    EXECUTION:
    id(add) => add

ITERATION 2 =>
    QUEUE:
    2

    EXECUTION:
    add(1) => add(1)

ITERATION 3:
    QUEUE:
    null

    EXECUTION:
    add(1)(2) => 3

EXAMPLE 2
=========

GIVEN
add 1 (add 2 3)

BECOMES:

QUEUE:
add
1
(
add
2
3
)

EXECUTE:
ITERATION 1 =>
    QUEUE:
    1
    (
    add
    2
    3
    )

    EXECUTION:
    id(add) => add

ITERATION 2 =>
    QUEUE:
    (
    add
    2
    3
    )

    EXECUTION:
    add(1) => add(1)

ITERATION 3 =>
    QUEUE:
    add
    2
    3
    )

    EXECUTION:
    add(1)(newStackFrame(QUEUE)) => ...

    SUB-ITERATION 1:
        QUEUE:
        2
        3
        )

        EXECUTION:
        id(add) => add


    SUB-ITERATION 2:
        QUEUE:
        3
        )

        EXECUTION:
        add(2) => add(2)

    SUB-ITERATION 3:
        QUEUE:
        )

        EXECUTION:
        add(2)(3) => 5

    SUB-ITERATION 3:
        QUEUE:
        null

        EXECUTION:
        5

    RETURN 5

    ... => add(1)(5) => 6

EXAMPLE 3
=========

GIVEN
add 1 . add 2

BECOMES
QUEUE:
add
1
.
add
2

EXECUTE:
ITERATION 1 =>
    QUEUE:
    1
    .
    add
    2

    EXECUTION:
    id(add) => add

ITERATION 2 =>
    QUEUE:
    .
    add
    2

    EXECUTION:
    add(1) => add(1)

ITERATION 3 =>
    QUEUE:
    add
    2

    EXECUTION:
    compose(add(1), newStackFrame(QUEUE)) => ...

    SUB-ITERATION 1 =>
        QUEUE:
        2

        EXECUTION:
        id(add) => add

    SUB-ITERATION 2 =>
        QUEUE:
        null

        EXECUTION:
        add(2) => add(2)

    RETURN add(2)

    ... => compose(add(1), add(2))
*/
