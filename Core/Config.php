<?php
namespace Core;

use Libs\Singleton;


final class Config extends Singleton
{
    private array $configs = [];

    public static function get(string $option): mixed
    {
        if (isset(self::get_instance()->configs[$option]))
        {
            return self::get_instance()->configs[$option];
        }

        return null;
    }

    public static function set(string $option, mixed $value): void
    {
        self::get_instance()->configs[$option] = $value;
    }
}