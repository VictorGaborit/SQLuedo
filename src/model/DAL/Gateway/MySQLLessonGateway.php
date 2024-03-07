<?php

namespace Model\DAL\Gateway;

use Model\DAL\Connection;
use PDO;

class MySQLLessonGateway implements ILessonGateway
{
    private Connection $pdo;

    public function __construct()
    {
        global $dsn, $user, $password;
        $this->pdo = new Connection($dsn, $user, $password);
    }

    /**
     * @return array
     */
    public function loadlLessons(): array
    {
        $query = 'SELECT id, title FROM Lesson';
        $this->pdo->executeQuery($query);
        return $this->pdo->getResults();
    }

    /**
     * @param int $id
     * @return array
     */
    public function getLesson(int $id): array
    {
        $query = 'SELECT * FROM Lesson WHERE id = :id';
        $this->pdo->executeQuery($query, array(':id' => array($id, PDO::PARAM_INT)));
        return $this->pdo->getResults()[0];
    }

    /**
     * @param int $id
     * @return array
     */
    public function getContentLesson(int $id): array
    {
        $query = 'SELECT *
                  FROM Paragraph p, ContentLesson c
                  WHERE p.id = c.lesson_part
                  AND c.lesson = :id';
        $this->pdo->executeQuery($query, array(':id' => array($id, PDO::PARAM_INT)));
        return $this->pdo->getResults();
    }
}
