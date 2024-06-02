<?php

declare(strict_types=1);

return [
    // Person
    'POST|/api/person' => App\Controllers\People\RegisterController::class,
    'GET|/api/person' => App\Controllers\People\ListController::class,
    'GET|/api/person/{id}' => App\Controllers\People\ShowController::class,
    'PUT|/api/person/{id}' => App\Controllers\People\UpdateController::class,
    'DELETE|/api/person/{id}' => App\Controllers\People\DeleteController::class,

    'POST|/api/contact' => App\Controllers\Contact\RegisterController::class,
    'GET|/api/contact' => App\Controllers\Contact\ListController::class,
    'GET|/api/contact/{id}' => App\Controllers\Contact\ShowController::class,
    'PUT|/api/contact/{id}' => App\Controllers\Contact\UpdateController::class,
    'DELETE|/api/contact/{id}' => App\Controllers\Contact\DeleteController::class,
];