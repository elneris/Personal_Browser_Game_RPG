<?php


namespace App\Security;


/**
 * Class Authentication
 * @package App\Security
 */
class Authentication
{
    /**
     * @param $param
     */
    public function isLogged($param)
    {
        if (isset($_SESSION[$param])){
            header('location: /Home/accueil');
        }
    }

    /**
     * @param $param
     */
    public function isAuthorized($param)
    {
        if (!isset($_SESSION[$param])){
            header('location: /login/index');
        }
    }

    /**
     * @param array $values
     */
    public function setSession(array $values)
    {
        $_SESSION['id'] = $values['id'];
        $_SESSION['username'] = $values['username'];
        $_SESSION['lastname'] = $values['charname'];
    }

    /**
     * @param string $verify
     * @return bool
     */
    public function isVerify(string $verify)
    {
        if ($verify == 1){
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * @param array $values
     * @return array
     */
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

    /**
     * @param array $values
     */
    public function newValidationCode(array $values)
    {
        $email = $values['email'];
        $login = $values['username'];
        $verifycode = $values['verify'];

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
    }

    /**
     * @param array $values
     * @return array
     */
    public function passwordLost(array $values)
    {
        $email = $values['email'];
        $login = $values['username'];
        $newPassword = "";
        for ($i=0; $i<8; $i++) {
            $newPassword .= chr(rand(65,90));
        }
        $newCryptPass = sha1($newPassword);
        $destinataire = $email;
        $sujet = "Nouveau Mot de pass" ;
        $entete = "From: elneris.dang@gmail.com" ;

        $message = 'Bonjour ' . $login . ' vous ou une personne employant votre adresse email a perdu son mot de passe sur RPG game. 

        Nous vous avons envoyé un nouveau mot de passe. Ainsi vous pourrez continuer à jouer sur le jeu.
        
        Votre nouveau PW est: ' . $newPassword . '
        
        Merci de votre participation.
          
        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.';


        mail($destinataire, $sujet, $message, $entete) ;

        return ['passwordCrypt' => $newCryptPass, 'newPassword' => $newPassword];
    }
}
