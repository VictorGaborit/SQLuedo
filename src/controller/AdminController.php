<?php

namespace Controller;

use Model\Model\AdminModel;
use Model\Model\UserModel\Connector;
use Model\Model\UserModel\UserTools;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AdminController extends UserController
{
    /**
     * @param array $params
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function deleteUser(array $params)
    {
        global $twig;
        $model = new AdminModel();
        $nbUsers = $this->setNbUsers($params);
        $pageNumber = $this->setNumPage($params);
        if (isset($_POST['toDelete'])) {
            $model->deleteUser($_POST['toDelete']);
        }
        $users = $model->printUsers($nbUsers, $pageNumber);
        $data = (['users' => $users, 'pageNumber' => $pageNumber, 'nbUsersDefault' => $nbUsers,]);
        echo $twig->render('printusers.html', $data);
    }


    /**
     * @param array $params
     * @return int
     */
    private function setNbUsers(array $params): int
    {
        return $params['nbUsers'] ?? $this->getNbUsersDefault();
    }

    /**
     * @return int
     */
    private function getNbUsersDefault(): int
    {
        return 20;
    }

    /**
     * @param array $params
     * @return int
     */
    private function setNumPage(array $params): int
    {
        return $params['page'] ?? $this->getNumPageDefault();
    }

    /**
     * @return int
     */
    private function getNumPageDefault(): int
    {
        return 1;
    }

    /**
     * Summary : la méthode prépare les données de la page AfficherUtilisateur et l'appelle
     * @param array $params
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function printUsers(array $params): void
    {
        $model = new AdminModel();
        $nbUsers = $params['nbUsers'] ?? 10; // Valeur par défaut si non défini
        $pageNumber = $params['page'] ?? 1; // Valeur par défaut si non défini
        global $twig;
        if ($pageNumber <= 0) {
            $pageNumber = 1;
        }
        $maxNumberPage = intdiv($model->getNbUsers(), $nbUsers);
        if ($maxNumberPage == 0) {
            $maxNumberPage = 1;
        }
        if ($pageNumber > $maxNumberPage) {
            $pageNumber = $maxNumberPage;
        }
        $users = $model->printUsers($nbUsers, $pageNumber);
        $data = ([
            'role' => 'admin',
            'users' => $users,
            'pageNumber' => $pageNumber,
            'nbUsers' => $nbUsers,
            'nbPages' => $maxNumberPage,
            'nbUsersDefault' => $nbUsers,]);
        echo $twig->render('printusers.html', $data);
    }

    /**
     * @param array $params
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function promoteUser(array $params)
    {
        global $twig;
        $model = new AdminModel();
        $nbUsers = $this->setNbUsers($params);
        $pageNumber = $this->setNumPage($params);
        if (isset($_POST['toPromote'])) {
            $model->promoteUser($_POST['toPromote']);
        }
        $users = $model->printUsers($nbUsers, $pageNumber);
        $data = (['users' => $users, 'pageNumber' => $pageNumber, 'nbUsersDefault' => $nbUsers,]);
        echo $twig->render('printusers.html', $data);
    }

    /**
     * @param array $params
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function banUser(array $params)
    {
        global $twig;
        $model = new AdminModel();
        $nbUsers = $this->setNbUsers($params);
        $pageNumber = $this->setNumPage($params);
        if (isset($_POST['toBan'])) {
            $model->banUser($_POST['toBan']);
        }
        $users = $model->printUsers($nbUsers, $pageNumber);
        $data = ([
            'users' => $users,
            'pageNumber' => $pageNumber,
            'nbUsersDefault' => $nbUsers,]);
        echo $twig->render('printusers.html', $data);
    }

    /**
     * @param array $params
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function unbanUser(array $params)
    {
        global $twig;
        $model = new AdminModel();
        $nbUsers = $this->setNbUsers($params);
        $pageNumber = $this->setNumPage($params);
        if (isset($_POST['toUnban'])) {
            $model->unbanUser($_POST['toUnban']);
        }
        $users = $model->printUsersBan($nbUsers, $pageNumber);
        $data = ([
            'users' => $users,
            'pageNumber' => $pageNumber,
            'nbUsersDefault' => $nbUsers,]);
        echo $twig->render('printusersban.html', $data);
    }

    /**
     * Summary : la méthode prépare les données de la page AfficherUtilisateurBan et l'appelle
     * @param $params
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function printUsersBan($params): void
    {
        $model = new AdminModel();
        $nbUsers = $params['nbUsers'] ?? 10; // Valeur par défaut si non défini
        $pageNumber = $params['page'] ?? 1; // Valeur par défaut si non défini
        global $twig;
        if ($pageNumber <= 0) {
            $pageNumber = 1;
        }
        $maxNumberPage = intdiv($model->getNbUsersBan(), $nbUsers);
        if ($maxNumberPage == 0) {
            $maxNumberPage = 1;
        }
        if ($pageNumber > $maxNumberPage) {
            $pageNumber = $maxNumberPage;
        }
        $users = $model->printUsersBan($nbUsers, $pageNumber);
        $data = ([
            'role' => 'admin',
            'users' => $users,
            'pageNumber' => $pageNumber,
            'nbUsers' => $nbUsers,
            'nbPages' => $maxNumberPage,
            'nbUsersDefault' => $nbUsers,]);
        echo $twig->render('printusersban.html', $data);
    }

    /**
     * @return bool
     */
    public function isConnected(): bool
    {
        $modelCon = new Connector();
        return $modelCon->isConnected() && UserTools::isAdmin();
    }
}
