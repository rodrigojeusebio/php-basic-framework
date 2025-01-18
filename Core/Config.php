<?php
namespace Core;
require_once 'Libs/File.php';

use Libs\Singleton;
use Libs\File;

final class Config extends Singleton
{
    private array $configs = [];

    public static function load_env(string $env_file)
    {
        foreach (File::get_lines($env_file) as $line)
        {
            [$option, $value] = explode('=', $line);
            Config::set($option, $value);
        }
    }

    /**
     * Summary of get
     * @param string $option
     * @return mixed
     */
    public static function get(string $option, mixed $default = null): mixed
    {
        $configs = self::get_instance()->configs;

        if (isset($configs[$option]))
        {
            return $configs[$option];
        }

        if ($default)
        {
            return $default;
        }

        return null;
    }

    /**
     * Get all defined config variables  
     */
    public static function all(): array
    {
        return self::get_instance()->configs;
    }

    /**
     * Define a configuratino key-value pair  
     */
    public static function set(string $option, mixed $value): void
    {
        self::get_instance()->configs[$option] = $value;
    }
}