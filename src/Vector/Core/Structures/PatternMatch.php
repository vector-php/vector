<?php

namespace Vector\Core\Structures;

class PatternMatch
{
    private $patterns = [];
    private $options = [];

    public function __construct($patternClass)
    {
        $this->patterns = $patternClass::patternMatch();
    }

    public function __call($methodName, $args)
    {
        $this->options[] = [
            'option' => $this->patterns[$methodName],
            'lambda' => $args[0]
        ];

        return $this;
    }

    public function __invoke($arg)
    {
        foreach ($this->options as $match) {
            if ($match['option']['pattern']->call($arg))
                return $match['lambda']($match['option']['result']->call($arg));
        }
    }
}
