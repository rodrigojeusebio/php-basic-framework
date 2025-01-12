<?php

use Core\Config;

function style_key($key)
{
    return "<span style=\"color: green; font-weight: bold\">$key</span>";
}

function style_value($value)
{
    return "<span style=\"color: orange; \">$value</span>";
}
function d($value)
{


    $message = '<div style="background-color: black; border: 2px solid orange; color: white; padding: 10px;"><code>';
    $footer  = '</code></div>';

    if (is_array($value))
    {
        foreach ($value as $k => $v)
        {
            $message .= style_key($k).' => '.style_value($v).'<br>';
        }
    }
    else
    {
        $message .= style_value($value ?? 'null');
    }

    $message .= $footer;

    echo $message;
}
function dd($value)
{
    d($value);
    die;
}

function get_app_path()
{
    return Config::get('app_path');
}