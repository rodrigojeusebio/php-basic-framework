<?php

namespace Libs;

use App\Models\User;
use Core\App_Exception;
use Core\Session;

class Auth extends Singleton
{
    public static function attempt(string $email, string $password): bool
    {
        Session::regenerate();

        /** @var User */
        $user = User::where('email', '=', $email)->find();

        if ($user->loaded() && password_verify($password, $user->password)) {
            self::login($user->id);

            return true;
        }

        return false;
    }

    public static function login(int $id): void
    {
        Session::set('user_id', $id);
    }

    public static function guest(): bool
    {
        if (Session::get('user_id')) {
            return false;
        }

        return true;
    }

    public static function check(): bool
    {
        if (Session::get('user_id')) {
            return true;
        }

        return false;
    }

    public static function user(): User
    {
        $user_id = Session::get('user_id');
        if (is_int($user_id)) {
            return User::find($user_id, true);
        }
        throw new App_Exception('error', 'Trying to access user, but no user is logged in');
    }

    public function logout(): void
    {
        Session::destroy();
    }
}
