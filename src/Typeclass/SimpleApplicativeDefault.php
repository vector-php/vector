<?php

namespace Vector\Typeclass;

trait SimpleApplicativeDefault
{
    public static function pure($a)
    {
        return new static($a);
    }

    public function apply($a)
    {
        return $this;
    }
}
