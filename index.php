<?php
require_once dirname(__FILE__) . "/core/Router.php";
require_once dirname(__FILE__) . "/app/controllers/User.php";
require_once dirname(__FILE__) . "/core/global_functions.php";
use Core\Router;
use App\Controllers\User;


$router = new Router();

$router->get('/users', User::class, 'index');

$path_info = $_SERVER['PATH_INFO'];
$method = 'GET';
$router->route($path_info, $method);
// d($path_info);
// dd($_SERVER);
