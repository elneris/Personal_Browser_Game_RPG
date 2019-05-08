<?php


namespace App\Model;


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

    public function insertVerify(string $verify, int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET verify = :verify WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->bindValue('verify', $verify, \PDO::PARAM_STR);
        $statement->execute();
    }


}
