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
#[Table('contato')]
class Contato extends Helper
{
    #[ManyToOne(inversedBy: 'items')]
    private Pessoa $pessoa;

    public function __construct()
    {
        $this->pessoa = new \Models\Pessoa();
    }
    #[Column]
    private int $pessoaId = 0;

    #[Column]
    private string $descricao;

    #[Column]
    private int $tipo;

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getPessoaId(): int
    {
        return $this->pessoaId;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): Contato
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getPessoa(): Pessoa
    {
        return $this->pessoa;
    }

    public function setPessoa(Pessoa $pessoa): Contato
    {
        $this->pessoa = $pessoa;

        return $this;
    }

    public function getTipo(): int
    {
        return $this->tipo;
    }

    public function setTipo(int $tipo): Contato
    {
        $this->tipo = $tipo;

        return $this;
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
