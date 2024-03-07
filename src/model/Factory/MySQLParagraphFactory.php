<?php

namespace Model\Factory;

use Model\ClassMetier\Paragraph;

class MySQLParagraphFactory implements IFactory
{
    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function createObject(array $data): array
    {
        if (empty($data)) {
            throw new \Exception("Il n'y a pas de données pour ce paragraphe");
        }
        $paragraph = array();
        foreach ($data as $row) {
            $paragraph[] = new Paragraph($row['paragraph_title'],
                                         $row['paragraph_content'],
                                         $row['info'],
                                         $row['query'],
                                         $row['comment']
            );
        }
        return $paragraph;
    }
}
