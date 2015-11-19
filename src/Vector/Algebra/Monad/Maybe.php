<?php

namespace Vector\Algebra\Monad;

use Vector\Algebra\Typeclass\Monad;

class Maybe implements Monad
{
    private $isJust = true;
    private $heldValue;
    
    private function __construct($value, $isJust)
    {
        $this->heldValue = $value;
        $this->isJust    = $isJust;
    }
    
    /*
     * Constructor Methods (Static)
     \ --- */
     
    // Just :: a -> Just a
    public static function Just($a)
    {
        return new Maybe($a, true);
    }
    
    // Nothing :: Nothing
    public static function Nothing()
    {
        return new Maybe(null, false);
    }
    
    /*
     * Functor Instance
     \ --- */

    // fmap :: Maybe f => (a -> b) -> f a -> f b
    public function fmap(Callable $f)
    {
        if ($this->isJust) {
            return self::Just($f($this->heldValue));
        }
        
        return $this;
    }
    
    /*
     * Applicative Instance
     \ --- */
     
    // pure :: Maybe f => a -> f a
    public function pure($a)
    {
        return self::Just($a);
    }
    
    // apply :: Maybe f => f (a -> b) -> f a -> f b
    public function apply($a)
    {
        if ($this->isJust) {
            // Applicative a => apply (Maybe f) (a) === fmap f a
            return $a->fmap($this->heldValue);
        }
        
        return $this;
    }
     
    /*
     * Monad Instances
     \ --- */
     
    // bind :: Maybe m => (a -> m b) -> m a -> m b
    public function bind(Callable $f)
    {
        if ($this->isJust) {
            return $f($this->heldValue);
        }
        
        return $this;
    }
}
