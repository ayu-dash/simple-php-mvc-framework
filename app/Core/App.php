<?php

namespace App\Core;

use App\Core\Https\Request;
use App\Core\Https\Response;
use App\Core\Https\Router;
use App\Core\Parsers\MultipartBodyParser;
use App\Core\Parsers\QueryParser;

class App {
    public Router $router;
    public Request $request;
    public Response $response;

    public function __construct()
    {
        $this->request = new Request(new MultipartBodyParser(), new QueryParser());
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run() {
        $this->router->dispatch();
    }
}