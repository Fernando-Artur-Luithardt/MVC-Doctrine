<?php
require 'vendor/autoload.php';

$request = $_SERVER['REQUEST_URI'];
$baseDir = '/MVCDoctrine';

$parsedUrl = parse_url($request);

$getParams = parse_url($request, PHP_URL_QUERY);

$request = str_replace($baseDir, '', $request);
if(!empty($parsedUrl['query'])){
    parse_str($parsedUrl['query'], $queryParameters);
    $request = str_replace('?'.$parsedUrl['query'], '', $request);
}

switch ($request) {
    case '/':
        require 'controllers/IndexController.php';
        $controller = new IndexController();
        $controller->index();
        break;
    case '/insertPessoa':
        require 'controllers/IndexController.php';
        $controller = new IndexController();
        $controller->insertPessoa();
        break;
    case '/removerPessoa':
        require 'controllers/IndexController.php';
        $controller = new IndexController();
        $controller->removerPessoa($queryParameters);
        break;
    case '/getPessoas':
        require 'controllers/IndexController.php';
        $controller = new IndexController();
        $controller->getPessoas();
        break;
    case '/getContatos':
        require 'controllers/IndexController.php';
        $controller = new IndexController();
        $controller->getContatos($queryParameters);
        break;
    default:
        http_response_code(404);
        echo 'Página no encontrada';
        break;
}
