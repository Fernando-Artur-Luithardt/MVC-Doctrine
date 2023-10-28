<?php

declare(strict_types = 1);

namespace Models;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Models\Enums\Tipo;
require_once 'models/Helper.php';

#[Entity]
#[Table('contato')]
class Contato extends Helper
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    #[Column]
    private int $idPessoa;

    #[Column]
    private string $descricao;

    #[Column]
    private Tipo $tipo;

    #[ManyToOne(inversedBy: 'items')]
    private Pessoa $pessoa;

    public function getId(): int
    {
        return $this->id;
    }

    public function getidPessoa(): int
    {
        return $this->idPessoa;
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

    public function getTipo(): Tipo
    {
        return $this->tipo;
    }

    public function setTipo(Tipo $tipo): Contato
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
