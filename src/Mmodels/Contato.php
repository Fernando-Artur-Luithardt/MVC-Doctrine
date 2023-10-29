<?php

declare(strict_types = 1);

namespace Models;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
require_once './Models/Pessoa.php';
require_once 'Models/Pessoa.php';


#[Entity]
#[Table(name: 'contato')]
class Contato extends Helper
{
    #[Column]
    #[ManyToOne(targetEntity: Pessoa::class, inversedBy:"contatos")]
    #[JoinColumn(name:"idPessoa", referencedColumnName:"id")]
    private int $idPessoa;

    #[Column(length: 120)]
    private string $descricao;

    #[Column]
    private int $tipo;

    public function getByidPessoa(int $idPessoa)
    {
        $query = $this->getQueryBuilder()
            ->select('*')
            ->from($this->getDatabaseName())
            ->where('idPessoa = :valor')
            ->setParameter('valor', $idPessoa);

        if ($query->executeQuery()) {
            return $query->fetchAllAssociative();
        }
        return false;
    }

    protected function getDatabaseName(): string
    {
        return 'contato';
    }

    public function getIdPessoa(): int
    {
        return $this->idPessoa;
    }

    public function setIdPessoa(int $idPessoa): void
    {
        $this->idPessoa = $idPessoa;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    public function getTipo(): int
    {
        return $this->tipo;
    }

    public function setTipo(int $tipo): void
    {
        $this->tipo = $tipo;
    }
}
