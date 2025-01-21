<?php

declare(strict_types=1);

namespace Core;

// TODO: Check if there are a better way to do this
include_once Config::get('app_path').'Routes/web.php';

Router::route(Request::uri(), Request::method());
