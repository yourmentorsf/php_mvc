<?php

namespace App\controllers;

use App\core\Controller;

class Home extends Controller
{
    public function index()
    {
        $this->view->render('home.phtml', 'template.phtml');
    }
    public function about()
    {
        $this->view->render('about.phtml', 'template.phtml');
    }
    public function help()
    {
        $this->view->render('help.phtml', 'template.phtml');
    }

}