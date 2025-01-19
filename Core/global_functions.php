<?php

declare(strict_types=1);

use Core\Config;

function style_key(string $key): string
{
    return "<span style=\"color: green; font-weight: bold\">$key</span>";
}

function style_value(string $value): string
{
    return "<span style=\"color: orange; \">$value</span>";
}
/**
 * @param  string|array<string|string>  $value
 */
function d(string|array $value): void
{

    $message = '<div style="background-color: black; border: 2px solid orange; color: white; padding: 10px;"><code>';
    $footer = '</code></div>';

    if (is_array($value)) {
        foreach ($value as $k => $v) {
            $message .= style_key($k).' => '.style_value($v).'<br>';
        }
    } else {
        $message .= style_value($value ?: 'null');
    }

    $message .= $footer;

    echo $message;
}
/**
 * Dump and die
 *
 * @param  string|array<string,string>  $value
 */
function dd(string|array $value): never
{
    d($value);
    exit;
}

function get_app_path(): ?string
{
    return Config::get('app_path');
}
function get_base_path(): ?string
{
    return Config::get('base_path');
}

/**
 * @param  array<string,mixed>  $array
 */
function get_val(array $array, string $key, mixed $default = null): mixed
{
    if (array_key_exists($key, $array)) {
        return $array[$key];
    }

    return $default;
}
