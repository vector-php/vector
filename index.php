<?php

require __DIR__ . '/vendor/autoload.php';

$test = new Vector\Core\Interpreter('add 1 (add 2 3)');

print_r($test->evaluateStackFrame());

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
