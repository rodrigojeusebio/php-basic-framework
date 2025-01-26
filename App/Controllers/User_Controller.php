<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use Core\Render;
use Core\Request;
use Core\Validation;

final class User_Controller
{
    public static function index(): never
    {
        $filters = Request::parameters();

        if (isset($filters['name'])) {
            $users = User::like('name', $filters['name'])
                ->all();
        } else {
            $users = User::all();
        }

        Render::view('users/index', ['users' => $users]);
    }

    public static function show(int $user_id): never
    {
        $user = User::find($user_id);

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

        $validation = (new Validation($attributes))
            ->add_rule('name', 'required')
            ->add_callback('password', function (Validation $validation) {
                if ($validation->password === 'password') {
                    $validation->add_error('password', 'Another user already has this password');
                }
            });

        if ($validation->validate()) {
            $user = User::create($validation->values);

            Request::redirect("/users/$user->id");
        } else {
            Render::view('users/create', ['attributes' => $attributes, 'errors' => $validation->errors]);
        }

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
