<?php

namespace Vector\Euclid\Doc;

use Reflector;
use InvalidArgumentException;

use phpDocumentor\Reflection\DocBlockFactory;

abstract class FunctionDocFactory
{
    public static function createFunctionDoc(DocBlockFactory $docBlockParser, Reflector $reflector)
    {
        try {
            $parsedDocBlock = $docBlockParser->create($reflector);

            return new FunctionDoc($parsedDocBlock, $reflector);
        } catch (InvalidArgumentException $e) {
            return new FunctionDocEmpty($reflector);
        }
    }
}
