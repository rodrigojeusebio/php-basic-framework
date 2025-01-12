<?php

namespace App\Controllers;

use App\Models\User;
use Core\Database;
use Core\Render;

class User_Controller
{
    public static function index()
    {
        $user = User::find(1);
        var_dump($user->id);
        dd('hello from users');
    }

    public static function show(int $user_id)
    {
        Render::view('users/show', ['user_name' => 'Rodrigo', 'user_id' => $user_id]);
    }

    public static function create()
    {
        Render::view('users/create', []);
    }

    public static function store()
    {
        User_Controller::index();
    }

    public static function delete()
    {
        dd('user deleted');
    }
}