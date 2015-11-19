<?php

$maybeAdd = Maybe::Just(function($a) {
    return $a + 1;
});

$maybeOne = Maybe::Just(1);

$maybeTwo = apply($maybeAdd, $maybeOne);

function apply(Applicative $f, Applicative $a)
{
    return $f->apply($a);
}
