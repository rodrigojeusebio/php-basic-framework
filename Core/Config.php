<?php

declare(strict_types=1);

namespace Core;

require_once 'Libs/File.php';

use Libs\File;
use Libs\Singleton;

final class Config extends Singleton
{
    /** @var array<string,string> */
    private array $configs = [];

    public static function load_env(string $env_file): void
    {
        foreach (File::get_lines($env_file) as $line) {
            [$option, $value] = explode('=', $line);
            self::set($option, $value);
        }
    }

    /**
     * Summary of get
     */
    public static function get(string $option, ?string $default = null): ?string
    {
        $configs = self::get_instance()->configs;

        if (isset($configs[$option])) {
            return $configs[$option];
        }

        if ($default) {
            return $default;
        }

        return null;
    }

    /**
     * Get all defined config variables
     *
     * @return array<string,string>
     */
    public static function all(): array
    {
        return self::get_instance()->configs;
    }

    /**
     * Define a configuratino key-value pair
     */
    public static function set(string $option, string $value): void
    {
        self::get_instance()->configs[$option] = $value;
    }
}
