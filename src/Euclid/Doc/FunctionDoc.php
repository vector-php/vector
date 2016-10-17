<?php

namespace Vector\Euclid\Doc;

use Reflector;
use Vector\Lib\ArrayList;
use Vector\Data\{
    Maybe,
    Either
};

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
        return $this->firstTagOr('No examples given for this function.', 'example');
    }

    public function examples()
    {
        if (!isset($this->tags['example']))
            return Either::left('No examples given for this function.');

        return count($this->tags['example'])
            ? Either::right($this->tags['example'])
            : Either::left('No examples given for this function.');
    }

    public function type()
    {
        return $this->firstTagOr('No type given for this function.', 'type');
    }

    public function returnType()
    {
        return $this->firstTagOr('No return type given for this function.', 'return');
    }

    public function githubSource()
    {
        $parentClass = $this->reflector->getDeclaringClass();

        $github = 'https://github.com/joseph-walker/vector/blob/master/src';
        $filePath = str_replace('\\', '/', $parentClass->getNamespaceName());
        $fileName = $parentClass->getShortName();

        return $github . '/' . $filePath . '/' . $fileName . '.php#L' . ($this->reflector->getStartLine() + 1);
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

    private function firstTagOr($errorMessage, $name)
    {
        try {
            if (!isset($this->tags[$name]))
                throw new \Exception('Tag not found.');

            return Either::right(ArrayList::head($this->tags[$name]));
        } catch (\Exception $e) {
            return Either::left($errorMessage);
        }
    }
}
