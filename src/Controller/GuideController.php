<?php


namespace App\Controller;


/**
 * Class GuideController
 * @package App\Controller
 */
class GuideController extends AbstractController
{
    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->render('Guide/index.html.twig');
    }
}