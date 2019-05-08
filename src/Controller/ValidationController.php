<?php


namespace App\Controller;


use App\Model\UserManager;

class ValidationController extends AbstractController
{
    public function activation(string $loginKey='', string $verifyKey='0')
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneByUsername($loginKey);

        $errors = [];
        $success = [];

        if (count($user) == 0) {
            $errors[] = 'Erreur, votre login n\'est pas reconnu';
        } else {
            if ($user['verify'] == 1) {
                $errors[] = 'Votre compte est déjà actif !!!';
            } else {
                if ($user['verify'] == $verifyKey) {
                    $success[] = 'Votre compte à bien été activé !';
                    $userManager->insertVerify('1', $user['id']);
                } else {
                    $errors[] = 'La clé ne correspond pas ! Votre compte ne peut pas être activé ...';
                }
            }
        }
        return $this->twig->render('Validation/activation.html.twig', [
            'errors' => $errors,
            'success' => $success
        ]);
    }
}