<?php
namespace Core;

use Libs\Singleton;


final class Config extends Singleton
{
    private array $configs = [];

    public static function load_env(string $env_file)
    {
        if (file_exists($env_file))
        {
            $contents = explode("\n", file_get_contents($env_file));
            $contents = array_map(fn($e) => explode('=', $e), $contents);

            foreach ($contents as [$option, $value])
            {
                Config::set($option, $value);
            }
        }
        else
        {
            throw new \Exception("Environment file does not exist");
        }
    }

    public static function get(string $option): mixed
    {
        $configs = self::get_instance()->configs;

        if (isset($configs[$option]))
        {
            return $configs[$option];
        }

        return null;
    }

    public static function set(string $option, mixed $value): void
    {
        self::get_instance()->configs[$option] = $value;
    }
}