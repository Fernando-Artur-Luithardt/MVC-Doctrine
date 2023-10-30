<?php

use Controllers\IndexController;
use Controllers\PessoasController;
use Controllers\ContatosController;

require 'vendor/autoload.php';

$request = $_SERVER['REQUEST_URI'];
$baseDir = '/MVCDoctrine';
$parsedUrl = parse_url($request);
$getParams = parse_url($request, PHP_URL_QUERY);

$request = str_replace($baseDir, '', $request);
$request = str_replace('/index.php', '', $request);
if(!empty($parsedUrl['query'])){
    parse_str($parsedUrl['query'], $queryParameters);
    $request = str_replace('?'.$parsedUrl['query'], '', $request);
}

switch ($request) {
    case '/':
        require 'Controllers/IndexController.php';
        $controller = new IndexController();
        $controller->index();
        break;


    case '/pessoas/insertPessoa':
        require 'Controllers/PessoasController.php';
        $controller = new PessoasController();
        $controller->insertPessoa();
        break;
    case '/pessoas/removerPessoa':
        require 'Controllers/PessoasController.php';
        $controller = new PessoasController();
        $controller->removerPessoa($queryParameters);
        break;
    case '/pessoas/getPessoas':
        require 'Controllers/PessoasController.php';
        $controller = new PessoasController();
        $controller->getPessoas($queryParameters['filter']);
        break;
    case '/pessoas/editPessoa':
        require 'Controllers/PessoasController.php';
        $controller = new PessoasController();
        $controller->editPessoa();
        break;


    case '/contatos/removerContato':
        require 'Controllers/ContatosController.php';
        $controller = new ContatosController();
        $controller->removerContato($queryParameters);
        break;
    case '/contatos/getContatos':
        require 'Controllers/ContatosController.php';
        $controller = new ContatosController();
        $controller->getContatos($queryParameters);
        break;
    case '/contatos/insertContato':
        require 'Controllers/ContatosController.php';
        $controller = new ContatosController();
        $controller->insertContato();
        break;
    case '/contatos/editContato':
        require 'Controllers/ContatosController.php';
        $controller = new ContatosController();
        $controller->editContato();
        break;


    default:
        http_response_code(404);
        echo 'Página não encontrada';
        break;
}
