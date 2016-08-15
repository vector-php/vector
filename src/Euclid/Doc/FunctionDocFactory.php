<?php

namespace Vector\Euclid\Doc;

use Reflector;
use ReflectionClass;
use ReflectionMethod;
use InvalidArgumentException;

use phpDocumentor\Reflection\DocBlockFactory;

abstract class FunctionDocFactory
{
    public static function createFunctionDocFromReflector(Reflector $reflector)
    {
        try {
            $parsedDocBlock = self::docBlockParser()->create($reflector);

            return new FunctionDoc($parsedDocBlock, $reflector);
        } catch (InvalidArgumentException $e) {
            return new FunctionDocEmpty($reflector);
        }
    }

    public static function createFunctionDocFromName($moduleName, $functionName)
    {
        return self::createFunctionDocFromReflector(new ReflectionMethod($moduleName, '__' . $functionName));
    }

    public static function createModuleDocFromReflector(Reflector $reflector)
    {
        return new ModuleDoc($reflector);
    }

    public static function createModuleDocFromName($moduleName)
    {
        return self::createModuleDocFromReflector(new ReflectionClass($moduleName));
    }

    private static function docBlockParser()
    {
        static $docBlockParser = null;

        if ($docBlockParser === null)
            $docBlockParser = DocBlockFactory::createInstance();

        return $docBlockParser;
    }
}
