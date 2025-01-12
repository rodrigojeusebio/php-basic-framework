<?php

namespace Core;

use Libs\Singleton;

class Database extends Singleton
{
    public \PDO $database;

    public function __construct()
    {
        $path           = Config::get('base_path').'Database/'.Config::get('database');
        $this->database = new \PDO("sqlite:".$path, null, null);
    }

    public static function query(string $query) 
    {
        return static::get_instance()->database->query($query, fetchMode: \PDO::FETCH_ASSOC)->fetch();
    }
}