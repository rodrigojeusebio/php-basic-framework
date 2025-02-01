<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

// Register middlewares
// alias => middleware instance
return [
    'auth' => AuthMiddleware::class,
    'guest' => GuestMiddleware::class,
];
