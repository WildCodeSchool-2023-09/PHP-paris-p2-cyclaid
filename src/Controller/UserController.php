<?php

namespace App\Controller;

use App\Controller\AbstractController;

class UserController extends AbstractController
{
    public function connect(): string
    {
        return $this->twig->render('User/connect.html.twig');
    }

    public function signIn(): string
    {
        return $this->twig->render('User/signin.html.twig');
    }
}
