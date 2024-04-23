<?php

namespace Src\Model;

class User {
    public $number;
    public $name;
    public $sent = 0;

    public function __construct($number, $name) {
        $this->number = $number;
        $this->name = $name;
        $this->sent = 0;
    }
}
