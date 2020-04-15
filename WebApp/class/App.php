<?php


class App
{
    public static DbManager $db;

    public static function getDb():DbManager{
        if (!self::$db)
        {
            self::$db = new DbManager();
        }
        return self::$db;
    }
}