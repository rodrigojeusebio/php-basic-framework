<?php

namespace App\Middleware;

class Middleware
{
    public static $A_middleware_mapping = [
        'auth' => AuthMiddleware::class,
        'guest' => GuestMiddleware::class,
    ];

    /**
     * @param  array<string>  $middlewares
     */
    public static function handle(array $middlewares)
    {
        foreach ($middlewares as $middleware) {
            $middleware = new static::$A_middleware_mapping[$middleware]();
            $middleware->handle();
        }
    }
}
