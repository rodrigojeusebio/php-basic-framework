<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

/**
 * @method static User where(string $name,string $operator,mixed $value)
 *
 * @property-read int $id
 * @property-read string $name
 * @property-read string $email
 * @property-read string $password
 */
final class User extends Model
{
    public static string $table_name = 'users';
}
