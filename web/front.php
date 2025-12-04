<?php

require_once '../vendor/autoload.php';

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing;

$request = Request::createFromGlobals();
$routes = include __DIR__ . '/../src/app.php';


$context = new Routing\RequestContext();
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

$dispatcher = new EventDispatcher();

// $dispatcher->addListener('response', [new Simplex\ContentLengthListener(), 'onResponse'], -255);
// $dispatcher->addListener('response', [new Simplex\GoogleListener(), 'onResponse']);
$dispatcher->addSubscriber(new Simplex\ContentLengthListener());
$dispatcher->addSubscriber(new Simplex\GoogleListener());

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

$framework = new Simplex\Framework($dispatcher, $matcher, $controllerResolver, $argumentResolver);

$response = $framework->handle($request);

$response->send();
