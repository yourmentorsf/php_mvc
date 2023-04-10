<?php

namespace App\data;

use RedBeanPHP\R;
use RedBeanPHP\RedException;

try {

    R::setup('sqlite:' . DATA . 'db.sqlite');
    if(!R::testConnection()) {
        throw new RedException('No connection');
    }
} catch(RedException $e) {
    exit(var_dump($e));
}

class DB
{
    public static function getAll(string $table)
    {
        $table = self::testInput($table);
        return R::findAll($table);
    }

    public static function get(string $table, string $id)
    {
        // TODO
    }
    public static function create(object $entity, string $table)
    {
        $bean = R::dispense($table);
        $bean->username = $entity->username;
        $bean->email = $entity->email;
        $bean->created = $entity->created;
        $bean->role = $entity->role;

        $id = R::store($bean);

        return $id;
    }

    public static function update(object $obj, string $table)
    {
        // TODO
    }

    public static function delete(string $id, string $table)
    {
        // TODO
    }

    public static function dropTable(string $table)
    {
        // TODO
    }

    private static function testInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

}