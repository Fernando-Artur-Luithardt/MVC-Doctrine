<?php

$mysqlConnection = [
    'host'     => $env['DB_HOST'],
    'user'     => $env['DB_USER'],
    'password' => $env['DB_PASS'],
    'dbname'   => $env['DB_DATABASE'],
    'driver'   => $env['DB_DRIVER'] ?? 'pdo_mysql',
];