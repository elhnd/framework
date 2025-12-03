<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

function is_leap_year(?int $year = null): bool
{
    if (null === $year) {
        $year = (int)date('Y');
    }

    return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
}

class LeapYearController
{
    public function index(Request $request): Response
    {
        if (is_leap_year($request->attributes->get('year'))) {
            return new Response('Yes, this is a leap year.');
        }

        return new Response('Nope, this is not a leap year.');
    }
}

$routes = new Routing\RouteCollection();

$routes->add('hello', new Routing\Route('/hello/{name}', [
    'name' => 'World',
    '_controller' => function (Request $request): Response {
        $request->attributes->set('foo', 'bar');

        $response = render_template($request);

        $response->headers->set('Content-Type', 'text/plain');

        return $response;
    }
]));
$routes->add('bye', new Routing\Route('/bye'));

$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', [
    'year' => null,
    '_controller' => 'LeapYearController::index',
    //'_controller' => [new LeapYearController(), 'index'],
]));


return $routes;
