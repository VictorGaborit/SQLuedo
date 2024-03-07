<?php

namespace Model\Model;

use Exception;
use Model\ClassMetier\Lesson;
use Model\DAL\Gateway\ILessonGateway;
use Model\DAL\Gateway\MySQLLessonGateway;
use Model\Factory\IFactory;
use Model\Factory\MySQLLessonFactory;
use Model\Factory\MySQLParagraphFactory;

class LessonModel
{
    private ILessonGateway $gateway;
    private IFactory $lessonFactory;
    private IFactory $paragraphFactory;

    /**
     *
     */
    public function __construct()
    {
        $this->gateway = new MySQLLessonGateway();
        $this->lessonFactory = new MySQLLessonFactory();
        $this->paragraphFactory = new MySQLParagraphFactory();
    }

    /**
     * @throws Exception
     */
    public function loadLessons(): array
    {
        $res = $this->gateway->loadlLessons();
        return $this->lessonFactory->createObject($res);
    }

    /**
     * @throws Exception
     */
    public function getLesson(int $id): Lesson
    {
        $lessonData = array($this->gateway->getLesson($id));
        $lesson = $this->lessonFactory->createObject($lessonData);
        if ($lesson[0] instanceof Lesson) {
            $lesson[0]->setContent($this->createParagraphs($id));
        }
        return $lesson[0];
    }

    /**
     * @throws Exception
     */
    private function createParagraphs(int $id): array
    {
        $contentData = $this->gateway->getContentLesson($id);
        return $this->paragraphFactory->createObject($contentData);
    }
}
