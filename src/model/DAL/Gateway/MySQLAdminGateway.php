<?php

namespace Model\DAL\Gateway;

use PDO;

class MySQLAdminGateway extends MySQLUserGateway implements IAdminGateway
{
    /**
     * @return int
     */
    public function getNbUsers(): int
    {
        $query = 'SELECT COUNT(*) AS nbusers FROM User';
        $this->pdo->executeQuery($query);
        $res = $this->pdo->getResults();
        return $res[0]['nbusers'];
    }

    /**
     * @return int
     */
    public function getNbUsersBan(): int
    {
        $query = 'SELECT COUNT(*) AS nbusers FROM Blacklist';
        $this->pdo->executeQuery($query);
        $res = $this->pdo->getResults();
        return $res[0]['nbusers'];
    }

    /**
     * Summary : Permet de récupérer le pseudo de tous les utilisateurs sous forme de liste.
     * @return array : contient la liste d'utilisateurs n'étant pas des admins
     */
    public function printUsersList(int $nbUser, int $decalage): array
    {
        $query = 'SELECT username FROM User WHERE is_admin != 1 ORDER BY 1 LIMIT :nbUser OFFSET :decalage';
        $this->pdo->executeQuery($query, array(
            ':nbUser' => array($nbUser, PDO::PARAM_INT),
            ':decalage' => array($decalage, PDO::PARAM_INT)));
        $res = $this->pdo->getResults();
        $allUser = [];
        foreach ($res as $row) {
            $allUser [] = $row['username'];
        }
        return $allUser;
    }

    /**
     * @param int $nbUser
     * @param int $decalage
     * @return array
     */
    public function printUsersListBan(int $nbUser, int $decalage): array
    {
        $query = 'SELECT email FROM Blacklist ORDER BY 1 LIMIT :nbUser OFFSET :decalage';
        $this->pdo->executeQuery($query, array(
            ':nbUser' => array($nbUser, PDO::PARAM_INT),
            ':decalage' => array($decalage, PDO::PARAM_INT)));
        return $this->pdo->getResults();
    }

    /**
     * Summary : Permet de promouvoir un utilisateur au statut d'administrateur.
     * @param string $username : nom d'utilisateur de la personne à promouvoir en admin
     * @return void
     */
    public function promoteUser(string $username): void
    {
        $query = 'UPDATE User SET is_admin = 1 WHERE username=:user';
        $this->pdo->executeQuery($query, array(':user' => array($username, PDO::PARAM_STR)));
    }

    /**
     * Summary : On cherche l'utilisateur dans la table User; on ajoute son email et la date actuelle +
     * 2 ans à la table Blacklist puis on le supprime de la table User
     * @param string $username : nom d'utilisateur de l'utilisateur à bannir
     * @return void
     */
    public function banUser(string $username): void
    {
        $usrArray = parent::findByUsername($username);
        $email = $usrArray['email'];
        $query = 'INSERT INTO Blacklist (email, expiration_date)
                  VALUES (:mail,  DATE_ADD(CURRENT_DATE, INTERVAL 2 YEAR))';
        $this->pdo->executeQuery($query, array(':mail' => array($email, PDO::PARAM_STR)));
        $this->deleteByUsername($username);
    }

    /**
     * Summary : Permet de supprimer un utilisateur à partir de son pseudonyme.
     * @param string $username : nom d'utilisateur à supprimer
     * @return void
     */
    public function deleteByUsername(string $username): void
    {
        $query = 'DELETE FROM User WHERE username=:user';
        $this->pdo->executeQuery($query, array(':user' => array($username, PDO::PARAM_STR)));
    }

    /**
     * @param string $email
     * @return void
     */
    public function unbanUser(string $email): void
    {
        $query = 'DELETE FROM Blacklist WHERE email=:email';
        $this->pdo->executeQuery($query, array(':email' => array($email, PDO::PARAM_STR)));
    }
}
