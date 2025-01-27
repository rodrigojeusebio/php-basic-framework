<?php

namespace App\Middleware;

use Core\Request;
use Libs\Auth;

class GuestMiddleware
{
    public function handle(): void
    {
        if (! Auth::guest()) {
            Request::redirect('/');
        }
    }
}
