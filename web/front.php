<?php

require_once '../vendor/autoload.php';

use Simplex\StringResponseListener;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();
$routes = include __DIR__ . '/../src/app.php';

$container = include __DIR__.'/../src/container.php';

$container->set('routes', $routes);

$container->register('listener.string_response', StringResponseListener::class);

$container->getDefinition('dispatcher')
    ->addMethodCall('addSubscriber', [new Reference('listener.string_response')])
;

$response = $container->get('framework')->handle($request)->send();
    