<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseFactoryInterface;
use Recruitment\Applicant\Search\ElasticIndex;
use Recruitment\Applicant\Search\Index;
use Recruitment\Web\HttpMethodNotAllowedHandler;
use Recruitment\Web\HttpNotFoundHandler;
use Recruitment\Web\SearchController;
use Slim\App;
use Slim\CallableResolver;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Interfaces\RouteCollectorInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Routing\RouteCollector;

$dependencies = [
    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    Index::class => function ($container) {
        return new ElasticIndex();
    },
    ResponseFactoryInterface::class => function ($container) {
        return $container->get(Psr17Factory::class);
    },
    CallableResolverInterface::class => function ($container) {
        return new CallableResolver($container);
    },
    RouteCollectorInterface::class => function ($container) {
        return new RouteCollector(
            $container->get(ResponseFactoryInterface::class),
            $container->get(CallableResolverInterface::class),
            $container
        );
    },
    RouteParserInterface::class => function ($container) {
        return $container->get(RouteCollectorInterface::class)->getRouteParser();
    },
];

$container = new Container();
foreach ($dependencies as $dependency => $factory) {
    $container->set($dependency, $factory);
}

$app = new App(
    $container->get(ResponseFactoryInterface::class),
    $container,
    $container->get(CallableResolverInterface::class),
    $container->get(RouteCollectorInterface::class)
);

$errorMiddleware = $app->addErrorMiddleware(false, true, true);
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, new HttpNotFoundHandler());
$errorMiddleware->setErrorHandler(HttpMethodNotAllowedException::class, new HttpMethodNotAllowedHandler());

$app->get('/applicant/', SearchController::class);

$app->run();
