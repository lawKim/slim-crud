<?php 

declare(strict_types=1);

use App\Controllers\UserController;

return function ($app) {
    $app->get('/users[/]', UserController::class . ':index')->setName('users.index');
    $app->get('/users/create[/]', UserController::class . ':create')->setName('users.create');
    $app->post('/users[/]', UserController::class . ':store')->setName('users.store');
    $app->get('/users/{id}/edit[/]', UserController::class . ':edit');
    $app->put('/users/{id}/edit[/]', UserController::class . ':update');
    $app->delete('/users/{id}/delete[/]', UserController::class . ':delete')->setName('users.delete'); 
};
