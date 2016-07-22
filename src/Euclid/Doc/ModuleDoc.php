<?php

namespace Vector\Euclid\Doc;

use ReflectionClass;

use Vector\Lib\Lambda;
use Vector\Lib\Logic;
use Vector\Lib\ArrayList;
use Vector\Lib\Object;

use phpDocumentor\Reflection\DocBlockFactory;

class ModuleDoc
{
    private $module;
    private $functionDocs;

    public function __construct(DocBlockFactory $docBlockParser, $module)
    {
        $makeFunctionDoc = function($function) use ($docBlockParser) {
            return FunctionDocFactory::createFunctionDoc($docBlockParser, $function);
        };

        $this->module = new ReflectionClass($module);
        $this->functionDocs = ArrayList::map($makeFunctionDoc, $this->getFunctions());
    }

    public function getFunctionDocs()
    {
        return $this->functionDocs;
    }

    private function getFunctions()
    {
        $filterModule = ArrayList::filter(
            Lambda::compose(Logic::eq($this->module->name), Object::getProp('class'))
        );

        return $filterModule($this->module->getMethods());
    }
}
