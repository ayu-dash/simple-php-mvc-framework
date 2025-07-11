<?php

namespace App\Core\Https;

use App\Core\Parsers\BodyParserInterface;
use App\Core\Parsers\QueryParser;

class Request {
    private BodyParserInterface $bodyParser;
    private array $query;
    private array $params;
    private array $cookies;
    private string $method;
    private string $route;
    private array $headers;
    private $body;

    public function __construct(BodyParserInterface $bodyParser, QueryParser $queryParser)
    {
        $this->bodyParser = $bodyParser;
        $this->query = $queryParser->parse();
        $this->setMethod();
        $this->setRoute();
        $this->setHeaders();
        $this->setCookie();
    }

    // SETTER
    public function setBodyParser(BodyParserInterface $bodyParser) {
        $this->bodyParser = $bodyParser;
    }

    public function setMethod() {
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function setRoute() {
        $route = $_GET['url'] ?? '/';
        $route = '/' . rtrim(filter_var($route, FILTER_SANITIZE_URL), '/');

        $this->route = $route;
    }

    public function setParams($params) {
        $this->params = $params;
    }

    public function setHeaders() {
        $this->headers = getallheaders();
    }

    public function setCookie() {
        $this->cookies = $_COOKIE;
    }

    // GETTER
    public function getMethod() {
        return $this->method;
    }

    public function getRoute() {
        return $this->route;
    }

    public function getParams() {
        return $this->params;
    }

    public function getCookies() {
        return $this->cookies;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getQuery() {
        return $this->query;
    }

    public function getBody() {
        if ($this->body === null) {
            $this->body = $this->bodyParser->parse();
        }
        return $this->body;
    }
}