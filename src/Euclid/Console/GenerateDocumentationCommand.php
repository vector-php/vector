<?php

namespace Vector\Euclid\Console;

use phpDocumentor\Reflection\DocBlock\Tags\Generic;
use Vector\Control\Pattern;
use Vector\Data\Either\Left;
use Vector\Data\Either\Right;
use Vector\Euclid\Doc\FunctionDocFactory;
use Vector\Euclid\Doc\FunctionDocEmpty;
use Vector\Control\Lens;
use Vector\Control\Functor;
use Vector\Lib\Arrays;
use Vector\Lib\Strings;
use Vector\Lib\Lambda;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GenerateDocumentationCommand
 * @package Vector\Euclid\Console
 */
class GenerateDocumentationCommand extends Command
{
    const EOL = PHP_EOL . PHP_EOL;

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
        // This command must be run from the project root directory. A reasonable(ly hacky) way to check this is to check for
        // the existence of the composer.json file.
        if (!file_exists(getcwd() . '/composer.json')) {
            $output->writeln('<error>This command must be run from the project\'s root directory.</error>');
            return;
        }

        // Given a fully qualified namespace, convert \ to / and make a file path with the md extension
        $namespaceToPath = Lambda::compose(Strings::concat('.md'), Strings::join('/'), Strings::split('\\'));

        // Given a fully qualified namespace, create the containing directory
        $namespaceToDir = Lambda::compose(Strings::join('/'), Arrays::init(), Strings::split('\\'));

        // A tree that represents the organization of the modules we're generating documentation for
        $moduleDirectory = [];

        // For each module, we're going to generate a documentation file and place it in the auto-generate folder in the
        // root docs directory. We're going to build up the module directory as we go
        foreach ($input->getArgument('modules') as $module) {
            $moduleDoc = FunctionDocFactory::createModuleDocFromName($module);
            $moduleDocMarkdownDirectory = getcwd() . '/docs/auto-generate/' . $namespaceToDir($module);
            $moduleDocMarkdownFileLocation = getcwd() . '/docs/auto-generate/' . $namespaceToPath($module);

            $moduleDirectory = Lens::setL(
                Lens::pathLensSafe(Strings::split('\\', $module)),
                'auto-generate/' . $namespaceToPath($module),
                $moduleDirectory
            );

            // Sort the functions in the docs alphabetically
            $functions = Arrays::sort(function ($fA, $fB) {
                return $fA->properName() <=> $fB->properName();
            }, $moduleDoc->getFunctionDocs());

            // For each function in this module, add the markdown content to a buffer
            $buffer = '';
            foreach ($functions as $function) {
                $buffer .= $this->generateFunctionDocMarkdown($function);
            }

            // Make sure the location we're putting it exists
            if (!is_dir($moduleDocMarkdownDirectory)) {
                // 777 all day every day
                mkdir($moduleDocMarkdownDirectory, 0777, true);
            }

            // Then put it there
            file_put_contents($moduleDocMarkdownFileLocation, $buffer);
        }

