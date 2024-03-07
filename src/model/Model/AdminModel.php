<?php

namespace Model\Model;

use Model\DAL\Gateway\IAdminGateway;
use Model\DAL\Gateway\MySQLAdminGateway;

class AdminModel
{
    private IAdminGateway $gateway;

    /**
     *
     */
    public function __construct()
    {
        $this->gateway = new MySQLAdminGateway();
    }

    /**
     * @return bool
     */
    public static function isAdmin(): bool
    {
        return $_SESSION['role'] == 'admin';
    }

    /**
     * Summary : Vérifie que l'utilisateur est un admin
     * @param string $username : nom de l'utilisateur
     * @return bool
     */
    public function existeAdmin(string $username): bool
    {
        $res = $this->gateway->findByUsername($username);
        return !empty($res) && $res['isAdmin'] == 1;
    }

    /**
     * @return int
     */
    public function getNbUsers(): int
    {
        return $this->gateway->getNbUsers();
    }

    /**
     * @return int
     */
    public function getNbUsersBan(): int
    {
        return $this->gateway->getNbUsersBan();
    }

    /**
     * Summary : Permet de récupérer la liste de tous les utilisateurs non-admins sous forme de liste.
     * @return array : contient la liste d'utilisateurs n'étant pas des admins
     */
    public function printUsers($nbUser, $numeroPage): array
    {
        $decalage = ($numeroPage - 1) * $nbUser;
        if ($decalage < 0) {
            $decalage = 0;
        }
        return $this->gateway->printUsersList($nbUser, $decalage);
    }

    /**
     * @param $nbUser
     * @param $numeroPage
     * @return array
     */
    public function printUsersBan($nbUser, $numeroPage): array
    {
        $decalage = ($numeroPage - 1) * $nbUser;
        if ($decalage < 0) {
            $decalage = 0;
        }
        return $this->gateway->printUsersListBan($nbUser, $decalage);
    }

    /**
     * Summary : Permet à un administrateur de supprimer un utilisateur à partir de son pseudonyme
     * en faisant appel à la méthode deleteByUsername() de AdminGateway.
     * @param string $username : nom de l'utilisateur à supprimer
     * @return void
     */
    public function deleteUser(string $username): void
    {
        $this->gateway->deleteByUsername($username);
    }

    /**
     * Summary : Permet à un administrateur de promouvoir un utilisateur au rang d'administrateur
     * à partir de son pseudonyme en appelant la méthode promoteUser() de AdminGateway.
     * @param string $username : nom de l'utilisateur à promouvoir en admin
     * @return void
     */
    public function promoteUser(string $username): void
    {
        $this->gateway->promoteUser($username);
    }

    /**
     * Summary : Permet à un administrateur de bannir un utilisateur à partir de son pseudonyme
     * en appelant la méthode banUser() de AdminGateway
     * @param string $username : nom de l'utilisateur à bannir
     * @return void
     */
    public function banUser(string $username): void
    {
        $this->gateway->banUser($username);
    }

    /**
     * @param string $email
     * @return void
     */
    public function unbanUser(string $email): void
    {
        $this->gateway->unbanUser($email);
    }
}
