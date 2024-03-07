<?php declare(strict_types=1);

namespace UnitTest\ClassMetier;

use Model\ClassMetier\Lesson;
use PHPUnit\Framework\TestCase;

class LessonTest extends TestCase
{
    private $lastEdit;
    private $lastPublisher;
    private $title;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->lastEdit = "Last edit";
        $this->lastPublisher = "Last publisher";
        $this->title = "Title";
    }

    /**
     * @covers Lesson::__construct
     */
    public function testConstruct()
    {
        $title = $this->title;
        $lastEdit = $this->lastEdit;
        $lastPublisher = $this->lastPublisher;
        $content = [];
        $id = 1;

        $lesson = new Lesson($title, $lastEdit, $lastPublisher, $content, $id);

        $this->assertEquals($title, $lesson->getTitle());
        $this->assertEquals($lastEdit, $lesson->getLastEdit());
        $this->assertEquals($lastPublisher, $lesson->getLastPublisher());
        $this->assertEquals($content, $lesson->getContent());
        $this->assertEquals($id, $lesson->getId());
    }

    /**
     * @covers Lesson::__construct
     */
    public function testConstructWithoutLastEdit()
    {
        $title = $this->title;
        $lastPublisher = $this->lastPublisher;
        $content = [];
        $id = 1;

        $lesson = new Lesson($title, null, $lastPublisher, $content, $id);
        $this->assertEquals($title, $lesson->getTitle());
        $this->assertEquals(date('l jS \of F Y h:i:s A'), $lesson->getLastEdit());
        $this->assertEquals($lastPublisher, $lesson->getLastPublisher());
        $this->assertEquals($content, $lesson->getContent());
        $this->assertEquals($id, $lesson->getId());
    }

    /**
     * @covers Lesson::__construct
     */
    public function testConstructWithoutLastPublisher()
    {
        $title = $this->title;
        $lastEdit = $this->lastEdit;
        $content = [];
        $id = 1;

        $lesson = new Lesson($title, $lastEdit, null, $content, $id);
        $this->assertEquals($title, $lesson->getTitle());
        $this->assertEquals($lastEdit, $lesson->getLastEdit());
        $this->assertEquals("Unknown", $lesson->getLastPublisher());
        $this->assertEquals($content, $lesson->getContent());
        $this->assertEquals($id, $lesson->getId());
    }

    /**
     * @covers Lesson::__construct
     */
    public function testConstructWithoutContent()
    {
        $title = $this->title;
        $lastEdit = $this->lastEdit;
        $lastPublisher = $this->lastPublisher;
        $id = 1;

        $lesson = new Lesson($title, $lastEdit, $lastPublisher, null, $id);
        $this->assertNotNull($lesson);
        $this->assertEquals($title, $lesson->getTitle());
        $this->assertEquals($lastEdit, $lesson->getLastEdit());
        $this->assertEquals($lastPublisher, $lesson->getLastPublisher());
        $this->assertEquals(array(), $lesson->getContent());
        $this->assertEquals($id, $lesson->getId());
    }

    /**
     * @covers Lesson::getTitle
     */
    public function testGetTitle()
    {
        $titre = $this->title;
        $lastEdit = $this->lastEdit;
        $lastPublisher = $this->lastPublisher;
        $content = [];
        $id = 1;

        $lesson = new Lesson($titre, $lastEdit, $lastPublisher, $content, $id);

        $this->assertNotNull($lesson);
        $this->assertEquals($titre, $lesson->getTitle());
    }

    /**
     * @covers Lesson::getId
     */
    public function testGetId()
    {
        $titre = $this->title;
        $lastEdit = $this->lastEdit;
        $lastPublisher = $this->lastPublisher;
        $content = [];
        $id = 1;

        $lesson = new Lesson($titre, $lastEdit, $lastPublisher, $content, $id);

        $this->assertNotNull($lesson);
        $this->assertEquals($id, $lesson->getId());
    }

}
