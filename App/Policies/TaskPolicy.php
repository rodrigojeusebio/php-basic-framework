<?php

namespace App\Policies;

use App\Models\User;
use Core\ORM;
use Core\Policy;
use Core\Request;

class TaskPolicy extends Policy
{
    public static function view(ORM $task, User $user): void
    {
        if ($task->user_id !== $user->id) {
            Request::unauthorized();
        }
    }
}
