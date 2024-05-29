<?php

declare(strict_types=1);

return [
    // Person
    'POST|/api/user' => App\Controllers\People\RegisterController::class,
    'GET|/api/user' => App\Controllers\People\ListController::class,
    'GET|/api/user/{id}' => App\Controllers\People\ShowController::class,
    'PUT|/api/user/{id}' => App\Controllers\People\UpdateController::class,
    'DELETE|/api/user/{id}' => App\Controllers\People\DeleteController::class,

    'POST|/api/contact' => App\Controllers\Contact\RegisterController::class,
    'GET|/api/contact' => App\Controllers\Contact\ListController::class,
    'GET|/api/contact/{id}' => App\Controllers\Contact\ShowController::class,
    'PUT|/api/contact/{id}' => App\Controllers\Contact\UpdateController::class,
    'DELETE|/api/contact/{id}' => App\Controllers\Contact\DeleteController::class,
];