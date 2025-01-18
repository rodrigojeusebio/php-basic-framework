<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use Core\Database;
use Core\Render;

final class User_Controller
{
    public static function index(): never
    {
        dd('users list all');
    }

    public static function show(int $user_id): never
    {
        $user = User::find(1);

        d($user->username);

        // $d = Database::get();

        // var_dump($d
        //     ->from('users')
        //     ->where('id', '=', '1')
        //     ->find());

        Render::view('users/show', ['user_name' => 'Rodrigo', 'user_id' => $user_id]);
    }

    public static function create(): never
    {
        Render::view('users/create', []);
    }

    public static function store(): never
    {
        $attributes = $_POST;
        User::create($attributes);

        dd($attributes);
    }

    public static function delete(): never
    {
        dd('user deleted');
    }
}
