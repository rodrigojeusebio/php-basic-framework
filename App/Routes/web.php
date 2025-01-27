<?php

declare(strict_types=1);

use App\Controllers\Controller;
use App\Controllers\User_Controller;
use Core\Router;

Router::get('/', [Controller::class, 'home']);

// Users Resource
Router::get('/users/create', [User_Controller::class, 'create'])->only('auth');
Router::get('/users/{:id}', [User_Controller::class, 'show'])->only('auth');
Router::patch('/users/{:id}', [User_Controller::class, 'update'])->only('auth');
Router::get('/users/{:id}/edit', [User_Controller::class, 'edit'])->only('auth');
Router::delete('/users/{:id}', [User_Controller::class, 'destroy'])->only('auth');
Router::get('/users', [User_Controller::class, 'index'])->only('auth');
Router::post('/users', [User_Controller::class, 'store'])->only('auth');
