<?php
//IMPORTANTE
//Necessida de um .htaccess na pasta htdocs do xampp que sempre aponte todas as rotas para este index

use Controllers\IndexController;
use Controllers\PessoasController;
use Controllers\ContatosController;

require 'src/vendor/autoload.php';

//Separa os parâmetros da url e limpa o $request para ser utilizado no switch
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
// print_r($request);
// exit;
switch ($request) {
    case '/':
        require 'src/Controllers/IndexController.php';
        $controller = new IndexController();
        $controller->index();
        break;
    case '/pessoas/insertPessoa':
        require 'src/Controllers/PessoasController.php';
        $controller = new PessoasController();
        $controller->insertPessoa();
        break;
    case '/pessoas/removerPessoa':
        require 'src/Controllers/PessoasController.php';
        $controller = new PessoasController();
        $controller->removerPessoa($queryParameters);
        break;
    case '/pessoas/getPessoas':
        require 'src/Controllers/PessoasController.php';
        $controller = new PessoasController();
        $controller->getPessoas($queryParameters['filter']);
        break;
    case '/pessoas/editPessoa':
        require 'src/Controllers/PessoasController.php';
        $controller = new PessoasController();
        $controller->editPessoa();
        break;
    case '/contatos/removerContato':
        require 'src/Controllers/ContatosController.php';
        $controller = new ContatosController();
        $controller->removerContato($queryParameters);
        break;
    case '/contatos/getContatos':
        require 'src/Controllers/ContatosController.php';
        $controller = new ContatosController();
        $controller->getContatos($queryParameters);
        break;
    case '/contatos/insertContato':
        require 'src/Controllers/ContatosController.php';
        $controller = new ContatosController();
        $controller->insertContato();
        break;
    case '/contatos/editContato':
        require 'src/Controllers/ContatosController.php';
        $controller = new ContatosController();
        $controller->editContato();
        break;
    default:
        http_response_code(404);
        echo 'Página no encontrada';
        break;
}