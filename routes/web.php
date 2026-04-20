<?php
use Src\Route;

// гость авторизация
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

// лаборант
Route::add('GET', '/equipment', [Controller\LabController::class, 'index'])
    ->middleware('auth');

//история ремонтов
Route::add(['GET', 'POST'], '/repair', [Controller\LabController::class, 'repair'])
    ->middleware('auth');

//отчет
Route::add('GET', '/report', [Controller\LabController::class, 'report'])
    ->middleware('auth');

// админ
Route::add(['GET', 'POST'], '/admin/equipment', [Controller\AdminController::class, 'manage'])
    ->middleware('admin');