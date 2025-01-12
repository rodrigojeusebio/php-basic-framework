<?php

use App\Controllers\User_Controller;
use Core\Router;



Router::get('/users/create', User_Controller::class, 'create');
Router::get('/users/{:id}', User_Controller::class, 'show');
Router::delete('/users/{:id}', User_Controller::class, 'delete');
Router::get('/users', User_Controller::class, 'index');
Router::post('/users', User_Controller::class, 'store');