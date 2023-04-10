<?php

namespace App\controllers;

use App\core\Controller;
use App\data\DB;
use App\models\entities\User;

class Admin extends Controller
{
    public function index()
    {
        $payload = DB::getAll('users');
        $this->view->render('user/users.phtml', 'template.phtml', $payload);
    }
    public function add()
    {
        $this->view->render('user/add.phtml', 'template.phtml');
    }

    public function create()
    {
        if (!isset($_POST)
            || $_SERVER["REQUEST_METHOD"] !== "POST") {
            header('Location: /admin/add');
        }

        $entity = new \stdClass();
        $entity->username = $_POST['username'];
        $entity->email = $_POST['email'];
        $entity->role = $_POST['role'];
        $user = new User($entity);
        $userId = DB::create($user, 'users');
        if($userId) {
            header('Location: /admin');
        }
    }
    public function show($data)
    {
        if (!empty($data) && intval($data[0])) {
            $id = $data[0];
            $payload = DB::get('users', $id); // TODO Не забудьте добавить метод get в класс DB!!!
        }

        if(!isset($payload) || $payload['id'] === 0) {
            header('Location: /error');
        }
        $this->view->render('user/show.phtml', 'template.phtml', $payload);
    }
}