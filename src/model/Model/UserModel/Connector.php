<?php

namespace Model\Model\UserModel;

use Exception;
use Model\DAL\Gateway\IUserGateway;
use Model\DAL\Gateway\MySQLUserGateway;
use Model\Factory\IFactory;
use Model\Factory\MySQLUserFactory;
use Model\Tools\Validation;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Connector implements IConnector
{

    private IUserGateway $gateway;
    private IFactory $mysqlUserFactory;

    /**
     *
     */
    public function __construct()
    {
        $this->gateway = new MySQLUserGateway();
        $this->mysqlUserFactory = new MySQLUserFactory();
    }

    /**
     * Summary : Permet de déconnecter un administrateur.
     * @return bool : Retourne true si la déconnexion s'est bien passée et false sinon.
     */
    public static function logout(): bool
    {
        session_unset();
        session_destroy();
        $_SESSION = array();
        return true;
    }

    /**
     * Summary : Permet de savoir si un utilisateur est connecté.
     * @return bool : Retourne true si 'lutilisateur est connecté et false sinon
     */
    public function isConnected(): bool
    {
        if (isset($_SESSION['id'])) {
            return true;
        }
        return false;
    }

    /**
     * Summary : Permet à un utilisateur de se connecter.
     * Vérifie l'intégrité des informations entrées,
     * vérifie si l'utilisateur existe, récupère ses informations
     * et attribue des variables de session avec son id, son pseudo, son email et son statut.
     * @return bool : Retourne true si la connection se passe bien et false sinon.
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function login(): bool
    {
        $pseudo = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        if (!isset($pseudo) || !Validation::validStr($pseudo)) {
            $this->redirectLoginToError("Erreur, vous n'avez pas inséré de pseudo ou son format est incorrect");
        } elseif (!isset($password) || !Validation::validPassword($password)) {
            $this->redirectLoginToError("Erreur, vous n'avez pas inséré de mot de passe ou son format est incorrect.");
        }
        if (UserTools::existUser($pseudo)) {
            $res = $this->gateway->findByUsername($pseudo);
            if (password_verify($password, $res['password'])) {
                if (UserTools::existAdmin($pseudo)) {
                    $_SESSION['role'] = 'admin';
                } else {
                    $_SESSION['role'] = 'user';
                }
                $_SESSION['username'] = $pseudo;
                $_SESSION['email'] = $res['email'];
                $_SESSION['id'] = $res['id'];
                return true;
            }
            $this->redirectLoginToError("Erreur, vous avez inséré le mauvais mot de passe.");
        }
        $this->redirectLoginToError("Erreur, aucun compte n'est relié à ce nom d'utilisateur.");
        return false;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function redirectLoginToError($message): void
    {
        global $twig;
        $errorDetails = base64_encode($message);
        $data = (["error" => $errorDetails,]);
        echo $twig->render("home.html", $data);
    }

    /**
     * Summary : Permet à un utilisateur de s'inscrire. Vérifie l'intégrité des informations issues du formulaire,
     *  vérifie si le pseudo ou l'email ne snt pas déjà utilisés, insère l'utilisateur dans la base de données
     *  avec la méthode insertNewUser() de la UserGateway et attribue les variables de session.
     * @return bool
     * @throws Exception
     */
    public function registration(): bool
    {
        $strMaxLength = 40;
        $login = Validation::validStr($_REQUEST['username']);
        $password = $_REQUEST['password'];
        $email = $_REQUEST['email'];
        if (Validation::verifRemplissageFormulaire()) {
            if (!(Validation::validPassword($password))) {
                $this->redirectRegistrationToError("Mot de passe : 8 caractères minimum, au moins une majuscule");
                return false;
            }
            if (strlen($login) < $strMaxLength) {
                $user = $this->gateway->findByUsername($login);
                $userEmail = $this->gateway->findByEmail($email);
                $ban = $this->gateway->findBanByEmail($email);
                if ($user == null && $userEmail == null && $ban == null) {
                    $user = $this->mysqlUserFactory->createObject([[
                        'isAdmin' => false,
                        'username' => $login,
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                        'email' => $email]])[0];
                    $this->gateway->insertNewUser($user);
                    $res = $this->gateway->findByUsername($login);
                    $user = $this->mysqlUserFactory->createObject([[
                        'isAdmin' => $res['is_admin'],
                        'username' => $res['username'],
                        'password' => $res['password'],
                        'email' => $res['email'],
                        'id' => $res['id']]])[0];
                    $_SESSION['role'] = 'user';
                    $_SESSION['username'] = $user->getUsername();
                    $_SESSION['email'] = $user->getEmail();
                    $_SESSION['id'] = $user->getId();
                    return true;
                } elseif ($user != null) {
                    $this->redirectRegistrationToError("Login déjà utilisé");
                } elseif ($ban != null) {
                    $this->redirectRegistrationToError("Cette adresse email a été bannie jusqu'au " .
                        date('d-m-Y', strtotime($ban['expiration_date'])));
                } else {
                    $this->redirectRegistrationToError("Un compte est déjà attribuée à cette adresse mail");
                }
            } else {
                $this->redirectRegistrationToError("Pseudonyme limité à 40 caractères");
            }
        }
        else {
            $this->redirectRegistrationToError("Erreur, l'inscritpion a échoué");
        }
        return false;
    }

    /**
     * @param $message
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function redirectRegistrationToError($message): void
    {
        global $twig;
        $errorDetails = base64_encode($message);
        $data = (["error" => $errorDetails,]);
        echo $twig->render("inscription.html", $data);
    }
}
