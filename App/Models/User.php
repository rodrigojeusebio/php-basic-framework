<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

/**
 * @method static where(string $name,string $operator,mixed $value)
 *
 * @property-read string $password
 */
final class User extends Model
{
    public static string $table_name = 'users';
}
