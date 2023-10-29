<?php

declare(strict_types = 1);

namespace Models;
use Models\Pessoa;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
require_once './models/Pessoa.php';
require_once 'models/Pessoa.php';
#[Entity]
#[Table(name: 'contato')]
class Contato extends Helper
{
    #[Column(length: 120)]
    private string $descricao;
    private int $tipo;
    private int $idPessoa;

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getTipo(): int
    {
        return $this->tipo;
    }

    public function getIdPessoa(): string
    {
        return $this->idPessoa;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setIdPessoa(int $idPessoa)
    {
        $this->idPessoa = $idPessoa;
    }

    public function setDescricao(string $descricao)
    {
        $this->descricao = $descricao;
    }

    public function setTipo(int $tipo)
    {
        $this->tipo = $tipo;
    }

    public function getByidPessoa(int $idPessoa)
    {
        $query = $this->getQueryBuilder()
            ->select('*')
            ->from($this->getClassName())
            ->where('idPessoa = :valor')
            ->setParameter('valor', $idPessoa);

        if ($query->executeQuery()) {
            return $query->fetchAllAssociative();
        }
        return false;
    }
}
