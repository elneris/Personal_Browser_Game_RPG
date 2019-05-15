<?php


namespace App\Controller;

use App\Model\UserManager;
use App\Security\Authentication;
use App\Security\ValidateForm;

/**
 * Class RegisterController
 * @package App\Controller
 */
class RegisterController extends AbstractController
{
    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function inscription()
    {
        $this->authenticator->isLogged('username');

        $userManager = new UserManager();

        $errors = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
            $errors = $this->security->valideInputs($_POST);

            $emailExist = $userManager->selectEmail($_POST['email']);
            if (count($emailExist) > 0){
                $errors[] = 'Cette email est déjà utilisé';
            }

            $usernameExist = $userManager->selectOneByUsername($_POST['username']);
            if ($usernameExist['username'] == $_POST['username']){
                $errors[] = 'Ce pseudo est déjà utilisé';
            }

            $charnameExist = $userManager->selectOneByCharname($_POST['charname']);
            if ($charnameExist['charname'] == $_POST['charname']){
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
        return $this->twig->render('Register/inscription.html.twig', [
            'errors' => $errors,
            'success' => $success
        ]);
    }
}
