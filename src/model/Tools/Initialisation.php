<?php

namespace Model\Tools;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Initialisation
{
    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public static function initialisation(): void
    {
        global $twig;
        echo $twig->render('home.html');
    }
}
