<?php

namespace App\Controllers;

use App\Core\Https\Request;
use App\Core\Https\Response;
use App\Models\TodoModel;

class TodoController {
    private $model;

    public function __construct() {
        $this->model = new TodoModel();
    }

    public function post(Request $request, Response $response) {
        $this->model->insertTodo($request->getBody()['todo-name']);
        $response->redirect(BASE_URL);
    }

    public function delete(Request $request, Response $response) {
        $this->model->deleteTodo($request->getParams()['id']);
        $response->redirect(BASE_URL);
    }

    public function selectAll(Request $request, Response $response) {
        $response->json(
            $this->model->selectAllTodo()
        );
    }
}