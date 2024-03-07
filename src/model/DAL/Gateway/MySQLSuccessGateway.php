<?php

namespace Model\DAL\Gateway;

use Model\DAL\Connection;
use PDO;

class MySQLSuccessGateway implements ISuccessGateway
{
    private Connection $pdo;

    public function __construct()
    {
        global $dsn, $user, $password;
        $this->pdo = new Connection($dsn, $user, $password);
    }

    /**
     * Summary : Permet de récupérer l'ensemble des enquêtes sous forme de liste.
     * @param int $idUser
     * @return array
     */
    public function loadSuccess(int $idUser): array
    {
        $query = 'SELECT * FROM Success WHERE user_id = :idUser';
        $this->pdo->executeQuery($query, [':idUser' => [$idUser, PDO::PARAM_INT]]);
        return $this->pdo->getResults();
    }

    /**
     * @param int $inquiryId
     * @param int $userId
     * @return void
     */
    public function addSuccess(int $inquiryId, int $userId)
    {
        $query = 'INSERT IGNORE INTO Success VALUES(:userId, :inquiryId, 1)';

        $this->pdo->executeQuery($query, [
            ':inquiryId' => [$inquiryId, PDO::PARAM_INT],
            ':userId' => [$userId, PDO::PARAM_INT],]);
    }

    /**
     * Summary : Permet de récupérer une enquête à partir de son identifiant.
     * @return array
     */
    public function findById(): array
    {
        $query = 'SELECT * FROM Success';
        $this->pdo->executeQuery($query);
        return $this->pdo->getResults();
    }
}
