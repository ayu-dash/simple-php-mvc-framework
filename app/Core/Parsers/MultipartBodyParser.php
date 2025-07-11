<?php

namespace App\Core\Parsers;

class MultipartBodyParser implements BodyParserInterface {
    public function parse()
    {
        return $_POST;
    }
}