<?php


namespace App\Controller;


class ValidationController extends AbstractController
{
    public function activation(string $loginKey, string $verifyKey)
    {
        // TODO recup bdd login & verify

        $errors = [];
        $success = [];

        if ($verify == 1){
            $errors[] = 'Votre compte est déjà actif !!!';
        } else {
            if ($verify == $verifyKey){
                $success[] = 'Votre compte à bien été activé !';

                // TODO modifier verify par 1 en bdd
            } else {
                $errors[] = 'La clé ne correspond pas ! Votre compte ne peut pas être activé ...';
            }
        }

        return $this->twig->render('Validation/activation.html.twig', [
            'errors' => $errors,
            'success' => $success
        ]);
    }
}