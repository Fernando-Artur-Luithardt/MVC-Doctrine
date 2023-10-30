<?php

namespace Controllers;

class IndexController
{
    public function index(): void
    {
        require 'views/index/index.php';
    }
}