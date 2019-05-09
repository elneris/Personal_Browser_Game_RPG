<?php


namespace App\Security;


/**
 * Class ValidateForm
 * @package App\Security
 */
class ValidateForm
{

    /**
     * @param $values
     * @return array
     */
    public function valideInputs($values)
    {
        $errors = [];

        foreach ($values as $key => $value){
            if (empty($value)) {
                $errors[] = 'Veuillez remplir tout les champs';
                break;
            }

            if ($key == 'email') {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Email non valide';
                }
            } else {
                $_POST[$key] = htmlspecialchars(trim($value));
            }
        }
        return $errors;
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
