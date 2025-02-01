<?php

declare(strict_types=1);

namespace Core;

include_once Config::get('app_path') . 'Routes/web.php';
include_once Config::get('app_path') . 'Routes/auth.php';

/** @var array<string, Middleware> */
$middlewares = include get_base_path() . 'Config/middleware.php';

foreach ($middlewares as $key => $middleware) {
    MiddlewareManager::add_middleware($key, $middleware);
}

Session::start();
Router::route(Request::uri(), Request::method());
Session::unflash();
