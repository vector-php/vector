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

    public function generateTypeSignature($docBlock)
    {
        $filter  = ArrayList::using('filter');
        $typeTag = $filter(function($tag) { return $tag->getName() == 'type'; }, $docBlock->getTags());

        return $typeTag
            ? $typeTag[0]->getContent()
            : 'No Type Signature Provided';
    }

    public function generateFunctionDoc($f)
    {
        $doc = new DocBlock($f);

        $name = $f->getName();
        $shortDescription = $doc->getShortDescription() ?: 'No Summary Given';
        $longDescription  = $doc->getLongDescription()->getContents() ?: 'No Description Given';
        $typeSignature    = $this->generateTypeSignature($doc);

        /* Begin Heredoc */

$buffer = <<<EOD

# {$name}

> {$typeSignature}

__{$shortDescription}__

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
