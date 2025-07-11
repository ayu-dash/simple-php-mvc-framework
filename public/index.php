<?php

use App\Controllers\HomeController;
use App\Controllers\TodoController;
use App\Core\App;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Config/Config.php';

$app = new App();

$app->router->get('/', [HomeController::class, 'index']);
$app->router->get('/get-todo', [TodoController::class, 'selectAll']);
$app->router->post('/post-todo', [TodoController::class, 'post']);
$app->router->get('/delete-todo/:id', [TodoController::class, 'delete']);

$app->run();