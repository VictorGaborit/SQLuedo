<?php

namespace UnitTest\Factory;

use Model\Factory\MySQLParagraphFactory;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Exception;
use function PHPUnit\Framework\assertEquals;

class MySQLParagraphFactoryTest extends TestCase
{
    private $paragraphFactory;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->paragraphFactory = new MySQLParagraphFactory();
    }

    /**
     * @return void
     * @throws \Exception
     * @covers \Model\Factory\MySQLParagraphFactory::createObject
     */
    public function testCreateObject()
    {
        $title = "Title";
        $content = "Content";
        $info = "Info";
        $query = "Query";
        $comment = "Comment";
        $paragraphs = [0 => [
            "paragraph_title" => $title,
            "paragraph_content" => $content,
            "info" => $info,
            "query" => $query,
            "comment" => $comment
        ], 1 => [
        "paragraph_title" => $title,
        "paragraph_content" => $content,
        "info" => $info,
        "query" => $query,
        "comment" => $comment
        ]];
        $res = $this->paragraphFactory->createObject($paragraphs);
        foreach ($res as $paragraph) {
            assertEquals($title, $paragraph->getContentTitle());
            assertEquals($content, $paragraph->getContentContent());
            assertEquals($info, $paragraph->getInfo());
            assertEquals($query, $paragraph->getQuery());
            assertEquals($comment, $paragraph->getComment());
        }
    }

    /**
     * @return void
     * @throws \Exception
     * @covers \Model\Factory\MySQLParagraphFactory::createObject
     */
    public function testCreateObjectEmptyArray()
    {
        try {
            $paragraphs = array();
            $res = $this->paragraphFactory->createObject($paragraphs);
        } catch (\Exception $e) {
            assertEquals("Il n'y a pas de données pour ce paragraphe", $e->getMessage());
        }
    }
}
