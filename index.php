<?php

require __DIR__ . '/vendor/autoload.php';

use phpDocumentor\Reflection\DocBlock;
use Vector\Lib\ArrayList;
use Vector\Control\Lens;
use Vector\Core\Module;

$someApiResponse = [
    "meta" => [
        "info" => "An API Request Example"
    ],
    "data" => [
        "users" => [
            [
                "name" => "Joseph",
                "favorites" => [
                    "colors" => [
                        "blue",
                        "green"
                    ],
                    "foods" => [
                        "pho",
                        "fajitas"
                    ]
                ]
            ],
            [
                "name" => "Logan",
                "favorites" => [
                    "colors" => [
                        "red"
                    ],
                    "foods" => [
                        "hamburgers",
                        "curry"
                    ]
                ]
            ]
        ]
    ]
];

$timestampLens = Lens::pathLensSafe(['meta', 'timestamp']);

$withTimestamps = Lens::setL(
    $timestampLens,
    time(),
    $someApiResponse
);

var_dump($withTimestamps);
