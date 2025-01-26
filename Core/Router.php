<?php

declare(strict_types=1);

namespace Core;

use Closure;
use Exception;
use Libs\Singleton;

final class Router extends Singleton
{
    /** @var array<Route> */
    protected static array $routes = [];

    /**
     * @param  array{string,string}|Closure  $callback
     */
    public static function get(
        string $uri,
        array|Closure $callback,
    ): void {
        self::get_instance()::register_route($uri, HttpMethod::GET, $callback);
    }

    /**
     * @param  array{string,string}|Closure  $callback
     */
    public static function post(
        string $uri,
        array|Closure $callback,
    ): void {
        self::get_instance()::register_route($uri, HttpMethod::POST, $callback);
    }

    /**
     * @param  array{string,string}|Closure  $callback
     */
    public static function patch(
        string $uri,
        array|Closure $callback,
    ): void {
        self::get_instance()::register_route($uri, HttpMethod::PATCH, $callback);
    }

    /**
     * @param  array{string,string}|Closure  $callback
     */
    public static function put(
        string $uri,
        array|Closure $callback,
    ): void {
        self::get_instance()::register_route($uri, HttpMethod::PUT, $callback);
    }

    /**
     * @param  array{string,string}|Closure  $callback
     */
    public static function delete(
        string $uri,
        array|Closure $callback,
    ): void {
        self::get_instance()::register_route($uri, HttpMethod::DELETE, $callback);
    }

    public static function route(string $uri, HttpMethod $method): void
    {
        if ($route = self::get_instance()::get_route($uri, $method)) {
            if (is_array($route->callback)) {
                [$class, $function] = $route->callback;

                if (! class_exists($class)) {
                    throw new Exception("Class '$class' does not exist");
                }
                if (! method_exists($class, $function)) {
                    throw new App_Exception('error', "Method does not exist in class $class", ['class' => $class, 'function' => $function]);
                }
                /** @var callable(): mixed */
                $callback = [$class, $function];

                call_user_func($callback, ...$route->parameters);
            } elseif ($route->callback instanceof Closure) {
                $callback = $route->callback;
                $callback(...$route->parameters);
            }

        } else {
            Render::view('default_pages/404');
        }
    }

    /**
     * @param  array{string,string}|Closure  $callback
     */
    private static function register_route(
        string $uri,
        HttpMethod $method,
        array|Closure $callback,
    ): void {
        self::get_instance()::$routes[] = new Route($uri, $method, $callback);
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

    /**
     * @param  array{string,string}|Closure  $callback
     */
    public function __construct(
        public readonly string $uri,
        public readonly HttpMethod $method,
        public readonly array|Closure $callback,
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
