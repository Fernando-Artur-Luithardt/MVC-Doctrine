<?php
require_once '/xampp/htdocs/MVC-Doctrine/bootstrap/bootstrap.php';

$queryBuilder = $entityManager->createQueryBuilder();

$query = $queryBuilder->select('p.nome')->from(Pessoa::class, 'p')->getQuery();

$pessoas = $query->getResult();
print_r($pessoas);
exit;