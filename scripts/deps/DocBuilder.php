<?php

use phpDocumentor\Reflection\DocBlock;

use Vector\Control\Functor;
use Vector\Lib\ArrayList;
use Vector\Lib\Strings;
use Vector\Lib\Lambda;
use Vector\Lib\Object;

class DocBuilder
{
    private $loader;
    private $docsDir;

    public function __construct($loader, $docsDir)
    {
        $this->loader  = $loader;
        $this->docsDir = $docsDir;
    }

    public function getVectorClasses($module)
    {
        // Dependencies
        list($filter, $keys, $values) = ArrayList::using('filter', 'keys', 'values');
        $startsWith                   = Strings::using('startsWith');

        return $values(
            $filter(
                $startsWith('Vector\\' . $module),
                $keys($this->loader->getClassmap())
            )
        );
    }

    public function getModuleGroup($fullNamespace)
    {
        // Dependencies
        list($init, $last) = ArrayList::using('init', 'last');
        $split             = Strings::using('split');
        $compose           = Lambda::using('compose');

        return $last($init($split('\\', $fullNamespace)));
    }

    public function getClassName($fullNamespace)
    {
        // Dependencies
        $split   = Strings::using('split');
        $last    = ArrayList::using('last');
        $compose = Lambda::using('compose');

        return $last($split('\\', $fullNamespace));
    }

    public function filterTags($type)
    {
        $filter    = ArrayList::using('filter');
        $tagFilter = $filter(function($tag) use ($type) { return $tag->getName() == $type; });

        return $tagFilter;
    }

    public function generateTypeSignature($docBlock)
    {
        $typeTag = $this->filterTags('type');
        $type = $typeTag($docBlock->getTags());

        return count($type)
            ? $type[0]->getContent()
            : 'No Type Signature Provided';
    }

    public function makeArgTable($docBlock)
    {
        $head = ArrayList::using('head');
        $tags = $docBlock->getTags();

        $paramTag  = $this->filterTags('param');
        $returnTag = $this->filterTags('return');

        $params = $paramTag($tags);
        $return = $returnTag($tags);

        $buffer = false;

        if (count($params) || count($return)) {
            $buffer  = 'Parameter | Type | Description' . PHP_EOL;
            $buffer .= '-|-|-' . PHP_EOL;
        }

        if (count($params)) {
            foreach ($params as $param) {
                $buffer .= $param->getVariableName();
                $buffer .= ' | ';
                $buffer .= $param->getType();
                $buffer .= ' | ';
                $buffer .= $param->getDescription();
                $buffer .= PHP_EOL;
            }
        }

        if (count($return)) {
            $return = $head($return);

            $buffer .= 'return | ';
            $buffer .= $return->getType();
            $buffer .= ' | ';
            $buffer .= $return->getDescription();
            $buffer .= PHP_EOL;
        }

        return $buffer;
    }

    public function generateExceptionWarning($docBlock)
    {
        $head = ArrayList::using('head');
        $throwTag = $this->filterTags('throws');
        $throw = $throwTag($docBlock->getTags());

        return count($throw)
            ?
            /* Begin Heredoce */
<<<EOD

!!! Warning
    Throws {$head($throw)->getContent()}

EOD
            /* End Heredoc */
            : '';
    }

    public function generateFunctionDoc($f)
    {
        $doc = new DocBlock($f);

        $name = $f->getName();
        $shortDescription = $doc->getShortDescription() ?: 'No Summary Given';
        $longDescription  = $doc->getLongDescription()->getContents()
            ?: 'No Description Given. Make an issue referencing this function\'s lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.';
        $typeSignature    = $this->generateTypeSignature($doc);
        $exceptionWarning = $this->generateExceptionWarning($doc);
        $argTable         = $this->makeArgTable($doc);

        /* Begin Heredoc */

$buffer = <<<EOD

## {$name}

__{$shortDescription}__ :: {$typeSignature}

$exceptionWarning

{$longDescription}

{$argTable}

---

EOD;

        /* End Heredoc */

        return $buffer;
    }

    public function generateModuleDoc($module)
    {
        // Dependencies
        $filter  = ArrayList::using('filter');
        $methods = $filter(function($f) use ($module) {
            return $f->class === $module;
        });
        $alphabetical = function($a, $b) {
            return strcmp($a->name, $b->name);
        };

        $buffer        = '';
        $r             = new \ReflectionClass($module);
        $moduleMethods = $methods($r->getMethods());

        usort($moduleMethods, $alphabetical);

        foreach ($moduleMethods as $f) {
            $buffer .= $this->generateFunctionDoc($f);
        }

        $autoGenFilePath = 'auto-generate/' . $this->getModuleGroup($module);
        $autoGenFileName = $autoGenFilePath . '/' . $this->getClassName($module) . '.md';
        $fullDir  = $this->docsDir . $autoGenFilePath;
        $fullPath = $this->docsDir . $autoGenFileName;

        if (!file_exists($fullDir))
            mkdir($fullDir);

        file_put_contents($fullPath, $buffer);

        return $autoGenFileName;
    }

    public function apiDoc($moduleGroup)
    {
        $yaml = [];

        foreach ($this->getVectorClasses($moduleGroup) as $module) {
            $yaml[] = [
                $this->getClassName($module) => $this->generateModuleDoc($module)
            ];
        }

        return $yaml;
    }
}
