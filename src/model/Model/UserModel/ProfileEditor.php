<?php

namespace Model\Model\UserModel;

use Exception;
use Model\DAL\Gateway\IUserGateway;
use Model\DAL\Gateway\MySQLUserGateway;
use Model\Tools\Validation;

class ProfileEditor implements IProfileEditor
{
    private IUserGateway $gateway;

    public function __construct()
    {
        $this->gateway = new MySQLUserGateway();
    }

    /**
     * Summary : Permet à un utilisateur d'éditer son profil.
     * Vérifie l'intégrité des informations entrées,
     * regarde si le nouveau pseudo ou le nouvel email n'est pas déjà utilisé,
     * fait la mise à jour avec la méthode updateById() de la UserGateway
     * et met à jour les variables de session.
     * @param string $username
     * @param string $email
     * @return void : Retourne true si la mise à jour se passe bien et false sinon.
     * @throws Exception : Lève des exception en cas de problème.
     */
    public function editProfile(string $username, string $email): void
    {
        if (Validation::validStr($username) && Validation::validEmail($email)) {
            if (($username == $_SESSION['username']
                    && $this->gateway->findByEmail($email) == null)
                || (!UserTools::existUser($username)
                    && $email == $_SESSION['email'])
                || (!UserTools::existUser($username)
                    && $this->gateway->findByEmail($email) == null)) {
                $this->gateway->updateById($_SESSION['id'], $username, $email);
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
            } else {
                throw new Exception("Le pseudo ou l'email que vous avez entré est déjà utilisé");
            }
        } else {
            throw new Exception("Le pseudo ou l'email entré n'est pas correct");
        }
    }
}
