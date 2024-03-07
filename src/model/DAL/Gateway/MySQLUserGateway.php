<?php

namespace Model\DAL\Gateway;

use Model\ClassMetier\User;
use Model\DAL\Connection;
use PDO;

class MySQLUserGateway implements IUserGateway
{
    protected Connection $pdo;

    public function __construct()
    {
        global $dsn, $user, $password;
        $this->pdo = new Connection($dsn, $user, $password);
    }

    /**
     * @param string $username
     * @return array
     */
    public function findByUsername(string $username): array
    {
        $query = 'SELECT * FROM User WHERE username = :username';
        $this->pdo->executeQuery($query, array(':username' => array($username, PDO::PARAM_STR)));
        $res = $this->pdo->getResults();
        if ($res == null) {
            return array();
        }
        return $res[0];
    }

    /**
     * @param int $id
     * @return array
     */
    public function findById(int $id): array
    {
        $query = 'SELECT * FROM User WHERE id = :id';
        $this->pdo->executeQuery($query, array(':id' => array($id, PDO::PARAM_INT)));
        $res = $this->pdo->getResults();
        return $res[0];
    }

    /**
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email): ?array
    {
        $query = 'SELECT * FROM User WHERE email = :user';
        $this->pdo->executeQuery($query, array(':user' => array($email, PDO::PARAM_STR)));
        $res = $this->pdo->getResults();
        if (empty($res)) {
            return null;
        }
        return $res[0];
    }

    /**
     * @param int $id
     * @param string $username
     * @param string $email
     * @return void
     */
    public function updateById(int $id, string $username, string $email)
    {
        $query = 'UPDATE User SET username=:name, email=:email WHERE id=:ident';
        $this->pdo->executeQuery($query, array(
            ':name' => array($username, PDO::PARAM_STR),
            ':email' => array($email, PDO::PARAM_STR),
            ':ident' => array($id, PDO::PARAM_INT)));
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteById(int $id)
    {
        $query = 'DELETE FROM User WHERE id=:user';
        $this->pdo->executeQuery($query, array(':user' => array($id, PDO::PARAM_INT)));
    }

    /**
     * @param User $user
     * @return void
     */
    public function insertNewUser(User $user)
    {
        $query = 'INSERT INTO User(username, password, email, is_admin) VALUES(:username, :password, :email, :isAdmin)';
        $this->pdo->executeQuery($query, array(
            ':username' => array($user->getUsername(), PDO::PARAM_STR),
            ':password' => array($user->getPassword(), PDO::PARAM_STR),
            ':email' => array($user->getEmail(), PDO::PARAM_STR),
            ':isAdmin' => array($user->isAdmin(), PDO::PARAM_STR)));
    }

    /**
     * @param string $email
     * @return array
     */
    public function findBanByEmail(string $email): ?array
    {
        $query = 'SELECT email, expiration_date FROM Blacklist WHERE email = :mail';
        $this->pdo->executeQuery($query, array(':mail' => array($email, PDO::PARAM_STR)));
        $res = $this->pdo->getResults();
        if (empty($res)) {
            return null;
        }
        return $res[0];
    }
}
