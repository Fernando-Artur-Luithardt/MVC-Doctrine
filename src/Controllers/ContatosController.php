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

        http_response_code(400);
        echo 'necessário enviar idPessoa pela url ?idPessoa=123';
        exit;
    }

    public function insertContato()
    {
        $params = $_POST;

        if (strlen($params['descricao']) == 0) {
            echo json_encode(['message' => 'CPF Inválido']);
            http_response_code(400);
            exit;
        }
        if (is_int($params['idPessoa'])) {
            echo json_encode(['message' => 'idPessoa Inválido']);
            http_response_code(400);
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
        //Colunas livres para serem preenchidas
        //somento colunas com o nome aqui podem ser preenchidas
        $collumns = [
            'id' => true,
            'tipo' => true,
            'descricao' => true,
            'idPessoa' => true,
        ];
        $this->contato->edit($params, $collumns);
        echo json_encode(['message' => 'SUCCESS']);
        exit;
    }
}