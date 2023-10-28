<?php
require_once 'models/Pessoa.php';

class IndexController {
    private $pessoa;
    
    public function __construct() {
        $this->pessoa = new \Models\Pessoa();
    }

    public function index() {
        require 'views/index/index.php';
    }

    public function insert() {
        $params = $_POST;
        // require 'views/index/index.php';

        foreach ($params as $column => $value) {
            if (is_callable([$this->pessoa, 'set' . $column])) {
                $value = str_replace(['.', '-'], '', $value);
                $this->pessoa->{'set' . $column}($value);
            }
        }
        $this->pessoa->insert();
        exit;
    }
}