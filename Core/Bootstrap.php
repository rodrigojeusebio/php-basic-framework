<?php
namespace Core;
use Core\Router;
use Core\HttpMethod;

include_once Config::get('app_path').'Routes/web.php';

$path_info = $_SERVER['REQUEST_URI'];

$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

try
{
    $method = HttpMethod::tryFrom(strtoupper($method));
    Router::route($path_info, $method);
}
catch (\Exception $e)
{
    d($e->getMessage());
}