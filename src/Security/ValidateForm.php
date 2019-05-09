<?php


namespace App\Security;


class ValidateForm
{

    public function valideInputs($values)
    {
        $errors = [];

        foreach ($values as $key => $value){
            if (empty($value)) {
                $errors[] = 'Veuillez remplir tout les champs';
            }

            if ($key == 'email') {
                if (!($this->security->emailCheck($value))) {
                    $errors[] = 'Email non valide';
                } else {
                    $_POST[$key] = $this->security->strCheck($value);
                }
            }
        }

        return $errors;
    }

    /**
     * @param string $str
     * @return string
     */
    public function strCheck(string $str):string
    {
        return htmlspecialchars(trim($str));
    }

    /**
     * @param string $str
     * @return mixed
     */
    public function emailCheck(string $str)
    {
        return filter_var($str, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param string $str
     * @return string
     */
    public function cryptPass(string $str):string
    {
        return sha1($str);
    }
}
