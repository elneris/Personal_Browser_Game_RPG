<?php


namespace App\Controller;


class HomeController extends AbstractController
{
    public function index()
    {
        return $this->twig->render('Home/index.html.twig');
    }

    public function accueil()
    {
        var_dump($_SESSION);
        //return $this->twig->render('Home/accueil.html.twig');
    }
}