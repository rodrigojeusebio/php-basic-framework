<?php

declare(strict_types=1);

use App\Controllers\Auth\Login_Controller;
use App\Controllers\Auth\Logout_Controller;
use App\Controllers\Auth\Register_Controller;
use Core\Router;

// Register
Router::get('/register', [Register_Controller::class, 'create']);
Router::post('/register', [Register_Controller::class, 'store']);

// Login
Router::get('/login', [Login_Controller::class, 'create']);
Router::post('/login', [Login_Controller::class, 'store']);

// Log out
Router::delete('/logout', [Logout_Controller::class, 'destroy']);
