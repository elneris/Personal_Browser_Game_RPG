<?php


namespace App\Controller;


/**
 * Class ContactController
 * @package App\Controller
 */
class ContactController extends AbstractController
{
    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function formulaire()
    {
        return $this->twig->render('Contact/formulaire.html.twig');
    }
}