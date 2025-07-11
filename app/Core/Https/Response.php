<?php

namespace App\Core\Https;

class Response {
    public function setStatusCode($code) {
        http_response_code($code);
        return $this;
    }

    public function setCookie($name, $value, $options = null) {
        setcookie(
            $name,
            $value,
            $options['expires'] ?? 0,
            $options['path'] ?? '/',
            $options['domain'] ?? '',
            $options['secure'] ?? false,
            $options['httponly'] ?? true
        );

        return $this;
    }

    public function setHeaders($headers) {
        foreach ($headers as $key => $value) {
            header("$key: $value");
        }

        return $this;
    }

    public function redirect($url) {
        header('Location: ' . $url);
        exit;
    }

    public function json($data) {
        $this->setHeaders(['Content-Type' => 'application/json']);
        echo json_encode($data);
        exit;
    }

    public function html($html) {
        $this->setHeaders(['Content-Type' => 'text/html']);
        echo $html;
        exit;
    }
}