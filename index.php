<?php
require 'vendor/autoload.php';

$request = $_SERVER['REQUEST_URI'];
$baseDir = '/MVCDoctrine';
$request = str_replace($baseDir, '', $request);

switch ($request) {
    case '/':
        require 'controllers/IndexController.php';
        $controller = new IndexController();
        $controller->index();
        break;
    case '/insert':
        require 'controllers/IndexController.php';
        $controller = new IndexController();
        $controller->insert();
        break;
    default:
        http_response_code(404);
        echo 'Página no encontrada';
        break;
}
