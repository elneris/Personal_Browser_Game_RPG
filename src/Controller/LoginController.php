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
        $this->authenticator->isLogged('username');

        $userManager = new UserManager();

        $errors = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
            $errors = $this->security->valideInputs($_POST);

            if (count($errors) == 0) {
                $user = $userManager->selectOneByUsername($_POST['username']);

                if (($_POST['email']) != $user['email'] || count($user) == 0) {
                    $errors[] = 'Utilisateur ou email incorrect';
                } else {
                    $this->authenticator->newValidationCode($user);
                    $success = $user['username'] . ' , un nouveau mail vous a été envoyé à l\'adresse : ' . $user['email'];
                }
            }
        }
        return $this->twig->render('Login/newMail.html.twig', [
            'errors' => $errors,
            'success' => $success
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

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function lostPassword()
    {
        $this->authenticator->isLogged('username');

        $userManager = new UserManager();

        $errors = '';
        $success = '';
        $newPassword = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
            $errors = $this->security->valideInputs($_POST);

            if (count($errors) == 0) {
                $user = $userManager->selectOneByUsername($_POST['username']);

                if (($_POST['email']) != $user['email'] || count($user) == 0) {
                    $errors[] = 'Utilisateur ou email incorrect';
                } else {
                    $newPassword = $this->authenticator->passwordLost($user);
                    $success = 'Un nouveau  MDP vous a été envoyé à l\'adresse : ' . $user['email'];
                    $userManager->changePassword($user['id'], $newPassword['passwordCrypt']);
                }
            }
        }

        return $this->twig->render('Login/newPassword.html.twig',[
            'success' => $success,
            'errors' => $errors,
            'password' => $newPassword //TODO a supprimer
        ]);
    }
}