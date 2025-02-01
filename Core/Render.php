<?php

declare(strict_types=1);

namespace Core;

use Libs\BasicTemplater;
use Libs\Singleton;
use RuntimeException;

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
    public static function view(string $path, array $variables = []): void
    {
        extract($variables);
        $default_layout = 'layouts/default';
        self::page(
            $default_layout,
            array_merge(['__view' => $path], $variables)
        );
    }

    /**
     * @param  array<string,mixed>  $variables
     */
    public static function page(string $path, array $variables = []): void
    {
        $render = self::get_instance();
        extract(self::$global_variables);
        extract($variables);
        $template_path = BasicTemplater::get_view_path($path);
        $compile_view = BasicTemplater::compile($template_path);
        include $compile_view;
    }
}
