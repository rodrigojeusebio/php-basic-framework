<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use Core\Render;
use Core\Request;
use Core\Validation;

final class User_Controller
{
    public static function index(): void
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

    public static function show(int $user_id): void
    {
        $user = User::find($user_id);

        Render::view('users/show', ['user_name' => $user->name, 'user_id' => $user_id]);
    }

    public static function create(): void
    {
        Render::view('users/create', []);
    }

    public static function edit(int $id): void
    {
        $user = User::find($id);

        Render::view('users/edit', ['user' => $user]);
    }

    public static function store(): void
    {
        $attributes = Request::attributes();

        $validation = (new Validation($attributes))
            ->add_rule('name', 'required');

        if ($validation->validate()) {
            $user = User::create($validation->values);

            Request::redirect("/users/$user->id");
        } else {
            Render::view('users/create', ['attributes' => $attributes, 'errors' => $validation->errors]);
        }

    }

    public static function update(int $id): void
    {
        $attributes = Request::attributes();

        $user = User::find($id);

        $user->update($attributes);

        Request::redirect("/users/$user->id");
    }

    public static function destroy(int $id): void
    {
        $user = User::find($id);
        $user->delete();

        Request::redirect('/users');
    }
}
