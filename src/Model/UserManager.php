<?php


namespace App\Model;


use App\Manager\AbstractManager;

class UserManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'rpg_users';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
