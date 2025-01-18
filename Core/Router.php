<?php

declare(strict_types=1);

namespace Core;

use Exception;
use Libs\Singleton;

final class Router extends Singleton
{
    /** @var array<Route> */
    protected static array $routes = [];

    public static function get(
        string $uri,
        string $controller,
        string $function,
    ): void {
        self::get_instance()::register_route($uri, HttpMethod::GET, $controller, $function);
    }

    public static function post(
        string $uri,
        string $controller,
        string $function,
    ): void {
        self::get_instance()::register_route($uri, HttpMethod::POST, $controller, $function);
    }

    public static function delete(
        string $uri,
        string $controller,
        string $function,
    ): void {
        self::get_instance()::register_route($uri, HttpMethod::DELETE, $controller, $function);
    }

    public static function put(
        string $uri,
        string $controller,
        string $function,
    ): void {
        self::get_instance()::register_route($uri, HttpMethod::PUT, $controller, $function);
    }

    public static function patch(
        string $uri,
        string $controller,
        string $function,
    ): void {
        self::get_instance()::register_route($uri, HttpMethod::PATCH, $controller, $function);
    }

    public static function route(string $uri, HttpMethod $method): void
    {
        if ($route = self::get_instance()::get_route($uri, $method)) {
            $class = $route->controller;
            $function = $route->function;

            if (! class_exists($class)) {
                throw new Exception("Class '$class' does not exist");
            }
            if (! method_exists($class, $function)) {
                throw new Exception("Method does not exist in class $class");
            }

            /** @var callable(): mixed */
            $callback = [$class, $function];

            call_user_func($callback, ...$route->parameters);
        } else {
            Render::view('default_pages/404');
        }
    }

    private static function register_route(
        string $uri,
        HttpMethod $method,
        string $controller,
        string $function
    ): void {
        self::get_instance()::$routes[] = new Route($uri, $method, $controller, $function);
    }

    /**
     * Get the route that the $uri corresponds too
     */
    private static function get_route(string $request_uri, HttpMethod $method): Route|false
    {
        foreach (self::get_instance()::$routes as $route) {
            if ($route->method !== $method) {
                continue;
            }

            $app_uri_elements = URI::from($route->uri)->get_elements();
            $request_uri_elements = URI::from($request_uri)->get_elements();

            if (count($app_uri_elements) !== count($request_uri_elements)) {
                continue;
            }

            $match = true;
            $function_parameters = [];
            foreach ($app_uri_elements as $index => $element) {
                if (URI::is_wildcard($element)) {
                    $function_parameters[] = $request_uri_elements[$index];

                    continue;
                }

                if ($element !== $request_uri_elements[$index]) {
                    $match = false;
                    break;
                }
            }

            if ($match) {
                $route->parameters = $function_parameters;

                return $route;
            }
        }

        return false;
    }
}

final class URI
{
    public function __construct(
        private string $string_uri
    ) {}

    public static function from(string $uri): static
    {
        return new self($uri);
    }

    public static function is_wildcard(string $element): bool
    {
        if (mb_strlen($element) > 1) {
            return $element[0] === '{' && $element[1] === ':';
        }

        return false;
    }

    /**
     * @return array<string>
     */
    public function get_elements(): array
    {
        return explode('/', $this->string_uri);
    }
}

final class Route
{
    /**
     * @var array<mixed>
     */
    public array $parameters;

    public function __construct(
        public readonly string $uri,
        public readonly HttpMethod $method,
        public readonly string $controller,
        public readonly string $function,
    ) {}
}

enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PATCH = 'PATCH';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
}
