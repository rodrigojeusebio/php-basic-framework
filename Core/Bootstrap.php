<?php
namespace Core;
use Core\Router;
use Core\HttpMethod;
use App\Controllers\User;

Router::get('/users/{:id}', User::class, 'show');
Router::get('/users', User::class, 'index');

$path_info = $_SERVER['REQUEST_URI'];

$method = $_SERVER[''] ?? $_SERVER['REQUEST_METHOD'];

try
{
    $method = HttpMethod::tryFrom($method);
    Router::route($path_info, $method);
}
catch (\Exception $e)
{
    d($e->getMessage());
}