<?php

namespace Model\Factory;

use Model\ClassMetier\Inquiry;

class MySQLInquiryFactory implements IFactory
{

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function createObject(array $data): array
    {
        if (empty($data)) {
            throw new \Exception("Il n'y a pas de données pour cette enquête");
        }
        $inquiryTab = array();
        foreach ($data as $row) {
            $inquiryTab[] = new Inquiry($row['id'], $row['title'], $row['description'], $row['is_user']);
        }
        return $inquiryTab;
    }
}
