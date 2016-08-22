<?php

namespace Vector\Data;

use Vector\Core\Module;

class Maybe extends Module
{
    private $isJust;
    private $heldValue;

    public static function patternMatch()
    {
        return [
            'just' => [
                // Matches if this maybe `isJust`
                'pattern' => function() {
                    return $this->isJust == true;
                },
                // Returns the held value to the given pattern match function
                'result' => function() {
                    return $this->heldValue;
                }
            ],
            'nothing' => [
                // Matches if this maybe `isNothing`
                'pattern' => function() {
                    return $this->isJust == false;
                },
                // Returns nothing to the given pattern match function
                'result' => function() {
                    return null;
                }
            ]
        ];
    }

    private function __construct($isJust, $value)
    {
        $this->isJust = $isJust;
        $this->heldValue = $value;
    }

    public static function just($a)
    {
        return new Maybe(true, $a);
    }

    public static function nothing()
    {
        return new Maybe(false, null);
    }

    protected static function __withDefault($default, Maybe $maybeValue)
    {
        $pattern = Structures::patternMatch(Maybe::class)
            ->just(function($value) {
                return $value;
            })
            ->nothing(function() use ($default) {
                return $default;
            });

        return $pattern($maybeValue);
    }
}
