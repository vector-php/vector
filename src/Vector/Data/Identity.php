<?php

namespace Vector\Data;

use Vector\Core\Module;
use Vector\Typeclass\MonadInterface;

/**
 * Class Identity
 * @package Vector\Data
 */
class Identity extends Module implements MonadInterface
{
    private $heldValue;

    /**
     * Identity constructor.
     * @param $value
     */
    private function __construct($value)
    {
        $this->heldValue = $value;
    }

    /**
     * @param $a
     * @return Identity
     */
    protected static function __identity($a)
    {
        return new Identity($a);
    }

    /**
     * @param callable $f
     * @return Identity
     */
    public function fmap(callable $f)
    {
        return self::identity($f($this->heldValue));
    }

    /**
     * @param $a
     * @return Identity
     */
    public static function pure($a)
    {
        return self::identity($a);
    }

    /**
     * Identity a => apply (Identity f) (a) === fmap f a
     * @param Identity $a
     * @return mixed
     */
    public function apply($a)
    {
        return $a->fmap($this->heldValue);
    }

    /**
     * @param callable $f
     * @return mixed
     */
    public function bind(callable $f)
    {
        return $f($this->heldValue);
    }

    /**
     * @return mixed
     */
    public function extract()
    {
        return $this->heldValue;
    }
}
