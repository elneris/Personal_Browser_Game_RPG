<?php


namespace App\Controller;


use App\Model\UserManager;

class LoginController extends AbstractController
{
    public function login()
    {
        $this->authenticator->isLogged('login');

        $userManager = new UserManager();

        $errors = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
            $errors = $this->security->valideInputs($_POST);

            if (count($errors) == 0) {
                $user = $userManager->selectOneByUsername($_POST['username']);
                if (sha1($_POST['password']) != $user['password'] || count($user) == 0 ){
                    $errors[] = 'Utilisateur ou mot de passe incorect';
                } else {
                    if (!($this->authenticator->isVerify($user['verify']))) {
                        $errors[] = "Votre compte n'a pas encore été vérifié, veuillez regarder vos emails ou cliquez <a href='/Login/newVerifyEmail'>ici</a> pour en recevoir un nouveau";
                    } else {
                        $this->authenticator->setSession($user);
                        header('location: /Home/accueil');
                        exit;
                    }
                }
            }
        }
        return $this->twig->render('Login/login.html.twig', [
            'errors' => $errors
        ]);
    }

    public function newVerifyEmail()
    {
        return $this->twig->render('Login/newMail.html.twig');
    }
}