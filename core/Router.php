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

    public function resolveArguments(Request $request): array
    {
        $path = $request->getPathInfo();
        $routes = array_keys($this->routes);

        foreach ($routes as $route) {

            $pattern = preg_replace('#{(\w+)}#', '(.*)', $route);

            if (preg_match('#^' . $pattern . '$#', $path, $params)) {
                array_shift($params);
                return $params;
            }
        }

        return [];
    }

    public function resolveController(Request $request): callable
    {
        $path = $request->getPathInfo();
        $routes = array_keys($this->routes);
        $routeConfiguration = array_values($this->routes);

        foreach ($routes as $key => $route) {

            $pattern = preg_replace('#{(\w+)}#', '(.*)', $route);

            if (preg_match('#^' . $pattern . '$#', $path, $m)) {

                foreach ($routeConfiguration[$key] as $data) {
                    ['controller' => $controller, 'http_methods' => $http_methods] = $data;

                    // si $http_methods est vide on autorise tous les verbs
                    if(empty($http_methods)) {
                        [$class, $method] = explode("::", $controller);

                        return [new $class(), $method];
                    }

                    // sinon on vérifie que le verb est valide
                    if(in_array($request->getMethod(), $http_methods)) {
                        [$class, $method] = explode("::", $controller);

                        return [new $class(), $method];
                    }
                }

                // si aucun verb ne correspond, alors 405
                throw new \Exception('Method Not Allow Exception'); // 405
            }
        }

        throw new NotFoundException(sprintf('Route "%s" not found', $path));
    }

    public function __resolveController(Request $request): callable
    {
        // $pathInfo = preg_replace( "#^/[a-z_-]+/#", "/", $request->getPathInfo());
        $pathInfo = $request->getPathInfo();

        if (!array_key_exists($pathInfo, $this->routes)) {
            throw new NotFoundException(sprintf('Route "%s" not found', $pathInfo));
        }

        /*$controller = $this->routes[$pathInfo]['controller'];
        $http_methods = $this->routes[$pathInfo]['http_methods'];*/

        ['controller' => $controller, 'http_methods' => $http_methods] = $this->routes[$pathInfo];

        if (!empty($http_methods) && !in_array($request->getMethod(), $http_methods)) {
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
