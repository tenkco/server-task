<?php
use Src\Route;

// гость
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

// оборудование
Route::add('GET', '/equipment', [Controller\LabController::class, 'index'])->middleware('auth');
Route::add('GET', '/equipment/show/{id}', [Controller\EquipmentController::class, 'show'])->middleware('auth');
Route::add(['GET', 'POST'], '/equipment/set-responsible/{id}', [Controller\EquipmentController::class, 'setResponsible'])->middleware('admin');

// история ремонтов
Route::add(['GET', 'POST'], '/repair/create/{id}', [Controller\LabController::class, 'createRepair'])->middleware('auth');

// отчёт
Route::add('GET', '/report', [Controller\LabController::class, 'report'])->middleware('auth');

// админ управление оборудованием
Route::add(['GET', 'POST'], '/equipment/create', [Controller\AdminController::class, 'create'])->middleware('admin');
Route::add(['GET', 'POST'], '/equipment/set-status/{id}', [Controller\EquipmentController::class, 'setStatus'])
    ->middleware('admin');

// админ добавление пользователей
Route::add(['GET', 'POST'], '/admin/users', [Controller\AdminController::class, 'addUser'])->middleware('admin');

