<?php

namespace App\Controllers;

use App\Core\Https\Request;
use App\Core\Https\Response;
use App\Core\View;
use App\Models\TodoModel;

class HomeController {
    private $model;

    public function __construct() {
        $this->model = new TodoModel();
    }

    public function index(Request $request, Response $response) {
        $items = $this->model->selectAllTodo();
        $response->html(View::render('home', ['items' => $items]));
    }
}