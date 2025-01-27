<?php

namespace App\Middleware;

use Core\Middleware;
use Core\Request;
use Libs\Auth;

class GuestMiddleware implements Middleware
{
    public function handle(): void
    {
        if (! Auth::guest()) {
            Request::redirect('/');
        }
    }
}
