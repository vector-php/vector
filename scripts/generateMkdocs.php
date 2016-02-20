<?php

use Symfony\Component\Yaml\Yaml;

$loader = require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/DocBuilder.php';

$docBuilder = new DocBuilder($loader, __DIR__ . '/../docs/');

$mkdocsYaml = [
    'site_name' => 'Vector',
    'theme' => 'readthedocs',
    'pages' => [
        [
            'Introduction' => 'index.md'
        ],
        [
            'User Guide' => [
                ['Functional Basics' => 'user-guide/basics.md'],
                ['The Function Capsule' => 'user-guide/capsule.md']
            ]
        ],
        [
            'API Reference' => [
                [
                    'Data' => [
                        ['Maybe' => 'api-reference/maybe.md'],
                        ['Either' => 'api-reference/either.md']
                    ]
                ],
                ['Lib' => $docBuilder->apiDoc('Lib')],
                ['Control' => $docBuilder->apiDoc('Control')]
            ]
        ]
    ]
];

file_put_contents(__DIR__ . '/../mkdocs.yml', Yaml::dump($mkdocsYaml, 8));
