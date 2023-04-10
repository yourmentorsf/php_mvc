<?php

namespace App\models\entities;

use DateTime;

class User
{
    public string $username;
    public string $email;
    public string $role;
    public $created;
    public function __construct($entity = null)
    {
        $this->username = $entity->username;
        $this->email = $entity->email;
        $this->created = DateTime::createFromFormat('U', time());
        self::setRole($entity->role);
    }
    public function setRole($role  = null)
    {
        $role == 'staff' ? $this->role = $role : $this->role = 'user';
    }
}