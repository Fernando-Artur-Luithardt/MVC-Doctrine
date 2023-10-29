<?php

namespace Models;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'pessoa')]
class Pessoa extends Helper
{
    #[Column(length: 220)]
    private string $nome;

    #[Column(length: 14)]
    private string $cpf;

    #[OneToMany(mappedBy: 'idPessoa', targetEntity: Contato::class)]
    private Collection $contatos;

    public function getKey(): array
    {
        return ['id' => $this->getId()];
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

    public function getFilter($filter)
    {
        $query = $this->getQueryBuilder()
            ->select('*')
            ->from('pessoa');

        if ($filter !== false) {
            $query->where('nome LIKE :valor')
                ->setParameter('valor', '%' . $filter . '%');
        }

        if ($query->executeQuery()) {
            return $query->fetchAllAssociative();
        }
    }

    protected function getDatabaseName(): string
    {
        return 'pessoa';
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }

    public function getContatos(): Collection
    {
        return $this->contatos;
    }

    public function setContatos(Collection $contatos): void
    {
        $this->contatos = $contatos;
    }
}