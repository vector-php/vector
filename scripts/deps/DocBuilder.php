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
        $longDescription  = $doc->getLongDescription()->getContents() ?: 'No Description Given';
        $typeSignature    = $this->generateTypeSignature($doc);
        $exceptionWarning = $this->generateExceptionWarning($doc);

        /* Begin Heredoc */

$buffer = <<<EOD

## {$name}

> {$typeSignature}

__{$shortDescription}__

$exceptionWarning

{$longDescription}

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
