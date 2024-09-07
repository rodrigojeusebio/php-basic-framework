<?php
namespace Core;
use Exception;

class Router
{
    /** @var array<Route> */
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
        if ($route = $this->get_route($uri, $method))
        {
            $class = $route->controller;
            $function = $route->function;
            if (!class_exists($class))
            {
                throw new Exception("Class '$class' does not exist");
            }
            if (!method_exists($class, $function))
            {
                throw new Exception("Method does not exist in class $class", 1);
            }
            call_user_func([$class, $function], $_SERVER['']);
        }
        else
        {
            dd('uri not found');
        }
    }

    private function register_route(
        string $uri,
        string $method,
        string $controller,
        string $function
    ) {
        $this->routes[] = new Route($uri, $method, $controller, $function);
    }

    private function get_route(string $uri, string $method): Route|false
    {
        foreach ($this->routes as $route)
        {
            if ($route->uri === $uri && $route->method === $method)
            {
                return $route;
            }
        }
        return false;
    }
}

class Route
{
    public function __construct(
        public readonly string $uri,
        public readonly string $method,
        public readonly string $controller,
        public readonly string $function,
    ) {
    }
}

enum HttpMethods
{
    case GET;
    case POST;
    case PATCH;
    case PUT;
    case DELETE;
}
