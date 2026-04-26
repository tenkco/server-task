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
        'api.token' => \Middlewares\ApiTokenMiddleware::class,
    ],
    'validators' => [
        'required' => \Validators\RequireValidator::class,
        'unique' => \Validators\UniqueValidator::class
    ],
    'providers' => [
        'kernel' => \Src\Provider\KernelProvider::class,
        'route' => \Src\Provider\RouteProvider::class,
        'db' => \Src\Provider\DBProvider::class,
        'auth' => \Src\Provider\AuthProvider::class,
    ],
    'routeAppMiddleware' => [
        'csrf' => \Middlewares\CSRFMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
        'trim' => \Middlewares\TrimMiddleware::class,
        'json' => \Middlewares\JSONMiddleware::class,
    ],



];
