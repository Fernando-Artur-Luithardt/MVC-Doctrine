<?php
namespace Models;

use DbConfigs;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;


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

        $this->connection = DriverManager::getConnection($dbParams, ORMSetup::createAttributeMetadataConfiguration([__FILE__], false));
        $this->queryBuilder = $this->connection->createQueryBuilder();
    }

    public function insert()
    {
        $reflectionClass = new \ReflectionClass(get_class($this));
        $atts = $reflectionClass->getProperties();
        $childAtt = [];
        foreach ($atts as $att) {
            if ($att->class === get_class($this)) {
                $childAtt[] = $att->getName();
            }
        }
        $insertArray = [];
        foreach ($childAtt as $att) {
            $insertArray[$att] = '\'' . $this->{'get'.$att}(). '\'';
        }
        $this->getQueryBuilder()->insert($this->getClassName())->values($insertArray)->executeQuery();   
    }

    public function getAll()
    {
        $query = $this->getQueryBuilder()->select('*')->from($this->getClassName());
        if ($query->executeQuery()) {
            return $query->fetchAllAssociative();
        }
        return false;
    }

    public function getQueryBuilder(): QueryBuilder
    {
        return $this->queryBuilder;
    }

    public function getClassName()
    {
        $class = get_class($this);
        $dir = explode("\\", $class);
        return end($dir);
    }

    public function delete(int $id)
    {
        if ($id) {
            $queryBuilder = $this->getQueryBuilder();
            $queryBuilder
                ->delete($this->getClassName())
                ->where('id = :valor')
                ->setParameter('valor', $id);
    
            $queryBuilder->executeQuery();

            return json_encode(['code' => 200]);
        }
    }

    public function createEdit($params, $collumns)
    {
        if(isset($params['id'])){
            if(!is_int(intval($params['id']))){
                unset($params['id']);
            }else{
                $query = $this->getQueryBuilder()
                    ->select('*')
                    ->from($this->getClassName())
                    ->where('id = :valor')
                    ->setParameter('valor', $params['id']);
                $query->executeQuery();
                $queryResult = $query->fetchAllAssociative();
            }
        }

        //ATUALIZA REGISTRO EXISTENTE
        if (!empty($queryResult)) {
            $query = $this->getQueryBuilder();
            $query
                ->update($this->getClassName())
                ->where('id = :id')
                ->setParameter('id', $params['id']);
            foreach($collumns as $key => $val){
                if(isset($key, $params[$key]) && $val){
                    $query->set($key, ':'.$key)
                    ->setParameter($key, $params[$key]);
                }
            }
            $query->executeQuery();
            return $query->fetchAllAssociative();
        }
    }

    public function get($id)
    {
        $query = $this->getQueryBuilder();
        if(is_int($id)){
            $query->select('*')
                ->from($this->getClassName())
                ->where('id = :id')
                ->setParameter('id', $id);

            if ($query->executeQuery()) {
                return $query->fetchAllAssociative();
            }
        }
        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}