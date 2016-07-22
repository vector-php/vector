#!/usr/bin/env php

<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Vector\Euclid\Console\GenerateDocumentationCommand;

$application = new Application();
$application->add(new GenerateDocumentationCommand());
$application->run();
