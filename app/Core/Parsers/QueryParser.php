<?php

namespace App\Core\Parsers;

class QueryParser {
    public function parse() {
        $queryString = $_SERVER['QUERY_STRING'];
        if($queryString) {
            parse_str($_SERVER['QUERY_STRING'], $query);
            if(array_key_exists('url', $query)) unset($query['url']);
            
            return $query;
        }

        return [];
    }
}