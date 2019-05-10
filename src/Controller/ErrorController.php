<?php


namespace App\Controller;

/**
 * Class ErrorController
 * @package App\Controller
 */
class ErrorController extends AbstractController
{
    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function pageNotFound()
    {
        return $this->twig->render('Home/404.html.twig');
    }
}
