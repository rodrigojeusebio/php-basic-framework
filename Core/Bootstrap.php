<?php

declare(strict_types=1);

namespace Core;

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

include_once Config::get('app_path').'Routes/web.php';
include_once Config::get('app_path').'Routes/auth.php';

MiddlewareManager::add_middleware('auth', new AuthMiddleware);
MiddlewareManager::add_middleware('guest', new GuestMiddleware);

Session::start();
Router::route(Request::uri(), Request::method());
Session::unflash();
