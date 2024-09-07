<?php
namespace Core;
use Core\Router;
use App\Controllers\User;


$router = new Router();

$router->get('/users', User::class, 'index');

$path_info = $_SERVER['PATH_INFO'];

$method = 'GET';
try
{
    $router->route($path_info, $method);
}
catch (\Exception $e)
{
    d($e->getMessage());
}