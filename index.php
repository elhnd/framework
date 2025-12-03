<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/vendor/autoload.php';

$request = Request::createFromGlobals();

//Simulate request
//$request = Request::create('/index.php?name=Fabien');

$name = $request->query->get('name', 'World');

$response = new Response(sprintf('Hello %s', htmlspecialchars($name, ENT_QUOTES, 'UTF-8')));

var_dump($request->getClientIp());

var_dump($request->getLanguages());
$response->prepare($request);

$response->send();


// $response = new Response();
// $response->setContent('Hello word!');
// $response->setStatusCode(200);
// $response->headers->set('Content-Type', 'text/html');
// $response->setMaxAge(10);

// $response->send();