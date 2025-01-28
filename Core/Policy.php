<?php

namespace Core;

use App\Models\User;

abstract class Policy
{
    public static function index(User $user): void {}

    public static function view(ORM $orm, User $user): void {}

    public static function create(User $user): void {}

    public static function store(User $user): void {}

    public static function edit(ORM $orm, User $user): void {}

    public static function update(ORM $orm, User $user): void {}

    public static function destroy(ORM $orm, User $user): void {}
}
