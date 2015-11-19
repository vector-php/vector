<?php

namespace Vector\Algebra\Monad;

use Vector\Algebra\Typeclass\Monad;

class Either implements Monad
{
    private $isRight = true;
    private $heldValue;
    
    private function __construct($value, $isRight) {
        $this->heldValue = $value;
        $this->isRight   = $isRight;
    }
    
    /*
     * Constructor Methods (Static)
     * Magic constructor is held private to force passing through Left() or Right()
     * with Either::Left('val') or Either::Right('val')
     \ --- */
    public static function Left($value) {
        return new Either($value, false);
    }
    
    public static function Right($value) {
        return new Either($value, true);
    }
    
    /*
     * Functor Instances
     \ --- */
    public function fmap(Callable $f)
    {
        if ($this->isRight) {
            return self::Right($f($this->heldValue));
        }
        
        return $this;
    }
    
    /*
     * Monad Instances
     \ --- */
    public function pure($a)
    {
        return self::Right($a);
    }
    
    public function bind(Callable $f)
    {
        // TODO: We can do some type checking here to make sure the Monad returned
        // by $f is of type Either
        if ($this->isRight) {
            return $f($this->heldValue);
        }
        
        return $this;
    }
}
