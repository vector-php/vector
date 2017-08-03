<?php

namespace Vector\Typeclass;

use Vector\Control\Functor;

/**
 * Trait IsApplicative
 */
trait simpleApplicativeDefault
{
    public static function pure($a)
    {
        return new static($a);
    }

    public function apply($a)
    {
        $values = $this->extract();

        if (is_array($values)) {
            return Functor::fmap(...array_merge($this->extract(), [$a]));
        }

        return $this;
    }
}
