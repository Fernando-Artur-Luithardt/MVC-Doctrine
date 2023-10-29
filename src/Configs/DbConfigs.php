<?php

namespace Configs;
class DbConfigs
{
    public static function getDbParams()
    {
    //    print_r([
    //        'driver' => 'pdo_mysql',
    //        'host' => getenv("DATABASE_HOST") ?? '127.0.0.1',
    //        'port' => getenv("DATABASE_PORT") ?? '3306',
    //        'charset' => 'utf8',
    //        'user' => getenv("DATABASE_USER") ?? 'root',
    //        'password' => getenv("MYSQL_ROOT_PASSWORD") ?? 'root',
    //        'dbname' => getenv("DATABASE_NAME") ?? 'Magazord',
    //    ]);
    //    exit;
        return [
            'driver' => 'pdo_mysql',
            'host' => 'host.docker.internal',
            'port' => '3307',
            'charset' => 'utf8',
            'user' => 'root',
            'password' => 'senha',
            'dbname' => 'Magazord',
        ];
    }
}