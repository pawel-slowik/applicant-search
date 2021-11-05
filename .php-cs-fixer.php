<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'native_function_invocation' => false,
        'concat_space' => ['spacing' => 'one'],
    ])
    ->setFinder(Finder::create()->in(__DIR__));
