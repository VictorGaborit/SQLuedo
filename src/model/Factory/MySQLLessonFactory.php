<?php

namespace Model\Factory;

use Exception;
use Model\ClassMetier\Lesson;

class MySQLLessonFactory implements IFactory
{

    /**
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function createObject(array $data): array
    {
        if (empty($data)) {
            throw new \Exception("Il n'y a pas de données pour cette leçon");
        }
        $tabLesson = array();
        foreach ($data as $row) {
            if (isset($row['title'])) {
                $title = $row['title'];
            } else {
                throw new \Exception("La clé 'title' est manquante dans les données de la leçon");
            }
            $lastEdit = $row['last_edit'] ?? null;
            $lastPublisher = $row['last_publisher'] ?? null;
            $lessonId = $row['id'] ?? null;
            $content = $row['content'] ?? array();
            if ($lessonId !== null) {
                $tabLesson[] = new Lesson($title, $lastEdit, $lastPublisher, $content, $lessonId);
            } else {
                $tabLesson[] = new Lesson($title, $lastEdit, $lastPublisher, $content);
            }
        }
        return $tabLesson;
    }
}
