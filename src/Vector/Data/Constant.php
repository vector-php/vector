<?php

namespace Vector\Data;

use Vector\Typeclass\MonadInterface;

/**
 * Class Constant
 * @package Vector\Data
 */
class Constant implements MonadInterface
{
    private $heldValue;

    /**
     * Constant constructor.
     * @param $value
     */
    private function __construct($value)
    {
        $this->heldValue = $value;
    }

    /**
     * @param $a
     * @return Constant
     */
    public static function constant($a)
    {
        return new Constant($a);
    }

    /**
     * @param callable $f
     * @return $this
     */
    public function fmap(Callable $f)
    {
        return $this;
    }

    /**
     * @return mixed
     */
    public function extract()
    {
        return $this->heldValue;
    }

    /**
     * @param $a
     * @return Constant
     */
    public static function pure($a)
    {
        return self::constant($a);
    }

    /**
     * @param $a
     * @return $this
     */
    public function apply($a)
    {
        return $this;
    }

    /**
     * @param callable $f
     * @return $this
     */
    public function bind(callable $f)
    {
        return $this;
    }
}
