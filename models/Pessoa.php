<?php
namespace Models;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToMany;

require_once 'models/Helper.php';
#[Entity]
#[Table(name: 'pessoa')]
class Pessoa extends Helper
{
    #[Column(length: 220)]
    private string $nome;

    #[Column(length: 14)]
    private string $cpf;

    #[OneToMany(targetEntity: Contato::class, mappedBy: 'idPessoa')]
    private Collection $contatos;

    // #[OneToMany(targetEntity: Contato::class, mappedBy: 'invoice', cascade: ['persist', 'remove'])]
    // private Collection $contatos;

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getCpf(): string
    {
        return $this->cpf;
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
}