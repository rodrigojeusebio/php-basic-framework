<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use Core\App_Exception;
use Core\Database;
use Core\Render;
use Core\Request;

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

    public static function edit(int $id): never
    {
        $user = User::find($id);

        Render::view('users/edit', ['user' => $user]);
    }

    public static function store(): never
    {
        $attributes = Request::attributes();

        $user = User::create($attributes);

        Request::redirect("/users/$user->id");
    }

    public static function update(int $id): never
    {
        $attributes = Request::attributes();

        $user = User::find($id);

        $user->update($attributes);

        Request::redirect("/users/$user->id");
    }

    public static function delete(): never
    {
        Request::redirect('/users');
    }
}
