<?php

namespace Model\Factory;

use Model\ClassMetier\Notepad;

class MySQLNotepadFactory implements IFactory
{

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function createObject(array $data): array
    {
        if (empty($data)) {
            throw new \Exception("Il n'y pas de données concernant le Notepad");
        }
        $tabNotepad = array();
        foreach ($data as $row) {
            $notepadId = $row['id'] ?? null;
            if ($notepadId != null) {
                $tabNotepad[] = new Notepad($row['userId'], $row['inquiryId'], $row['notes'], $notepadId);
            } else {
                $tabNotepad[] = new Notepad($row['userId'], $row['inquiryId'], $row['notes']);
            }
        }
        return $tabNotepad;
    }
}
