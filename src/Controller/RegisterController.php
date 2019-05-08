<?php


namespace App\Controller;


class RegisterController extends AbstractController
{
    public function inscription()
    {
        return $this->twig->render('Register/inscription.html.twig');
    }
}