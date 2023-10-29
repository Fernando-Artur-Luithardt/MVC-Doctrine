<?php

class DbConfigs {
    public static function getDbParams()
    {
        return [
            'driver' => 'pdo_mysql',
            'host' => getenv("DATABASE_HOST") ?? 'localhost',
            'port' => getenv("DATABASE_PORT") ?? '3306',
            'charset' => 'utf8',
            'user' => getenv("DATABASE_USER") ?? 'root',
            'password' => getenv("MYSQL_ROOT_PASSWORD") ?? 'root',
            'dbname' => getenv("DATABASE_NAME") ?? 'magazord',
        ];
    }
}