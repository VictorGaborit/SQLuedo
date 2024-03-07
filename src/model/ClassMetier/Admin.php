<?php

namespace Model\ClassMetier;

class Admin extends User
{
    /**
     * @param int $id : par défaut à -1 pour que la base de donnnées l'incrémente seule
     * @param bool $isAdmin : 1 pour un admin, 0 pour un utilisateur
     * @param string $username : nom de l'utilisateur
     * @param string $password : mot de passe haché de l'utilisateur
     * @param string $email : adresse email de l'utilisateur
     */
    public function __construct(bool $isAdmin, string $username, string $password, string $email, int $id = -1)
    {
        parent::__construct($isAdmin, $username, $password, $email, $id);
    }
}
