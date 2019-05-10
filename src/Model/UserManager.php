<?php


namespace App\Model;


/**
 * Class UserManager
 * @package App\Model
 */
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

    /**
     * @param string $verify
     * @param int $id
     */
    public function insertVerify(string $verify, int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET verify = :verify WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->bindValue('verify', $verify, \PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * @param string $email
     * @return array
     */
    public function selectEmail(string $email): array
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE email =:email");
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);

        $statement->execute();
        return $statement->fetchAll();
    }

    /**
     * @param string $charname
     * @return mixed
     */
    public function selectOneByCharname(string $charname)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE charname=:charname");
        $statement->bindValue('charname', $charname, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * @param array $user
     */
    public function insert(array $user)
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table 
        (username, email, password, charname, regdate, avatar, miniavatar, charclass, difficulty) 
        VALUES (:username, :email, :password, :charname, NOW(), :avatar, :miniavatar, :charclass, '1')");
        $statement->bindValue('username', $user['username'], \PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);
        $statement->bindValue('charname', $user['charname'], \PDO::PARAM_STR);
        $statement->bindValue('avatar', $user['avatar'], \PDO::PARAM_STR);
        $statement->bindValue('miniavatar', $user['avatar'], \PDO::PARAM_STR);
        $statement->bindValue('charclass', $user['charclass'], \PDO::PARAM_STR);

        $statement->execute();
    }

    /**
     * @param int $id
     * @param string $password
     */
    public function changePassword(int $id, string $password)
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET password = :password WHERE id = :id");
        $statement->bindValue('password', $password, \PDO::PARAM_STR);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        $statement->execute();
    }
}
