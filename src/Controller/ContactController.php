<?php


namespace App\Controller;


class ContactController extends AbstractController
{
    public function formulaire()
    {
        return $this->twig->render('Contact/formulaire.html.twig');
    }
}