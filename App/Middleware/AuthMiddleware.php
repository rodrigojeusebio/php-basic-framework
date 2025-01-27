<?php

namespace App\Middleware;

use Core\Middleware;
use Core\Request;
use Libs\Auth;

class AuthMiddleware implements Middleware
{
    public function handle(): void
    {
        if (Auth::guest()) {
            Request::redirect('/login');
        }
    }
}
