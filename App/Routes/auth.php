<?php

declare(strict_types=1);

use App\Controllers\Auth\Login_Controller;
use App\Controllers\Auth\Logout_Controller;
use App\Controllers\Auth\Register_Controller;
use Core\Router;

// Register
Router::get('/register', [Register_Controller::class, 'create'])->only('guest');
Router::post('/register', [Register_Controller::class, 'store'])->only('guest');

// Login
Router::get('/login', [Login_Controller::class, 'create'])->only('guest');
Router::post('/login', [Login_Controller::class, 'store'])->only('guest');

// Log out
Router::delete('/logout', [Logout_Controller::class, 'destroy'])->only('auth');
