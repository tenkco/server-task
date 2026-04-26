<?php
return [
    //Класс аутентификации
    'auth' => \Tenkco\Auth\Auth::class,
    //Клас пользователя
    'identity' => \Model\Employee::class,
    //Классы для middleware
    'routeMiddleware' => [
    'auth' => \Tenkco\Auth\AuthMiddleware::class,
    'admin' => \Middlewares\AdminMiddleware::class,
    ],
    'validators' => [
        'required' => \Validators\RequireValidator::class,
        'unique' => \Validators\UniqueValidator::class
    ],
    'routeAppMiddleware' => [
        'csrf' => \Middlewares\CSRFMiddleware::class,
        'trim' => \Middlewares\TrimMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
    ],
    'providers' => [
        'kernel' => \Providers\KernelProvider::class,
        'route' => \Providers\RouteProvider::class,
        'db' => \Providers\DBProvider::class,
        'auth' => \Providers\AuthProvider::class,
    ],



];
