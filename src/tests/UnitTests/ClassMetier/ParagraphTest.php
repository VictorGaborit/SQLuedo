<?php

namespace UnitTest\ClassMetier;

use Model\ClassMetier\Paragraph;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertEquals;

class ParagraphTest extends TestCase
{

    /**
     * @covers Paragraph::__construct()
     */
    public function testConstruct()
    {
        $title = "Paragraphe";
        $content = "Cotenu";
        $infos = "Informations";
        $query = "Query";
        $comment = "Commentaire";
        $paragraph = new Paragraph($title, $content, $infos, $query, $comment);
        assertNotNull($paragraph);
        assertEquals($title, $paragraph->getContentTitle());
        assertEquals($content, $paragraph->getContentContent());
        assertEquals($infos, $paragraph->getInfo());
        assertEquals($query, $paragraph->getQuery());
        assertEquals($comment, $paragraph->getComment());
    }
}
