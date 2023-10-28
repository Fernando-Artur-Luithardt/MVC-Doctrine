<?php
namespace Models;

use Doctrine\ORM\Mapping\Column;
require_once 'models/Helper.php';
#[Entity]
#[Table(name: 'pessoa')]
class Pessoa extends Helper
{
    #[Column(length: 50)]
    private string $nome;
    #[Column(length: 11)]
    private string $cpf;

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }

    public function setCpf(string $cpf)
    {
        $this->cpf = $cpf;
    }

    public function getKey(): array
    {
        return ['id' => $this->id];
    }

    public function getByCpf($cpf)
    {
        $query = $this->getQueryBuilder()
            ->select('*')
            ->from('pessoa')
            ->where('cpf = :valor')
            ->setParameter('valor', $cpf);

        if ($query->executeQuery()) {
            return $query->fetchAllAssociative();
        }
        return false;
    }
}