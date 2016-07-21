<?php

namespace Vector\Euclid\Console;

use Reflectionmethod;

use phpDocumentor\Reflection\DocBlockFactory;

use Vector\Euclid\Doc\FunctionDoc;
use Vector\Euclid\Doc\ModuleDoc;
use Vector\Lib\ArrayList;
use Vector\Lib\Strings;
use Vector\Lib\Lambda;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateDocumentationCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('docs:generate')
            ->setDescription('Generate Documentation')
            ->addArgument(
                'modules',
                InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                'A list of modules to generate documentation for'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Given a fully qualified namespace, convert \ to / and make a file path with the md extension
        $namespaceToPath = Lambda::compose(Strings::concat('.md'), Strings::join('/'), Strings::split('\\'));

        // Given a fully qualified namespace,
        $namespaceToDir = Lambda::compose(Strings::join('/'), ArrayList::init(), Strings::split('\\'));

        // An instance of a doc block parser to pass to our documentation engine
        $docBlockParser = DocBlockFactory::createInstance();

        foreach ($input->getArgument('modules') as $module) {
            $moduleDoc = new ModuleDoc($docBlockParser, $module);
            $moduleDocMarkdownDirectory = getcwd() . '/docs/auto-generate/' . $namespaceToDir($module);
            $moduleDocMarkdownFileLocation = getcwd() . '/docs/auto-generate/' . $namespaceToPath($module);

            $buffer = '';
            foreach ($moduleDoc->getFunctionDocs() as $function) {
                $buffer .= $this->generateFunctionDocMarkdown($function);
            }

            if (!is_dir($moduleDocMarkdownDirectory)) {
                mkdir($moduleDocMarkdownDirectory, 0777, true);
            }
            file_put_contents($moduleDocMarkdownFileLocation, $buffer);
        }
    }

    private function generateFunctionDocMarkdown(FunctionDoc $function)
    {
        $eol = PHP_EOL . PHP_EOL;
        $buffer = '';

        $buffer .= '## ' . $function->properName() . $eol;
        $buffer .= '__' . $function->name() . '__ :: ' . $function->type() . $eol;
        $buffer .= $function->description() . $eol;

        $buffer .= '```' . PHP_EOL;
        foreach ($function->examples() as $example) {
            $buffer .= $example->getDescription() . PHP_EOL;
        }
        $buffer .= '```' . $eol;

        $buffer .= '---' . $eol;

        return $buffer;
    }
}
