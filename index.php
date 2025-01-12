<?php
use Core\Config;

require dirname(__FILE__).'/vendor/autoload.php';
require dirname(__FILE__)."/Core/Config.php";

Config::set('app_path', dirname(__FILE__)."/App/");
require_once dirname(__FILE__)."/Core/global_functions.php";

require dirname(__FILE__)."/Core/Bootstrap.php";

