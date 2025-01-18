<?php

declare(strict_types=1);
use Core\Config;
use Core\ErrorHandler;
use Core\ExceptionHandler;

// Composer autoload
require dirname(__FILE__).'/vendor/autoload.php';

// Define handlers
set_error_handler([ErrorHandler::class, 'handler']);
set_exception_handler([ExceptionHandler::class, 'handler']);

// Get config
require dirname(__FILE__).'/Core/Config.php';

// Load .env variables
Config::load_env(dirname(__FILE__).'/.env');

// Set usefull paths
Config::set('base_path', dirname(__FILE__).'/');
Config::set('app_path', Config::get('base_path').'/App/');

// Set global functions
require_once dirname(__FILE__).'/Core/global_functions.php';

// Start framework
require dirname(__FILE__).'/Core/Bootstrap.php';
