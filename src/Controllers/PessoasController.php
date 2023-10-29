<?php
namespace Controllers;

use Models\Pessoa;

class PessoasController
{
    private Pessoa $pessoa;

    public function __construct()
    {
        $this->pessoa = new Pessoa();
    }

    public function insertPessoa()
    {
        $params = $_POST;
        if (strlen($params['cpf']) !== 14) {
            echo json_encode(['message' => 'CPF Inválido']);
            http_response_code(400);
            exit;
        }
        if (strlen($params['nome']) === 0) {
            echo json_encode(['message' => 'NOME Inválido']);
            http_response_code(400);
            exit;
        }
        if (!empty($this->pessoa->getByCpf($params['cpf']))) {
            echo json_encode(['message' => 'CPF Já cadastrado na base']);
            http_response_code(400);
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

    public function getPessoas($queryParameters)
    {
        echo json_encode($this->pessoa->getFilter($queryParameters));
        exit;
    }

    public function removerPessoa($queryParameters)
    {
        echo json_encode($this->pessoa->delete($queryParameters['idPessoa']));
        exit;
    }

    public function editPessoa()
    {
        $params = $_POST;

        //Colunas livres para serem preenchidas
        //somento colunas com o nome aqui podem ser preenchidas
        $collumns = [
            'nome' => true,
            'cpf' => false,
            'id' => true,
        ];
        echo json_encode(['message' => 'SUCCESS']);
        $this->pessoa->edit($params, $collumns);
        exit;
    }
}