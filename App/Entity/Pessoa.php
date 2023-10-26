<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('pessoa')]
class Pessoa
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    #[Column]
    private string $nome;

    #[Column]
    private string $cpf;

    #[OneToMany(targetEntity: Contato::class, mappedBy: 'invoice', cascade: ['persist', 'remove'])]
    private Collection $contatos;

    public function __construct()
    {
        $this->contatos = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): Pessoa
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): Pessoa
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * @return Collection<Contato>
     */
    public function getContatos(): Collection
    {
        return $this->contatos;
    }

    public function addContato(Contato $contato): Pessoa
    {
        $contato->setPessoa($this);

        $this->contatos->add($contato);

        return $this;
    }
}
