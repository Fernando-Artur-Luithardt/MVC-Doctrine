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

    public function removerContato($queryParameters): void
    {
        echo json_encode($this->contato->delete($queryParameters['contatoId']));
        exit;
    }

    public function getContatos($queryParameters): void
    {
        if ($queryParameters['idPessoa']) {
            echo json_encode($this->contato->getByIdPessoa($queryParameters['idPessoa']));
            exit;
        }

        http_response_code(400);
        echo json_encode(['message' => 'Necessário enviar pessoa pelo parâmetro "idPessoa" da URL']);
        exit;
    }

    public function insertContato(): void
    {
        $params = $_POST;

        if (strlen($params['descricao']) == 0) {
            echo json_encode(['message' => 'Descrição inválida']);
            http_response_code(400);
            exit;
        }
        if (strlen($params['descricao']) > 120) {
            echo json_encode(['message' => 'Descrição ultrapassou o limite caracteres']);
            http_response_code(400);
            exit;
        }
        if (is_int($params['idPessoa'])) {
            echo json_encode(['message' => 'idPessoa inválido']);
            http_response_code(400);
            exit;
        }

        foreach ($params as $coluna => $value) {
            if (is_callable([$this->contato, 'set' . $coluna])) {
                $this->contato->{'set' . $coluna}($value);
            }
        }

        $colunas = [
            'descricao', 
            'idPessoa', 
            'tipo'
        ];
        $this->contato->insert($colunas);
        echo json_encode(['message' => 'SUCCESS']);
        exit;
    }

    public function editContato(): void
    {
        $params = $_POST;

        $validate = $this->validateContato($params);
        if(is_array($validate)){
            echo json_encode($validate);
            http_response_code(400);
            exit;
        }

        $colunas = [
            'id',
            'tipo',
            'descricao',
            'idPessoa',
        ];
        $this->contato->edit($params, $colunas);
        echo json_encode(['message' => 'SUCCESS']);
        exit;
    }

    private function validateContato($params): bool|array
    {
        if (strlen($params['descricao']) == 0) {
            return ['message' => 'Descrição inválida'];
        }
        if (strlen($params['descricao']) > 120) {
            return ['message' => 'Descrição ultrapassou o limite caracteres'];
        }
        if (is_int($params['idPessoa'])) {
            return ['message' => 'idPessoa inválido'];
        }
        return true;
    }
}