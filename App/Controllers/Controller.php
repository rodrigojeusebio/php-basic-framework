<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Render;

final class Controller
{
    public static function home()
    {
        Render::view('default_pages/home');
    }
}
