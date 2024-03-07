<?php


namespace Controller;

use Exception;
use Model\Tools\Validation;
use Router\AltoRouter;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;

define("METHOD", "GET|POST");

class FrontController
{
    /**
     * Summary : Instancie le bon contrôleur en fonction du rôle de l'utilisateur(connecté,visiteur ou admin)
     * et gère les exceptions levées.
     */
    public function __construct()
    {
        global $errors, $twig, $base_path, $match;
        $loader = new FilesystemLoader("view/html");
        $twig = new Environment($loader, ['cache' => false, 'debug' => true]);
        $twig->addFilter(new TwigFilter('url_decode', ['\Model\Tools\Decoder', 'urlDecoder']));
        $twig->addFilter(new TwigFilter('base64_decode', ['\Model\Tools\Decoder', 'base64Decoder']));

        $twig->addGlobal('base_path', $base_path);

        $router = new AltoRouter();
        $router->setBasePath($base_path);
//Routes Admin
        $router->map(METHOD, '/admin/[i:id]/[a:action]?', 'AdminController');
        $router->map(METHOD, '/admin/[a:action]?', 'AdminController');
        $router->map(METHOD, '/admin/[a:action]/[i:id]?', 'AdminController');
        $router->map(METHOD, '/admin/[a:action]/[i:page]/[i:nbUsers]?', 'AdminController');

//Routes User
        $router->map(METHOD, '/user/[i:id]/[a:action]?', 'UserController');
        $router->map(METHOD, '/user/[a:action]?', 'UserController');
        $router->map(METHOD, '/user/[a:action]/[i:id]?', 'UserController');

//Routes Visitor
        $router->map('GET', '/', 'VisitorController');
        $router->map(METHOD, '/visitor/[a:action]?', 'VisitorController');
        $router->map(METHOD, '/visitor/[a:action]?/[i:id]?', 'VisitorController');
        $match = $router->match();

        $controller = $match['target'] ?? null;
        if (isset($match['params']['action'])) {
            $action = Validation::validActionRole($match['params']['action']);
        } else {
            $action = 'init';
        }
        $controller = '\\Controller\\' . $controller;
        $controller = new $controller();
        try {
            if ($controller instanceof VisitorController) {
                $this->callController($controller, $action, $match);
            } else {
                if ($controller->isConnected()) {
                    $this->callController($controller, $action, $match);
                } else {
                    $this->callController($controller, "init", $match);
                }
            }
        } catch (Exception $e2) {
            $errorType[] = $errors['pdo'];
            $errorDetails = $e2->getMessage();
            global $twig;
            $data = ([
                "errorType" => $errorType,
                "errorDetails" => $errorDetails,]);
            echo $twig->render("error.html", $data);
        }
    }

    /**
     * @throws Exception
     */
    private function callController($controller, $action, $match): void
    {
        if ($action == null) {
            $action = 'init';
        }
        if (is_callable(array($controller, $action))) {
            call_user_func_array(array($controller, $action), array($match['params']));
        } else {
            throw new Exception('This method is not implemented');
        }
    }
}
