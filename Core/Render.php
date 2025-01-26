<?php

declare(strict_types=1);

namespace Core;

use Libs\Singleton;

final class Render extends Singleton
{
    /**
     * Variables that will always be set on the view
     *
     * @var array<string,mixed>
     */
    private static array $global_variables = ['errors' => [], 'attributes' => []];

    /**
     * @param  array<string,mixed>  $variables
     */
    public static function view(string $path, array $variables = []): never
    {
        extract($variables);
        $template_path = self::get_view_path($path);
        $default_layout = 'layouts/default';
        self::page($default_layout, array_merge(['__view' => $template_path], $variables));
    }

    /**
     * @param  array<string,mixed>  $variables
     */
    public static function page(string $path, array $variables = []): never
    {
        $render = self::get_instance();
        extract(self::$global_variables);
        extract($variables);
        $template_path = self::get_view_path($path);
        include_once $template_path;
        exit;
    }

    private static function get_view_path(string $path): string
    {
        return get_app_path().'Resources/Views/'.$path.'.php';
    }
}
