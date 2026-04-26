<?php
use Src\Route;

Route::add('POST', '/auth/login', [Controller\Api\AuthController::class, 'login']);
Route::add('POST', '/auth/logout', [Controller\Api\AuthController::class, 'logout'])
    ->middleware('api.token');

Route::add('GET', '/users', [Controller\Api\UserController::class, 'index'])
    ->middleware('api.token');

Route::add('POST', '/users', [Controller\Api\UserController::class, 'store'])
    ->middleware('api.token');