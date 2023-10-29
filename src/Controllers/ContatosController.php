<?php

namespace Controllers;

use Models\Contato;

class ContatosController
{
    private Contato $contato;

    public function __construct()
    {
        $this->contato = new Contato();
    }

    public function removerContato($queryParameters)
    {
        echo json_encode($this->contato->delete($queryParameters['contatoId']));
        exit;
    }

    public function getContatos($queryParameters)
    {
        if ($queryParameters['idPessoa']) {
            echo json_encode($this->contato->getByidPessoa($queryParameters['idPessoa']));
            exit;
        }

        http_response_code(404);
        echo 'necessário enviar idPessoa pela url ?idPessoa=123';
        exit;
    }

    public function insertContato()
    {
        $params = $_POST;

        if (strlen($params['descricao']) == 0) {
            echo json_encode(['message' => 'CPF Inválido']);
            exit;
        }
        if (is_int($params['idPessoa'])) {
            echo json_encode(['message' => 'idPessoa Inválido']);
            exit;
        }

        foreach ($params as $column => $value) {
            if (is_callable([$this->contato, 'set' . $column])) {
                $this->contato->{'set' . $column}($value);
            }
        }
        $this->contato->insert();
        echo json_encode(['message' => 'SUCCESS']);
        exit;
    }

    public function editContato()
    {
        $params = $_POST;

        $collumns = [
            'id' => true,
            'tipo' => true,
            'descricao' => true,
            'idPessoa' => true,
        ];
        $this->contato->createEdit($params, $collumns);
        echo json_encode(['message' => 'SUCCESS']);
        exit;
    }
}