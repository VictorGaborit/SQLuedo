<?php

namespace Model\Factory;

use Model\ClassMetier\User;

class MySQLUserFactory implements IFactory
{
    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function createObject(array $data): array
    {
        if (empty($data)) {
            throw new \Exception("Il n'y a pas de donnés pour cet utilisateur");
        }
        $tabUser = array();
        foreach ($data as $row) {
            $userId = $row['id'] ?? null;
            if ($userId !== null) {
                $tabUser[] = new User($row['isAdmin'], $row['username'], $row['password'], $row['email'], $userId);
            } else {
                $tabUser[] = new User($row['isAdmin'], $row['username'], $row['password'], $row['email']);
            }
        }
        return $tabUser;
    }
}
