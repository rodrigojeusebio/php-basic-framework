<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use Core\Render;
use Core\Request;
use Core\Validation;
use Libs\Auth;

class Login_Controller
{
    public static function create()
    {
        Render::view('Auth/login');
    }

    public static function store()
    {

        $attributes = Request::attributes();

        $validation = (new Validation($attributes))
            ->add_rule('email', ['required', 'email'])
            ->add_rule('password', ['required', 'string']);

        if ($validation->validate()) {
            if (! Auth::attempt($validation->email, $validation->password)) {
                $validation->errors['password'][] = 'Email and password do not match';
            }
        }

        if ($validation->errors) {
            Render::view('/Auth/login', ['errors' => $validation->errors, 'attributes' => $validation->values]);
        }

        Request::redirect('/');
    }
}
