<?php

namespace Configs;
class DbConfigs
{
    public static function getDbParams(): array
    {
        return [
            'driver' => 'pdo_mysql',
            'host' => getenv("DATABASE_HOST") ?? '127.0.0.1',
            'port' => getenv("DATABASE_PORT") ?? '3306',
            'charset' => 'utf8',
            'user' => getenv("DATABASE_USER") ?? 'root',
            'password' => getenv("MYSQL_ROOT_PASSWORD") ?? 'senha',
            'dbname' => getenv("DATABASE_NAME") ?? 'magazord',
        ];
    }
}