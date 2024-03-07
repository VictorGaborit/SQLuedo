<?php

namespace Controller;

use Exception;
use Model\DAL\Gateway\MySQLSuccessGateway;
use Model\Model\InquiryModel;
use Model\Model\LessonModel;
use Model\Model\NotepadModel;
use Model\Model\UserModel\Connector;
use Model\Model\UserModel\ProfileEditor;
use Model\Model\UserModel\UserTools;
use Model\Tools\Initialisation;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UserController extends VisitorController
{
    /**
     * @throws Exception
     */
    public function choice(InquiryModel $model): void
    {
        global $twig;
        $model->loadInquiries();
        $data = ['list' => $model->getInquiries(), 'title' => 'des enquêtes', 'role' => 'user',];
        echo $twig->render('inquirieschoice.html', $data);
    }

    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function logout()
    {
        $modelCon = new Connector();
        if ($modelCon->logout()) {
            Initialisation::initialisation(); // Si la déconnexion fonctionne, renvoie à la page de connexion
        }
    }

    /**
     * @return bool
     */
    public function isConnected(): bool
    {
        $modelCon = new Connector();
        return $modelCon->isConnected() && UserTools::isUser();
    }

    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function update()
    {
        global $twig;
        $profileModel = new ProfileEditor();
        $profileModel->editProfile($_REQUEST['username'], $_REQUEST['email']);
        $data = (["username" => $_SESSION['username'], "email" => $_SESSION['email'],]);
        echo $twig->render("profile.html", $data);
    }

    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function profil()
    {
        global $twig;
        $data = (["username" => $_SESSION['username'], "email" => $_SESSION['email'],]);
        echo $twig->render("profile.html", $data);
    }

    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function menu()
    {
        global $twig;
        $data = (["isAdmin" => $_SESSION['role'] == 'admin', "username" => $_SESSION['username'],]);
        echo $twig->render("menu.html", $data);
    }

    /**
     * @param array $params
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function investigate(array $params)
    {
        global $twig;
        $inquiryModel = new InquiryModel();
        $notepadModel = new NotepadModel();
        $gateway = new MySQLSuccessGateway();
        $inquiry = $inquiryModel->findInquiry($params['id']);
        $user = $_SESSION['id'];
        $notes = $notepadModel->loadNotes($params['id'], $user);
        $success = $gateway->findById();
        $_SESSION['inquiryId'] = $params['id'];
        $data = ([
            "role" => $_SESSION['role'],
            "inquiry" => $inquiry,
            "userId" => $user,
            "notePad" => $notes,
            "success1" => $success]);
        echo $twig->render("inquiry.html", $data);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function saveNotes()
    {
        $notepadModel = new NotepadModel();
        $inquiryId = $_POST['inquiryId'];
        $notepad = $_POST['notepad'];
        $userId = $_POST['userId'];
        $notepadModel->save($notepad, $inquiryId, $userId);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function studyLesson()
    {
        global $twig;
        $modelLesson = new LessonModel();
        $data = ['title' => 'des leçons', 'list' => $modelLesson->loadLessons(),];
        try {
            echo $twig->render('lessonschoice.html', $data);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * @param array $params
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function readLesson(array $params)
    {
        global $twig;
        $modelLesson = new LessonModel();
        $idTitle = $params['id'];
        $lesson = $modelLesson->getLesson($idTitle);
        echo $twig->render('lesson.html', ['lesson' => $lesson]);
    }
}
