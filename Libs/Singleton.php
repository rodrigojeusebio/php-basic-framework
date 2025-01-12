<?php

namespace Libs;

class Singleton
{
    private static array $instances = [];

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }

    protected static function get_instance(): static
    {
        $subclass = static::class;

        if (! isset(self::$instances[$subclass]))
        {
            self::$instances[$subclass] = new $subclass();
        }

        return self::$instances[$subclass];
    }
}