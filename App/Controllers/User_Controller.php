<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use Core\App_Exception;
use Core\Database;
use Core\Render;

final class User_Controller
{
    public static function index(): never
    {
        throw new App_Exception('error', 'This is a test to log', ['name' => 'Rodrigo Eusébio', 'age' => 25]);
    }

    public static function show(int $user_id): never
    {
        $user = User::find($user_id);
        // $d = Database::get();

        // var_dump($d
        //     ->from('users')
        //     ->where('id', '=', '1')
        //     ->find());

        Render::view('users/show', ['user_name' => $user->name, 'user_id' => $user_id]);
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
