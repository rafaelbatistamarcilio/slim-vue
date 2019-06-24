<?php
use Slim\Middleware\RoutingMiddleware;
use Slim\Middleware\ErrorMiddleware;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Exception\HttpForbiddenException;

require __DIR__ . './vendor/autoload.php';

use App\Router;
use App\WebContentLoader;
use App\NotFoundHandler;
use App\ForbidenHandler;
use App\UnauthorizedHandler;
use App\JsonBodyParserMiddleware;
use App\StaticContentLoader;

$app = AppFactory::create();

$routeResolver = $app->getRouteResolver();
$routingMiddleware = new RoutingMiddleware($routeResolver);
$app->add($routingMiddleware);

$callableResolver = $app->getCallableResolver();
$responseFactory = $app->getResponseFactory();
$errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, true, true);
$app->add($errorMiddleware);
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, NotFoundHandler::class);
$errorMiddleware->setErrorHandler(HttpUnauthorizedException::class, UnauthorizedHandler::class);
$errorMiddleware->setErrorHandler(HttpForbiddenException::class, ForbidenHandler::class);

$app->add(new JsonBodyParserMiddleware());
$app->get('/[{view}]', WebContentLoader::class);
$app->get('/public/[{params:.*}]', StaticContentLoader::class);
$app->group('/api', Router::class);

$app->run();