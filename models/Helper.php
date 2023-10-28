<?php
namespace Models;

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
        $dbParams = [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'charset' => 'utf8',
            'user' => 'root',
            'password' => '',
            'dbname' => 'magazord',
        ];

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
}