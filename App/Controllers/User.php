<?php

namespace App\Controllers;

class User
{
    public static function index()
    {
        dd('hello from users');
    }

    public static function show(int $user_id, string $other = null)
    {
        dd("user $user_id is happy to see you");
    }
}