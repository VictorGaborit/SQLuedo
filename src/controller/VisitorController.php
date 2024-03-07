<?php

namespace Controller;

use Exception;
use Model\DAL\Gateway\MySQLInquiryGateway;
use Model\DAL\Gateway\MySQLSuccessGateway;
use Model\DAL\Gateway\MySQLGameGateway;
use Model\Factory\MySQLInquiryFactory;
use Model\Model\NotepadModel;
use Model\Model\InquiryModel;
use Model\Model\GameModel;
use Model\Model\UserModel\Connector;
use Model\Tools\Initialisation;
use Model\Tools\Validation;
use PDOException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use View\Html;

class VisitorController
{

    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function init()
    {
        $connector = new Connector();
        global $twig;
        if ($connector->isConnected()) {
            $data = ['username' => $_SESSION['username'], 'isAdmin' => $_SESSION['role'] == 'admin',];
            echo $twig->render("menu.html", $data);
        } else {
            echo $twig->render("home.html");
        }
    }

    /**
     * Summary : Vérifie que les entrées de l'utilisateur pour se connecter sont correctes
     * et appelle la méthode login() du UserModel. En cas d'erreur, lève des exceptions.
     * @return void
     * @throws Exception
     */
    public function login()
    {
        global $twig;
        $modelCon = new Connector();
        if ($modelCon->login()) {
            $data = ['username' => $_REQUEST['username'], 'isAdmin' => $_SESSION['role'] == 'admin',];
            echo $twig->render('menu.html', $data);
        }
    }

    /**
     * Summary : Vérifie que le formulaire a été correctement rempli
     * et appelle la méthode registration du UserModel. En cas d'erreur, lève une exception.
     * @return void
     * @throws Exception
     */
    public function registration()
    {
        global $twig;
        $modelCon = new Connector();
        if ($modelCon->registration()) {
            $data = ['username' => $_REQUEST['username'],];
            echo $twig->render('menu.html', $data);
        }
        exit;
    }

    /**
     * Summary : Permet de préparer le nécessaire pour que l'utilisateur commence à jouer.
     * Charge les enquêtes et affiche la vue de choix d'enquête.
     * @return void
     * @throws Exception
     */
    public function play(): void
    {
        global $twig;
        $model = new InquiryModel();
        $gateway = new MySQLSuccessGateway();
        $inquiries = $model->loadInquiries();
        if (isset($_SESSION['id'])) {
            $success1 = $gateway->loadSuccess($_SESSION['id']);
            $data = ['success1' => $success1,];
        }
        $data['list'] = $inquiries;
        $data['role'] = $_SESSION['role'] ?? 'visitor';
        $data['title'] = 'des enquêtes';
        echo $twig->render('inquirieschoice.html', $data);
    }

    /**
     * @param array $params
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function check(array $params): void
    {
        global $twig;
        $model = new InquiryModel();
        $gateway = new MySQLInquiryGateway();
        $successGateway = new MySQLSuccessGateway();
        $inquiryFactory = new MySQLInquiryFactory();
        $id = $params['id'];
        $model->loadInquiries();
        $inquiries = $gateway->findById($id);
        $inquiryTab = $inquiryFactory->createObject([[
            'id' => $inquiries['id'],
            'title' => $inquiries['title'],
            'description' => $inquiries['description'],
            'is_user' => $inquiries['is_user']]]);
        $solution = $gateway->findSolution($inquiryTab[0]);
        $prenomTueur = $solution['murder_first_name'];
        $murderName = $solution['murder_name'];
        $place = $solution['place'];
        $arme = $solution['murder_weapon'];
        if (strtolower($_REQUEST['murder_first_name']) == strtolower($prenomTueur)
            && strtolower($_REQUEST['murder_name']) == strtolower($murderName)
            && strtolower($_REQUEST['place']) == strtolower($place)
            && strtolower($_REQUEST['object']) == strtolower($arme)) {
            if (isset($_SESSION['role']) && $_SESSION['role'] != 'visitor') {
                $successGateway->addSuccess($_SESSION['inquiryId'], $_SESSION['id']);
                // SAVE BD SUCCESS
            }
            $success1 = $successGateway->findById();
            $data = [
                'list' => $model->getInquiries(),
                'title' => 'des enquêtes',
                'role' => $_SESSION['role'] ?? 'visitor',
                'animationClass' => 'success',
                'success' => 1, 'success1' => $success1,];
            echo $twig->render('inquirieschoice.html', $data);
        } else {
            $inquiry = $model->findInquiry($id);
            $data = (["inquiry" => $inquiry, 'role' => $_SESSION['role'] ?? 'visitor', 'numInq' => $id,]);
            echo $twig->render("inquiry.html", $data);
        }
    }
    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function register()
    {
        global $twig;
        $data = [];
        echo $twig->render("inscription.html", $data);
    }

    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function recoverpw()
    {
        global $twig;
        $data = [];
        echo $twig->render("resetpasswd.html", $data);
    }

    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendmail()
    {
        include_once 'view/html/EnvoiMail.php';
        Initialisation::initialisation();
    }

    /**
     * @param array $params
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function investigate(array $params)
    {
        global $twig;
        $modelEn = new InquiryModel();
        $inquiry = $modelEn->findInquiry($params['id']);
        $notes = $_COOKIE['notes'] ?? null;
        $_SESSION['inquiryId'] = $params['id'];
        $data = (["role" => 'visitor', "inquiry" => $inquiry, "notePad" => $notes]);
        echo $twig->render("inquiry.html", $data);
    }

    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function request()
    {
        global $twig;
        $modelEn = new InquiryModel();
        $connector = new Connector();
        $notepadModel = new NotepadModel();
        try {
            $base = $modelEn->getBaseNumber($_SESSION['inquiryId']);
            $gameModel = new GameModel(new MySQLGameGateway($_SESSION['inquiryId'], $base));
            if ($connector->isConnected()) {
                $notes = $notepadModel->loadNotes($_SESSION['inquiryId'], $_SESSION['id']);
                $user = $_SESSION['id'];
            }
            if (Validation::validRequest($_REQUEST['request'])) {
                $request = $_REQUEST['request'];
                $gameModel->executeQuery($request);
                $res = $gameModel->getResults();
                $data = ([
                    "inquiry" => $modelEn->findInquiry($_SESSION['inquiryId']),
                    "result" => $res,
                    "notePad" => $notes,
                    "userId" => $user,
                    "request" => $_REQUEST['request'],
                    'role' => $_SESSION['role'],
                    'numInq' => $_SESSION['inquiryId'],]);
                echo $twig->render("inquiry.html", $data);
            }
            exit;

        } catch (PDOException $e) {
            $data = ([
                "inquiry" => $modelEn->findInquiry($_SESSION['inquiryId']),
                "error" => $e->getMessage(),
                "request" => $_REQUEST['request'],
                'role' => $_SESSION['role'],
                'numInq' => $_SESSION['inquiryId'],]);
            echo $twig->render("inquiry.html", $data);
        }
    }
}
