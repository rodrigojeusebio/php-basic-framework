<?php

namespace Core;

use App\Models\User;

abstract class Policy
{
    final public static function index(User $user): void {}

    final public static function view(ORM $orm, User $user): void {}

    final public static function create(User $user): void {}

    final public static function store(User $user): void {}

    final public static function edit(ORM $orm, User $user): void {}

    final public static function update(ORM $orm, User $user): void {}

    final public static function destroy(ORM $orm, User $user): void {}
}
