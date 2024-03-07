<?php

namespace Model\Tools;

use Exception;

class Validation
{
    /**
     * Summary : Permet de vérifier si l'action d'un utilisateur existe ou si elle n'est pas vide.
     * @param $action
     * @return string|null : Retourne l'action si le processus se passe bien ou null sinon.
     */
    public static function validActionRole($action): ?string
    {
        return (!empty($action)) ? $action : null;
    }

    /**
     * Summary : Vérifie si un mot de passe a une longueur d'au moins 8 caractères
     * et s'il possède au moins une majuscule.
     * @param $password
     * @return bool : Retourne true si tout se passe bien et false sinon.
     */
    public static function validPassword($password): bool
    {
        $minStringLength = 8;
        if (strlen($password) < $minStringLength) {
            return false;
        }
        // Vérifie la présence d'au moins une lettre majuscule
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }
        return true;
    }

    /**
     * Summary : Vérifie si les entréees de l'utilisateur dans le formulaire d'inscription sont correctes.
     * Si ce n'est pas le cas, lève une exception.
     * @return bool : Retourne un booléen pour dire si le formulaire d'inscription est correctement rempli ou non.
     * @throws Exception
     */
    public static function verifRemplissageFormulaire(): bool
    {
        if (!isset($_REQUEST['username']) || !Validation::validStr($_REQUEST['username'])) {
            throw new Exception("Erreur, vous n'avez pas inséré de pseudo ou son format est incorrecte");
        } elseif (!isset($_REQUEST['email']) || !Validation::validEmail($_REQUEST['email'])) {
            throw new Exception("Erreur, vous n'avez pas inséré d'email ou son format est incorrect");
        } elseif (!isset($_REQUEST['password']) || !Validation::validStr($_REQUEST['password'])) {
            throw new Exception("Erreur, vous n'avez pas inséré de mot de passe ou son format est incorrect");
        }
        return true;
    }


    /**
     * Summary : Permet de vérifier si le format d'une chaine de caractères est bon ou non.
     * @param $str
     * @return false|string : Retourne la chaine nettoyée si le processus se passe bien et false sinon.
     */
    public static function validStr($str)
    {
        if (isset($str) && $str !== "") {
            return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
        } else {
            return false;
        }
    }

    /**
     * Summary : Permet de vérifier si le format d'une adresse email est correct.
     * @param $email
     * @return bool : Retourne l'email nettoyé si le processus se passe bien et false sinon.
     */
    public static function validEmail($email): bool
    {
        return isset($email) && trim($email) !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) !== false;

    }

    /**
     * @param string|null $request
     * @return bool
     */
    public static function validRequest(?string $request): bool
    {
        return !empty($request);
    }
}
