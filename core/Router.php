<?php
namespace Core;

class Router
{
    protected $routes = [];

    public function get(
        string $uri,
        string $controller,
        string $function,
    ) {
        $this->register_route($uri, 'GET', $controller, $function);
    }

    public function post(
        string $uri,
        string $controller,
        string $function,
    ) {
        $this->register_route($uri, 'POST', $controller, $function);
    }

    public function delete(
        string $uri,
        string $controller,
        string $function,
    ) {
        $this->register_route($uri, 'DELETE', $controller, $function);
    }

    public function put(
        string $uri,
        string $controller,
        string $function,
    ) {
        $this->register_route($uri, 'PUT', $controller, $function);
    }

    public function patch(
        string $uri,
        string $controller,
        string $function,
    ) {
        $this->register_route($uri, 'PATCH', $controller, $function);
    }

    public function route($uri, $method)
    {
        if ($route = $this->get_route($uri, $method)) {
            $class = $route['controller'];
            $function = $route['function'];
            call_user_func($class . '::' . $function);
        } else {
            dd('uri not found');
        }
    }

    private function register_route(
        string $uri,
        string $method,
        string $controller,
        string $function
    ) {
        $this->routes[] = [
            'uri' => $uri,
            'method' => $method,
            'controller' => $controller,
            'function' => $function
        ];
    }

    private function get_route(string $uri, string $method): array
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $method) {
                return $route;
            }
        }
        return [];
    }

}