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
        if(strlen($params['cpf']) !== 14){
            echo json_encode(['message' => 'CPF Inválido']);
            exit;
        }
        if(strlen($params['nome']) === 0){
            echo json_encode(['message' => 'NOME Inválido']);
            exit;
        }
        if(!empty($this->pessoa->getByCpf($params['cpf']))){
            echo json_encode(['message' => 'CPF Já cadastrado na base']);
            exit;
        }

        foreach ($params as $column => $value) {
            if (is_callable([$this->pessoa, 'set' . $column])) {
                $this->pessoa->{'set' . $column}($value);
            }
        }
        $this->pessoa->insert();
        echo json_encode(['message' => 'SUCCESS']);
        exit;
    }

    public function getPessoas()
    {
        echo json_encode($this->pessoa->getAll());
        exit;
    }

    public function removerPessoa($queryParameters)
    {
        if($queryParameters['idPessoa']){
            echo json_encode($this->pessoa->delete($queryParameters['idPessoa']));
            exit;
        }

        http_response_code(404);
        echo 'necessário enviar idPessoa pela url ?idPessoa=123';
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

    public function editPessoa($params)
    {
        $collumns = [
            'nome'  => true,
            'cpf'   => false,
            'id'    => true,
        ];
        echo json_encode($this->pessoa->createEdit($params, $collumns));
        exit;
    }
}