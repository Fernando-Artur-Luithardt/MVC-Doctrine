<?php
require_once 'models/Pessoa.php';
require_once 'models/Contato.php';

class IndexController {
    private $pessoa;
    private $contato;
    
    public function __construct()
    {
        $this->pessoa = new \Models\Pessoa();
        $this->contato = new \Models\Contato();
    }

    public function index()
    {
        require 'views/index/index.php';
    }

    public function insertPessoa()
    {
        $params = $_POST;

        foreach ($params as $column => $value) {
            if (is_callable([$this->pessoa, 'set' . $column])) {
                $value = str_replace(['.', '-'], '', $value);
                $this->pessoa->{'set' . $column}($value);
            }
        }
        $this->pessoa->insert();
        exit;
    }

    public function getPessoas()
    {
        echo json_encode($this->pessoa->getAll());
        exit;
    }

    public function getContatos($queryParameters)
    {
        if($queryParameters['idPessoa']){
            echo json_encode($this->contato->getByidPessoa($queryParameters['idPessoa']));
            exit;
        }

        http_response_code(404);
        echo 'necessário enviar idPessoa pela url ?idPessoa=123';
        exit;
    }
}