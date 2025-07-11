<?php

namespace App\Core\Parsers;

class JsonBodyParser implements BodyParserInterface {
    public function parse() {
        return json_decode(file_get_contents('php://input'));
    }
}