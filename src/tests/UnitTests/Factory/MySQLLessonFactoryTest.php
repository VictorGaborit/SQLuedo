<?php

namespace UnitTest\Factory;

use Model\Factory\MySQLLessonFactory;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class MySQLLessonFactoryTest extends TestCase
{
    private MySQLLessonFactory $lessonFactory;
    private string $lastPublisher;
    private string $lastEdit;
    private string $title;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->lessonFactory = new MySQLLessonFactory();
        $this->title = "Title";
        $this->lastEdit = "Last Edit";
        $this->lastPublisher = "Last Publisher";
    }

    /**
     * @return void
     * @throws \Exception
     * @covers \Model\Factory\MySQLLessonFactory::createObject
     */
    public function testCreateObject()
    {
        $id = 1;
        $title = $this->title;
        $content = array();
        $lastPublisher = $this->lastPublisher;
        $lastEdit = $this->lastEdit;
        $lessons = [0 => [
            "id" => $id,
            "title" => $title,
            "content" => $content,
            "last_publisher" => $lastPublisher,
            "last_edit" => $lastEdit
        ], 1 => [
            "id" => $id,
            "title" => $title,
            "content" => $content,
            "last_publisher" => $lastPublisher,
            "last_edit" => $lastEdit
        ]];
        $res = $this->lessonFactory->createObject($lessons);
        foreach ($res as $lesson) {
            assertEquals($id, $lesson->getId());
            assertEquals($title, $lesson->getTitle());
            assertEquals($content, $lesson->getContent());
            assertEquals($lastEdit, $lesson->getLastEdit());
            assertEquals($lastPublisher, $lesson->getLastPublisher());
        }
    }

    /**
     * @return void
     * @throws \Exception
     * @covers \Model\Factory\MySQLLessonFactory::createObject
     */
    public function testCreateObjectWithoutId()
    {
        $title = $this->title;
        $content = array();
        $lastPublisher = $this->lastPublisher;
        $lastEdit = $this->lastEdit;
        $lessons = [0 => [
            "title" => $title,
            "content" => $content,
            "last_publisher" => $lastPublisher,
            "last_edit" => $lastEdit
        ], 1 => [
            "title" => $title,
            "content" => $content,
            "last_publisher" => $lastPublisher,
            "last_edit" => $lastEdit
        ]];
        $res = $this->lessonFactory->createObject($lessons);
        foreach ($res as $lesson) {
            assertEquals(-1, $lesson->getId());
            assertEquals($title, $lesson->getTitle());
            assertEquals($content, $lesson->getContent());
            assertEquals($lastEdit, $lesson->getLastEdit());
            assertEquals($lastPublisher, $lesson->getLastPublisher());
        }
    }

    /**
     * @return void
     * @throws \Exception
     * @covers \Model\Factory\MySQLLessonFactory::createObject
     */
    public function testCreateObjectWithoutTitle()
    {
        try {
            $id = 1;
            $content = array();
            $lastPublisher = $this->lastPublisher;
            $lastEdit = $this->lastEdit;
            $lessons = [0 => [
                "id" => $id,
                "content" => $content,
                "last_publisher" => $lastPublisher,
                "last_edit" => $lastEdit
            ], 1 => [
                "id" => $id,
                "content" => $content,
                "last_publisher" => $lastPublisher,
                "last_edit" => $lastEdit
            ]];
            $res = $this->lessonFactory->createObject($lessons);
        } catch (\Exception $e) {
            assertEquals("La clé 'title' est manquante dans les données de la leçon", $e->getMessage());
        }
    }

    /**
     * @return void
     * @throws \Exception
     * @covers \Model\Factory\MySQLLessonFactory::createObject
     */
    public function testCreateObjectEmptyArray()
    {
        try {
            $lessons = array();
            $res = $this->lessonFactory->createObject($lessons);
        } catch (\Exception $e) {
            assertEquals("Il n'y a pas de données pour cette leçon", $e->getMessage());
        }
    }

    /**
     * @return void
     * @throws \Exception
     * @covers \Model\Factory\MySQLLessonFactory::createObject
     */
    public function testCreateObjectWithOnlyTitle()
    {
        $title = $this->title;
        $lessons = [0 => [
            "title" => $title
        ], 1 => [
            "title" => $title
        ]];
        $res = $this->lessonFactory->createObject($lessons);
        foreach ($res as $lesson) {
            assertEquals($title, $lesson->getTitle());
            assertEquals(-1, $lesson->getId());
            assertEquals(array(), $lesson->getContent());
            assertEquals("Unknown", $lesson->getLastPublisher());
            assertNotNull($lesson->getLastEdit());
        }
    }
}
