<?php

declare(strict_types=1);

namespace Core;

use Exception;

// TODO: Check if there are a better way to do this
include_once Config::get('app_path').'Routes/web.php';

/** @var string */
$path_info = $_SERVER['REQUEST_URI'];

/** @var string */
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$method = HttpMethod::from(mb_strtoupper($method));
Router::route($path_info, $method);