        // Write the mkdocs.yml file in the project directory
        file_put_contents(getcwd() . '/mkdocs.yml', $this->generateMkdocsYaml($moduleDirectory));
    }

    private function generateFunctionDocMarkdown($function)
    {
        $eol = PHP_EOL . PHP_EOL;
        $buffer = '';

        // If this function is missing docs
        if ($function instanceof FunctionDocEmpty) {
            $buffer .= '## ' . $function->properName() . $eol;
            $buffer .= $function->emptyDocMessage() . $eol;
        } else {
            // Otherwise generate the markdown content
            $buffer .= '## ' . $function->properName();
            $buffer .= '[Source](' . $function->githubSource() . ')' . $eol;
            $buffer .= '__' . $function->name() . '__ :: ';
            $buffer .= Pattern::match([
                function (Right $right) {
                    return function (Generic $generic) {
                        return $generic->getDescription();
                    };
                },
                function (Left $left) {
                    return function ($value) {
                        return $value;
                    };
                }
            ])($function->type()) . $eol;
            $buffer .= $function->description() . $eol;

            $appended = Functor::fmap(function ($example) use ($eol) {
                return Pattern::match([
                    function (Right $examples) {
                        return function ($examples) {
                            $exampleBuffer = "";
                            $exampleBuffer .= '```' . PHP_EOL;
                            foreach ($examples as $example) {
                                $exampleBuffer .= $example->getDescription() . PHP_EOL;
                            }
                            $exampleBuffer .= '```' . self::EOL;

                            return $exampleBuffer;
                        };
                    },
                    function (Left $examples) {
                        return Lambda::always('TODO');
                    },
                    function (Generic $generic) {
                        $exampleBuffer = "";
                        $exampleBuffer .= '```' . PHP_EOL;
                        $exampleBuffer .= $generic->getDescription() . PHP_EOL;
                        $exampleBuffer .= '```' . self::EOL;

                        return $exampleBuffer;
                    },
                    function (string $a) {
                        return $a . self::EOL;
                    },
                    function (array $examples) {
                        $exampleBuffer = "";
                        $exampleBuffer .= '```' . PHP_EOL;
                        foreach ($examples as $example) {
                            $exampleBuffer .= $example->getDescription() . PHP_EOL;
                        }
                        $exampleBuffer .= '```' . self::EOL;

                        return $exampleBuffer;
                    },
                ])($example);
            }, $function->examples());

            $buffer .= Pattern::match([
                function (Right $toAppend) {
                    return Lambda::id();
                },
                function (Left $error) {
                    return Lambda::always('TODO');
                }
            ])($appended);
        }

        $buffer .= '---' . $eol;

        return $buffer;
    }

    private function generateMkdocsYaml($moduleDirectory)
    {
        /*
        YAML is literally the worst thing in the world.

        Our module directory looks like this:
        [
            'First Level Namespace' => [
                'Second Level Namespace A' => [
                    'Module A' => 'path'
                ],
                'Second Level Namespace B' => [
                    'Module B' => 'path'
                ]
            ]
        ]

        But it needs to look like this:
        [
            'First Level Namespace' => [
                [
                    'Second Level Namespace A' => [
                        ['Module A' => 'path']
                    ]
                ], [
                    'Second Level Namespace B' => [
                        ['Module B' => 'path']
                    ]
                ]
            ]
        ]

        Notice the absolutely redundant and unneccessary extra level of nesting
        */
        $yaml = [
            'site_name' => 'Vector',
            'site_description' => 'Functional primitives for PHP',
            'site_author' => 'Joseph Walker',
            'site_url' => 'https://packagist.org/packages/vector/core',
            'repo_name' => 'GitHub',
            'repo_url' => 'https://github.com/joseph-walker/vector',
            'copyright' => 'Copyright (c) 2016 Joseph Walker',
            'theme' => 'readthedocs',
            'markdown_extensions' => ['admonition'],
            'extra_css' => ['extra.css'],
            'pages' => [
                [
                    'Introduction' => 'index.md'
                ],
                [
                    'User Guide' => [
                        ['Functional Basics' => 'user-guide/basics.md'],
                        ['Vector Modules' => 'user-guide/module.md']
                    ]
                ],
                [
                    'Advanced Topics' => [
                        ['Lenses' => 'advanced/lenses.md'],
                        ['Functors, Applicatives & Monads' => 'advanced/fam.md']
                    ]
                ],
                $this->dictToList($moduleDirectory)[0]
            ]
        ];

        return Yaml::dump($yaml, 8);
    }

    private function dictToList($dict) {
        if (!is_array($dict))
            return $dict;

        return Arrays::mapIndexed(function($v, $k) {
            return [$k => $this->dictToList($v)];
        }, $dict);
    }
}
