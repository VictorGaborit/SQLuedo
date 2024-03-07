<?php
require_once "vendor/autoload.php";
require_once(__DIR__ . '/config/config.php');
require_once(__DIR__ . '/config/dbConfig.php');
require_once(__DIR__ . '/config/routageConfig.php');

$loader = new \Twig\Loader\FilesystemLoader("view/html");
$twig = new \Twig\Environment($loader, [
    'cache' => false,
    'debug' => true
]);
$twig->addFilter(new \Twig\TwigFilter('url_decode', ['\Model\Tools\Decoder', 'urlDecoder']));
$twig->addFilter(new \Twig\TwigFilter('base64_decode', ['\Model\Tools\Decoder', 'base64Decoder']));
session_start();

$front = new Controller\FrontController();
