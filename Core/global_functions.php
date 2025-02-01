<?php

declare(strict_types=1);

use Core\Config;
use Core\Session;

function style_key(string $key): string
{
    return "<span style=\"color: green; font-weight: bold\">$key</span>";
}

function style_value(string $value): string
{
    return "<span style=\"color: orange; \">$value</span>";
}

function d(mixed $value): void
{
    echo $message = '<div style="background-color: black; border: 2px solid orange; color: white; padding: 10px;"><pre>';

    var_dump($value);

    echo $footer = '</pre></div>';

}
/**
 * Dump and die
 */
function dd(mixed $value): never
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
 * @template Tvalue
 *
 * @param  array<string,Tvalue>|array<Tvalue>  $array
 * @return Tvalue
 */
function get_val(array $array, string|int $key, mixed $default = null): mixed
{
    if (array_key_exists($key, $array)) {
        return $array[$key];
    }

    return $default;
}

function old(string $key, mixed $default = ''): mixed
{
    $flash = get_val(Session::get_flash(), 'values', []);

    return get_val($flash, $key, $default);
}

/**
 * @return array<string,string>
 */
function errors(string $key): array
{
    $flash = get_val(Session::get_flash(), 'errors', []);

    return get_val($flash, $key, []);
}
