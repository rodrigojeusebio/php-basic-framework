<?php

declare(strict_types=1);

namespace Core;

use Libs\Singleton;

final class Render extends Singleton
{
    /**
     * Global variables available in all views.
     *
     * @var array<string, mixed>
     */
    private static array $global_variables = ['errors' => [], 'attributes' => []];

    /**
     * Render a view inside the default layout.
     *
     * @param string $path
     * @param array<string, mixed> $variables
     */
    public static function view(string $path, array $variables = []): void
    {
        $default_layout = 'layouts/default';
        self::page($default_layout, array_merge(['__view' => $path], $variables));
    }

    /**
     * Render a full page.
     *
     * @param string $path
     * @param array<string, mixed> $variables
     */
    public static function page(string $path, array $variables = []): void
    {
        extract(self::$global_variables);
        extract($variables);

        $template_path = self::get_view_path($path);
        $compiled_file = self::compile_template($template_path);

        ob_clean();
        ob_start();
        include $compiled_file;
        ob_end_flush();
    }

    /**
     * Resolve a view path to its full file path.
     */
    private static function get_view_path(string $path): string
    {
        return get_app_path() . 'Resources/Views/' . $path . '.php';
    }

    /**
     * Convert a template into a compiled PHP file.
     */
    public static function compile_template(string $template_path): string
    {
        $cache_dir = __DIR__ . "/cache/";

        if (!is_dir($cache_dir)) {
            mkdir($cache_dir, 0777, true);
        }

        $template = file_get_contents($template_path) ?: '';
        $compiled_php = self::viewToPhp($template);

        $cache_file = $cache_dir . md5_file($template_path) . '.php';
        file_put_contents($cache_file, $compiled_php);

        return $cache_file;
    }

    /**
     * Convert Blade-like syntax into PHP.
     */
    public static function viewToPhp(string $template): string
    {
        $patterns = [
            // Control Structures
            '/@if\s*\((.*?)\)/' => '<?php if ($1): ?>',
            '/@else/' => '<?php else: ?>',
            '/@endif/' => '<?php endif; ?>',
            '/@foreach\s*\((.*?)\)/' => '<?php foreach ($1): ?>',
            '/@endforeach/' => '<?php endforeach; ?>',
            '/@for\s*\((.*?)\)/' => '<?php for ($1): ?>',
            '/@endfor/' => '<?php endfor; ?>',
            '/@auth/' => '<?php if (Auth::check()): ?>',
            '/@guest/' => '<?php if (Auth::guest()): ?>',
            '/@endauth|@endguest/' => '<?php endif; ?>',

            // Include - Support both strings and variables
            '/@include\(\s*[\'"](.+?)[\'"]\s*\)/' =>
                '<?php include Render::compile_template(Render::get_view_path("$1")); ?>',
            '/@include\(\s*(.*?)\s*\)/' =>
                '<?php include Render::compile_template($1); ?>',

            // Component System
            '/@component\(\s*[\'"](.+?)[\'"]\s*,\s*(\[.*?\])\s*\)/' =>
                '<?php extract($2); component("$1"); ?>',
            '/@component\(\s*[\'"](.+?)[\'"]\s*\)/' =>
                '<?php component("$1"); ?>',
            '/@endcomponent/' => '',

            // Old Input Handling
            '/@old\(\s*[\'"](.+?)[\'"]\s*,\s*[\'"](.+?)[\'"]\s*\)/' =>
                '<?= htmlspecialchars(old("$1", "$2")) ?>',
            '/@old\(\s*[\'"](.+?)[\'"]\s*\)/' =>
                '<?= htmlspecialchars(old("$1", "")) ?>',

            // Error Handling
            '/@errors\(\s*[\'"](.+?)[\'"]\s*\)/' =>
                '<?php foreach (errors("$1") as $error): ?>',
            '/@error/' => '<?= htmlspecialchars($error) ?>',
            '/@enderrors/' => '<?php endforeach; ?>',

            // Form Method Spoofing
            '/@method\((.*?)\)/' => '<input type="hidden" name="_method" value="<?= $1 ?>">',

            // Variable Output
            '/{{\s*(?!\!)(.*?)\s*}}/' => '<?= htmlspecialchars($1) ?>', // Escaped output
            '/{{\s*\!(.*?)\!\s*}}/' => '<?= $1 ?>', // Raw output
        ];

        return "<?php use Libs\Auth; use Core\Request; use Core\Render; ?>" .
            preg_replace(array_keys($patterns), array_values($patterns), $template);
    }
}

