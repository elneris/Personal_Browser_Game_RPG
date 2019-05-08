<?php


namespace App\Controller;

use App\Model\UserManager;
use App\Security\Authentication;
use App\Security\ValidateForm;

class RegisterController extends AbstractController
{
    public function inscription()
    {
        $this->authenticator->isLogged('login');

        $userManager = new UserManager();

        $errors = [];
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
            if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])
                || empty($_POST['repeatPassword']) || empty($_POST['charname']) || empty($_POST['avatar'])
                || empty($_POST['charclass'])){
                $errors[] = 'Veuillez Renseigner TOUT les champs';
            } else {
                foreach ($_POST as $key => $value){
                    if ($key == 'email') {
                        if (!($this->security->emailCheck($value))) {
                            $errors[] = 'Email non valide';
                        } else {
                            $_POST[$key] = $this->security->strCheck($value);
                        }
                    }
                }

                $emailExist = $userManager->selectEmail($_POST['email']);
                if (count($emailExist) > 0){
                    $errors[] = 'Cette email est déjà utilisé';
                }

                $usernameExist = $userManager->selectOneByUsername($_POST['username']);
                if ($usernameExist['username'] == $_POST['username']){
                    $errors[] = 'Ce pseudo est déjà utilisé';
                }

                $charnameExist = $userManager->selectOneByCharname($_POST['charname']);
                if ($charnameExist['charname'] == $_POST['username']){
                    $errors[] = 'Ce nom de personnage est déjà utilisé';
                }

                if ($_POST['password'] != $_POST['repeatPassword']){
                    $errors[] = 'Veuillez renseigner deux mots de passe identique';
                } else {
                    $_POST['password'] = $this->security->cryptPass($_POST['password']);
                }

                if (count($errors) == 0) {
                    $userManager->insert($_POST);

                    $verify = $this->authenticator->validationCode($_POST);
                    $user = $userManager->selectOneByUsername($verify['username']);
                    $userManager->insertVerify($verify['verify'],$user['id']);

                    $success = 'Enregistrement réalisé avec succes, un email de validation vous a été envoyé';
                }
            }
        }
        return $this->twig->render('Register/inscription.html.twig', [
            'errors' => $errors,
            'success' => $success
        ]);
    }
}
