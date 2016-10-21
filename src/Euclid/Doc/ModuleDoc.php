<?php

namespace Vector\Euclid\Doc;

use Reflector;

use Vector\Lib\Lambda;
use Vector\Lib\Logic;
use Vector\Lib\Arrays;
use Vector\Lib\Object;

use phpDocumentor\Reflection\DocBlockFactory;

class ModuleDoc
{
    private $module;
    private $functionDocs;

    public function __construct(Reflector $module)
    {
        $makeFunctionDoc = function($function) {
            return FunctionDocFactory::createFunctionDocFromReflector($function);
        };

        $this->module = $module;
        $this->functionDocs = Arrays::map($makeFunctionDoc, $this->getFunctions());
    }

    public function getFunctionDocs()
    {
        return $this->functionDocs;
    }

    private function getFunctions()
    {
        $filterModule = Arrays::filter(
            Lambda::compose(Logic::eq($this->module->name), Object::getProp('class'))
        );

        return $filterModule($this->module->getMethods());
    }
}
