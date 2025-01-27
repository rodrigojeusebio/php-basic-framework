<?php

namespace Core;

use Libs\Singleton;

class MiddlewareManager extends Singleton
{
    /**
     * @var array<string,Middleware>
     */
    public array $registered_middlewares = [
    ];

    public static function add_middleware(string $alias, Middleware $middleware): void
    {
        $middleware_manager = self::get_instance();

        $middleware_manager->registered_middlewares[$alias] = $middleware;
    }

    /**
     * @param  array<string>  $middlewares
     */
    public static function handle(array $middlewares): void
    {
        $middleware_manager = self::get_instance();

        $registered_middleware = $middleware_manager->registered_middlewares;

        foreach ($middlewares as $middleware_name) {
            $middleware = get_val($registered_middleware, $middleware_name, null);

            if (!$middleware) {
                throw new App_Exception('error', 'Middleware not found', ['name' => $middleware_name]);
            }
            $middleware->handle();
        }
    }
}

interface Middleware
{
    public function handle(): void;
}
