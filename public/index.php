<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseFactoryInterface;
use Recruitment\Applicant\Search\ElasticIndex;
use Recruitment\Applicant\Search\Index;
use Recruitment\Web\SearchController;
use Slim\App;

$dependencies = [
    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    Index::class => static function ($container) {
        return new ElasticIndex();
    },
    ResponseFactoryInterface::class => static function ($container) {
        return $container->get(Psr17Factory::class);
    },
];

$container = new Container();
foreach ($dependencies as $dependency => $factory) {
    $container->set($dependency, $factory);
}

$app = new App(
    $container->get(ResponseFactoryInterface::class),
    $container,
);

$app->addErrorMiddleware(false, true, true);

$app->get('/applicant/', SearchController::class);

$app->run();
