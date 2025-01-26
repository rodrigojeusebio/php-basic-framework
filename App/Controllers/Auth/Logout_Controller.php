<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use Core\Request;
use Core\Session;

class Logout_Controller
{
    public static function destroy()
    {
        Session::destroy();
        Request::redirect('/');
    }
}
