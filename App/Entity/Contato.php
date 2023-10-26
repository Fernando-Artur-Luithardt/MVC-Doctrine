<?php

declare(strict_types = 1);

namespace App\Entity;
use App\Enums\Tipo;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('contato')]
class Contato
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    #[Column]
    private int $pessoaId;

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

    public function getTipo(): Tipo
    {
        return $this->tipo;
    }

    public function setTipo(Tipo $tipo): Contato
    {
        $this->tipo = $tipo;

        return $this;
    }
}
