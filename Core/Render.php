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
    public static function view(string $path, array $variables = []): void
    {
        extract($variables);
        $template_path = self::get_view_path($path);
        $default_layout = 'layouts/default';
        self::page($default_layout, array_merge(['__view' => $template_path], $variables));
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
        $compiled_file = self::compile_template($template_path);

        include_once $compiled_file;
    }

    private static function get_view_path(string $path): string
    {
        return get_app_path() . 'Resources/Views/' . $path . '.php';
    }
    public static function compile_template(string $template_path): string
    {
        $cache_dir = __DIR__ . "/cache/"; // Directory for cached files

        if (!is_dir($cache_dir)) {
            mkdir($cache_dir, 0777, true);
        }

        include_once $template_path;
        $contents = ob_get_contents() ?: '';
        $compiled_php = self::viewToPhp($contents);
        ob_clean();
        // Create a unique cache file
        $cache_file = $cache_dir . md5($template_path) . '.php';

        file_put_contents($cache_file, $compiled_php);

        return $cache_file;
    }

    public static function viewToPhp(string $contents): string
    {
        $patterns = [
            // Control structures
            '/@if\((.*?)\)/' => '<?php if ($1): ?>',
            '/@else/' => '<?php else: ?>',
            '/@endif/' => '<?php endif; ?>',

            '/@for\((.*?)\)/' => '<?php for ($1): ?>',
            '/@endfor/' => '<?php endfor; ?>',

            '/@foreach\(([^,]+),\s*([^,]+),\s*([^)]+)\)/' => '<?php foreach ($1 as $2 => $3): ?>',
            '/@foreach\(([^,]+),\s*([^)]+)\)/' => '<?php foreach ($1 as $2): ?>',
            '/@endforeach/' => '<?php endforeach; ?>',

            '/@auth/' => '<?php use Libs\Auth; if (Auth::check()): ?>',
            '/@guest/' => '<?php use Libs\Auth; if (Auth::guest()): ?>',
            '/@endauth|@endguest/' => '<?php endif; ?>',

            // Component system
            '/@component\(\s*[\'"](.+?)[\'"]\s*,\s*(\[.*?\])\s*\)/' =>
                '<?php extract($2); component($1)"; ?>',
            '/@component\(\s*[\'"](.+?)[\'"]\s*\)/' =>
                '<?php components($1)"; ?>',
            '/@endcomponent/' => '',

            // Old input retrieval
            '/@old\(\s*[\'"](.+?)[\'"]\s*,\s*[\'"](.+?)[\'"]\s*\)/' =>
                '<?= htmlspecialchars(old("$1", "$2")) ?>',
            '/@old\(\s*[\'"](.+?)[\'"]\s*\)/' =>
                '<?= htmlspecialchars(old("$1", "")) ?>',

            // Error handling
            '/@errors\(\s*[\'"](.+?)[\'"]\s*\)/' =>
                '<?php foreach (errors("$1") as $error): ?>',
            '/@error/' => '<?= htmlspecialchars($error) ?>',
            '/@enderrors/' => '<?php endforeach; ?>',

            // Handle {{ $value }} escaping
            '/{{\s*(?!\!)(.*?)\s*}}/' => '<?= htmlspecialchars($1) ?>',

            // Handle {{ ! $value ! }} raw output
            '/{{\s*\!(.*?)\!\s*}}/' => '<?= $1 ?>',
        ];

        return (string) preg_replace(array_keys($patterns), array_values($patterns), $contents);
    }
}
