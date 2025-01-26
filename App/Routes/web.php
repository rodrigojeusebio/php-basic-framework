<?php

declare(strict_types=1);

use App\Controllers\Controller;
use App\Controllers\User_Controller;
use Core\Router;

Router::get('/', [Controller::class, 'home']);

// Users Resource
Router::get('/users/create', [User_Controller::class, 'create']);
Router::get('/users/{:id}', [User_Controller::class, 'show']);
Router::patch('/users/{:id}', [User_Controller::class, 'update']);
Router::get('/users/{:id}/edit', [User_Controller::class, 'edit']);
Router::delete('/users/{:id}', [User_Controller::class, 'destroy']);
Router::get('/users', [User_Controller::class, 'index']);
Router::post('/users', [User_Controller::class, 'store']);
