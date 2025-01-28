<?php

declare(strict_types=1);

namespace Core;

final class Request
{
    public static function uri(): string
    {
        $uri = get_val($_SERVER, 'PATH_INFO', get_val($_SERVER, 'REQUEST_URI', '/'));

        if (is_string($uri)) {
            return mb_strtolower($uri);
        }

        return '/';
    }

    /**
     * @return array<mixed>
     */
    public static function parameters(): array
    {
        return $_GET;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return get_val($_GET, $key, $default);
    }

    /**
     * Get the method of the request, via REQUEST_METHOD or _method attribute
     *
     * @throws App_Exception
     */
    public static function method(): HttpMethod
    {
        $method = self::attributes()['_method'] ?? $_SERVER['REQUEST_METHOD'];

        if (is_string($method)) {
            $method = HttpMethod::from(mb_strtoupper($method));

            return $method;
        }

        throw new App_Exception('error', 'Method is not valid', ['method' => $method]);
    }

    /**
     * Get the post attributes
     *
     * @return array<mixed>
     */
    public static function attributes(): array
    {
        return $_POST;
    }

    /**
     * Redirects the user to other page
     *
     * @param  array<string,mixed>  $flash_values
     */
    public static function redirect(string $url, array $flash_values = []): never
    {
        ob_clean();
        foreach ($flash_values as $key => $value) {
            Session::flash($key, $value);
        }
        header("Location: $url", true, 303);
        exit;
    }

    public static function unauthorized(): never
    {
        Render::page('default_pages/401');
        exit;
    }
}
