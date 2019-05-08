<?php


namespace App\Security;


class ValidateForm
{
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
