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

    public function insertPessoa(): void
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

        $colunas = [
            'cpf',
            'nome'
        ];
        $this->pessoa->insert($colunas);
        echo json_encode(['message' => 'SUCCESS']);
        exit;
    }

    public function getPessoas($queryParameters): void
    {
        echo json_encode($this->pessoa->getFilter($queryParameters));
        exit;
    }

    public function removerPessoa($queryParameters): void
    {
        echo json_encode($this->pessoa->delete($queryParameters['idPessoa']));
        exit;
    }

    public function editPessoa(): void
    {
        $params = $_POST;

        if (strlen($params['nome']) > 220) {
            echo json_encode(['message' => 'Nome ultrapassou o limite caracteres']);
            http_response_code(400);
            exit;
        }

        $colunas = [
            'nome',
            'id',
        ];
        echo json_encode(['message' => 'SUCCESS']);
        $this->pessoa->edit($params, $colunas);
        exit;
    }
}