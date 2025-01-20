<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Render;

final class Controller
{
    public static function home()
    {
        Render::page('default_pages/home');
    }
}
