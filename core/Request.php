<?php

namespace core;

use stdClass;

class Request {
    use UrlEngine;

    private $data;

    public function __construct() {
        $this->data = new stdClass;
        $this->setData();
    }

    private function setData() {
        foreach ($_REQUEST as $key => $value) {
            if ($this->method() === 'get') {
                //this makes is dynamically available
                $this->$key = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                //this collects it
                $this->data->$key = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            } else if ($this->method() === 'post') {
                foreach ($_POST as $key => $value) {
                    $this->$key = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    $this->data->$key = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            } else {
                $this->$key = $value;
                $this->data->$key = $value;
            }
        }
    }

    public function data($x = null) {
        return $x ? $this->data->$x : $this->data;
    }
}