<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

// Register middlewares
// alias => middleware instance
return [
    'auth' => new AuthMiddleware,
    'guest' => new GuestMiddleware,
];
