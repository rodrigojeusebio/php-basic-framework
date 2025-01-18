<?php

declare(strict_types=1);

namespace Core;

use Libs\Singleton;

final class Render extends Singleton
{
    /**
     * @param  array<string,mixed>  $variables
     */
    public static function view(string $path, array $variables = []): never
    {
        $render = self::get_instance();
        extract($variables);
        $template_path = get_app_path().'Resources/Views/'.$path.'.php';
        include_once $template_path;
        exit;
    }
}
