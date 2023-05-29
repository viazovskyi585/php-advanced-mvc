<?php

namespace Core;

use PDO;

class Db
{
    protected static PDO|null $connect = null;

    public static function connect(): PDO
    {
        if (is_null(static::$connect)) {
            $dsn = "mysql:host=" . config('db.host') . ";dbname=" . config('db.database');
            $options = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            static::$connect = new PDO(
                $dsn,
                config('db.user'),
                config('db.password'),
                $options
            );
        }

        return static::$connect;
    }
}
