<?php
namespace Models;

use Configs\DbConfigs;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\ORMSetup;
use ReflectionClass;

abstract class Helper
{
    #[Id]
    #[Column(type: Types::INTEGER, insertable: false)]
    #[GeneratedValue]
    private int $id;
    private Connection $connection;
    private QueryBuilder $queryBuilder;

    function __construct()
    {
        $dbParams = DbConfigs::getDbParams();

        $this->connection = DriverManager::getConnection($dbParams, ORMSetup::createAttributeMetadataConfiguration([__FILE__]));
        $this->queryBuilder = $this->connection->createQueryBuilder();
    }

    public function insert($colunas): void
    {
        $insertArray = [];
        foreach ($colunas as $coluna) {
            $insertArray[$coluna] = '\'' . $this->{'get'.$coluna}(). '\'';
        }
        $this->getQueryBuilder()->insert($this->getDatabaseName())->values($insertArray)->executeQuery();
    }

    public function getAll()
    {
        $query = $this->getQueryBuilder()->select('*')->from($this->getDatabaseName());
        if ($query->executeQuery()) {
            return $query->fetchAllAssociative();
        }
        http_response_code(400);
        return false;
    }

    public function getQueryBuilder(): QueryBuilder
    {
        return $this->queryBuilder;
    }

    public function delete(int $id): bool|string
    {
        if (is_int(intval($id))) {
            $queryBuilder = $this->getQueryBuilder();
            $queryBuilder
                ->delete($this->getDatabaseName())
                ->where('id = :valor')
                ->setParameter('valor', $id);
    
            $queryBuilder->executeQuery();

            return json_encode(['code' => 200]);
        }
        http_response_code(400);
        return json_encode(['message' => 'Necessário enviar ID pela url. Exemplo: ?id=123']);
    }

    public function edit($params, $columns)
    {
        if(isset($params['id'])){
            if(!is_int(intval($params['id']))){
                unset($params['id']);
            }else{
                $query = $this->getQueryBuilder()
                    ->select('*')
                    ->from($this->getDatabaseName())
                    ->where('id = :valor')
                    ->setParameter('valor', $params['id']);
                $query->executeQuery();
                $queryResult = $query->fetchAllAssociative();
            }
        }

        if (!empty($queryResult)) {
            $query = $this->getQueryBuilder();
            $query
                ->update($this->getDatabaseName())
                ->where('id = :id')
                ->setParameter('id', $params['id']);
            foreach($columns as $val){
                if(isset($params[$val])){
                    $query->set($val, ':'.$val)
                    ->setParameter($val, $params[$val]);
                }
            }
            $query->executeQuery();
            return $query->fetchAllAssociative();
        }
        http_response_code(400);
        return null;
    }

    public function get($id): bool|array
    {
        $query = $this->getQueryBuilder();
        if(is_int($id)){
            $query->select('*')
                ->from($this->getDatabaseName())
                ->where('id = :id')
                ->setParameter('id', $id);

            if ($query->executeQuery()) {
                return $query->fetchAllAssociative();
            }
        }
        http_response_code(400);
        return false;
    }

    protected abstract function getDatabaseName(): string;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}