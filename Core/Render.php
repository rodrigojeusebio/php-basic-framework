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

    private static array $supported_syntax = [
        '{{',
        '@auth',
        '@endauth',
        '@guest',
        '@endguest',
        '@else',
        '@component',
        '@foreach',
        '@endforeach'
    ];

    /**
     * @param  array<string,mixed>  $variables
     */
    public static function view(string $path, array $variables = []): void
    {
        extract($variables);
        $template_path = self::get_view_path($path);
        $default_layout = 'layouts/default';
        self::page(
            $default_layout,
            array_merge(['__view' => $template_path], $variables)
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
        $template_path = self::get_view_path($path);
        $compile_view = self::compile($template_path);
        include $compile_view;
    }

    private static function get_view_path(string $path): string
    {
        return get_app_path() . 'Resources/Views/' . $path . '.basic.php';
    }

    private static function compile(string $template_path): string
    {
        $contents_file = explode("\n", (string) file_get_contents($template_path));

        foreach ($contents_file as $line) {
            $processed_lines = self::process_line($line);
        }

        return '';
    }

    private static function process_line(string $line): string
    {
        return $line;
    }
}
