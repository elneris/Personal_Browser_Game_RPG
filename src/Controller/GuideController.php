<?php


namespace App\Controller;


class GuideController extends AbstractController
{
    public function index()
    {
        return $this->twig->render('Guide/index.html.twig');
    }
}