<?php
return [
    //Класс аутентификации
    'auth' => \Src\Auth\Auth::class,
    //Клас пользователя
    'identity' => \Model\Employee::class,
    //Классы для middleware
    'routeMiddleware' => [
    'auth' => \Middlewares\AuthMiddleware::class,
    'admin' => \Middlewares\AdminMiddleware::class,
    ],
];
