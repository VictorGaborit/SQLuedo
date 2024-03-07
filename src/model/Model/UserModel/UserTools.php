<?php

namespace Model\Model\UserModel;

use Model\DAL\Gateway\MySQLUserGateway;

class UserTools
{
    /**
     * Summary : Permet de savoir si un utilisateur existe à partir de son pseudonyme
     * en appelant la méthode findByUsername() de la UserGateway.
     * @param string $username
     * @return bool : Retourne true si l'utilisateur existe et false sinon.
     */
    public static function existUser(string $username): bool
    {
        $gateway = new MySQLUserGateway();
        $res = $gateway->findByUsername($username);
        return !empty($res);
    }

    /**
     * Summary : Vérifie que l'utilisateur est un admin
     * @param string $username : nom de l'utilisateur
     * @return bool
     */
    public static function existAdmin(string $username): bool
    {
        $gateway = new MySQLUserGateway();
        $res = $gateway->findByUsername($username);
        return !empty($res) && $res['is_admin'] == 1;
    }

    /**
     * @return bool
     */
    public static function isUser(): bool
    {
        return $_SESSION['role'] == 'user';
    }

    /**
     * @return bool
     */
    public static function isAdmin(): bool
    {
        return $_SESSION['role'] == 'admin';
    }
}
