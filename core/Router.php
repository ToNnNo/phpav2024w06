<?php

namespace Core;

use Core\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\Request;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        $this->loadConfiguration();
    }

    public function resolveController(Request $request): callable
    {
        // $pathInfo = preg_replace( "#^/[a-z_-]+/#", "/", $request->getPathInfo());
        $pathInfo = $request->getPathInfo();

        if( !array_key_exists($pathInfo, $this->routes) ) {
            throw new NotFoundException(sprintf('Route "%s" not found', $pathInfo));
        }

        /*$controller = $this->routes[$pathInfo]['controller'];
        $http_methods = $this->routes[$pathInfo]['http_methods'];*/

        ['controller' => $controller, 'http_methods' => $http_methods] = $this->routes[$pathInfo];

        if( !empty($http_methods) && !in_array($request->getMethod(), $http_methods) ) {
            throw new \Exception('Method Not Allow Exception'); // 405
        }

        [$class, $method] = explode("::", $controller);

        $instance = new $class(); // inversion de controle (loC)

        return [$instance, $method];
    }

    private function loadConfiguration(): void
    {
        $this->routes = require dirname(__DIR__) . "/routes.php";
    }
}
