<?php


namespace App\Security;


class Authentication
{
    public function isLogged($param)
    {
        if (isset($_SESSION[$param])){
            header('location: /Home/index');
        }
    }

    public function isAuthorized($param)
    {
        if (!isset($_SESSION[$param])){
            header('location: /login/index');
        }
    }

    public function setSession(array $values)
    {
        $_SESSION['id'] = $values['id'];
        $_SESSION['username'] = $values['username'];
        $_SESSION['lastname'] = $values['charname'];
    }

    public function isVerify(string $verify)
    {
        if ($verify == 1){
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    public function validationCode(array $values)
    {
        $email = $values['email'];
        $login = $values['username'];
        $verifycode = "";
        for ($i=0; $i<8; $i++) {
            $verifycode .= chr(rand(65,90));
        }
        // Préparation du mail contenant le lien d'activation
        $destinataire = $email;
        $sujet = "Activer votre compte" ;
        $entete = "From: elneris.dang@gmail.com" ;

        $message = 'Bienvenue sur RPG Game,
 
        Pour activer votre compte, veuillez cliquer sur le lien ci dessous
        ou copier/coller dans votre navigateur internet.
         
        http://localhost:8000/Validation/activation/' . urlencode($login) . '/' . urlencode($verifycode) . '
         
         
        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.';


        mail($destinataire, $sujet, $message, $entete) ;

        return ['verify' => $verifycode, 'username' => $login];
    }
}