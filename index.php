<?php
use Core\Config;

require dirname(__FILE__).'/vendor/autoload.php';
require dirname(__FILE__)."/Core/Config.php";
Config::load_env(dirname(__FILE__).'/.env');
Config::set('base_path', dirname(__FILE__).'/');
Config::set('app_path', Config::get('base_path')."/App/");
require_once dirname(__FILE__)."/Core/global_functions.php";

require dirname(__FILE__)."/Core/Bootstrap.php";

