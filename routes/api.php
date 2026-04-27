<?php
use Src\Route;

Route::add('POST', '/auth/login', [Controller\Api\AuthController::class, 'login']);

Route::add('POST', '/users', [Controller\Api\UserController::class, 'store'])
    ->middleware('api.token');

Route::add('GET', '/users', [Controller\Api\UserController::class, 'index'])
    ->middleware('api.token');