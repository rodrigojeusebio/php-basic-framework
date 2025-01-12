<?php

namespace Core;
use Libs\Singleton;

final class Render extends Singleton
{
    public static function view(string $path, array $variables = [])
    {
        $render = self::get_instance();
        extract($variables);
        $template_path = get_app_path().'Resources/Views/'.$path.'.php';
        include_once $template_path;
        die;
    }
}