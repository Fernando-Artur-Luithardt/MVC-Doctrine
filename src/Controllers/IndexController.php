<?php

namespace Controllers;

use Models\Contato;
use Models\Pessoa;

class IndexController
{
    public function index()
    {
        require 'views/index/index.php';
    }
}