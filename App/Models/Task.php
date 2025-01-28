<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

/**
 * @method static where(string $name,string $operator,mixed $value)
 *
 * @property-read int $id
 * @property-read int $user_id
 * @property-read string $description
 * @property-read bool $complete
 */
final class Task extends Model
{
    public static string $table_name = 'tasks';
}
