<?php

namespace App\Controllers;

use App\Models\User;
use Core\Database;
use Core\Render;

class User_Controller
{
    public static function index()
    {
        dd('users list all');
    }

    public static function show(int $user_id)
    {

        $user = User::find(1);

        d($user->username);

        $d = Database::get();

        var_dump($d
            ->from('users')
            ->where('id', '=', '1')
            ->find());

        Render::view('users/show', ['user_name' => 'Rodrigo', 'user_id' => $user_id]);
    }

    public static function create()
    {
        Render::view('users/create', []);
    }

    public static function store()
    {
        $attributes = $_POST;
        User::create($attributes);

        dd($attributes);
    }

    public static function delete()
    {
        dd('user deleted');
    }
}