<?php

namespace Vector\Euclid\Doc;

use Reflector;
use Vector\Lib\ArrayList;

class FunctionDoc
{
    private $reflector;
    private $docBlock;
    private $tags;

    public function __construct($docBlock, Reflector $reflector)
    {
        $this->reflector = $reflector;
        $this->docBlock = $docBlock;
        $this->collectTags();
    }

    public function properName()
    {
        return substr($this->reflector->name, 2);
    }

    public function name()
    {
        return $this
            ->docBlock
            ->getSummary();
    }

    public function description()
    {
        return $this
            ->docBlock
            ->getDescription()
            ->render();
    }

    public function firstExample()
    {
        return $this->firstTag('example');
    }

    public function examples()
    {
        return $this->tags['example'];
    }

    public function type()
    {
        return $this->firstTag('type');
    }

    public function returnType()
    {
        return $this->firstTag('return');
    }

    public function params()
    {
        return $this->tags['param'];
    }

    private function collectTags()
    {
        $tagName = function($tag) {
            return $tag->getName();
        };

        $this->tags = ArrayList::groupBy($tagName, $this->docBlock->getTags());
    }

    private function firstTag($name)
    {
        return ArrayList::head($this->tags[$name]);
    }
}
