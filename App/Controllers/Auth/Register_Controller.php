<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Models\User;
use Core\Render;
use Core\Request;
use Core\Session;
use Core\Validation;
use Libs\Auth;

class Register_Controller
{
    public static function create()
    {
        Render::view('Auth/register');
    }

    public static function store()
    {
        $attributes = Request::attributes();

        $validation = (new Validation($attributes))
            ->add_rule('name', ['required', 'string'])
            ->add_rule('password', ['required', 'string'])
            ->add_rule('email', ['required', 'email'])
            ->add_callback('email', function (Validation $validation, string $field) {
                if (User::where('email', '=', $validation->$field)->all()) {
                    $validation->add_error($field, 'A user with this email already exists');
                }
            })
            ->add_callback('password', function (Validation $validation, string $field) {
                $password = $validation->$field;
                $len = mb_strlen($password);
                if ($len < 7 || $len > 255) {
                    $validation->add_error($field, 'Password must be between 7 and 255 chars');
                }
            });

        if ($validation->validate()) {
            $values = $validation->values;

            $values['password'] = password_hash($values['password'], PASSWORD_BCRYPT);

            $user = User::create($values);

            Auth::login($user->id);
        } else {
            Session::flash('errors', $validation->errors);
            Session::flash('values', $validation->values);
            Request::redirect('/register');
        }

        Request::redirect('/');
    }
}
