<?php


namespace App\Controller;


use App\Model\UserManager;

/**
 * Class LoginController
 * @package App\Controller
 */
class LoginController extends AbstractController
{
    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function login()
    {
        $this->authenticator->isLogged('username');

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

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function newVerifyEmail()
    {
        //$this->authenticator->isLogged('username');

        $userManager = new UserManager();

        $errors = '';
        $success = '';
        $mail = ''; //TODO a suppr en prod

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
            $errors = $this->security->valideInputs($_POST);

            if (count($errors) == 0) {
                $user = $userManager->selectOneByUsername($_POST['username']);

                if (($_POST['email']) != $user['email'] || count($user) == 0) {
                    $errors[] = 'Utilisateur ou email incorrect';
                } else {
                    $mail = $this->authenticator->newValidationCode($user); //TODO $mail a suppr en prod
                    $success = $user['username'] . ' , un nouveau mail vous a été envoyé à l\'adresse : ' . $user['email'];
                }
            }
        }
        return $this->twig->render('Login/newMail.html.twig', [
            'errors' => $errors,
            'success' => $success,
            'mail' => $mail //TODO a supprimer en prod
        ]);
    }

    /**
     *
     */
    public function logout():void
    {
        session_unset();
        session_destroy();
        header('location: /Home/index');
    }
}