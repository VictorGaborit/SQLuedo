<?php

namespace Model\DAL\Gateway;

use Model\ClassMetier\Inquiry;
use Model\DAL\Connection;
use PDO;

class MySQLInquiryGateway implements IInquiryGateway
{
    private Connection $pdo;

    /**
     *
     */
    public function __construct()
    {
        global $dsn, $user, $password;
        $this->pdo = new Connection($dsn, $user, $password);
    }

    /**
     * Summary : Permet de récupérer l'ensemble des enquêtes sous forme de liste.
     * @return array
     */
    public function loadInquiry(): array
    {
        $query = 'SELECT * FROM Inquiry';
        $this->pdo->executeQuery($query);
        return $this->pdo->getResults();
    }

    /**
     * Summary : Permet de récupérer une enquête à partir de son identifiant.
     * @param int $id
     * @return array
     */
    public function findById(int $id): array
    {
        $query = 'SELECT * FROM Inquiry WHERE id = :enq';
        $this->pdo->executeQuery($query, array(':enq' => array($id, PDO::PARAM_INT)));
        $res = $this->pdo->getResults();
        return $res[0];
    }


    /**
     * @param Inquiry $inquiry
     * @return array
     */
    public function findSolution(Inquiry $inquiry): array
    {
        $query = 'SELECT s.* FROM Solution s, Inquiry i WHERE i.solution=s.id and i.solution = :sol';
        $this->pdo->executeQuery($query, array(':sol' => array($inquiry->getId(), PDO::PARAM_INT)));
        $res = $this->pdo->getResults();
        return $res[0];
    }

    public function findBaseNumber(int $inquiryId)
    {
        $query = 'SELECT * FROM InquiryTable WHERE inquiry_id = :inquiry';
        $this->pdo->executeQuery($query, array(':inquiry' => array($inquiryId, PDO::PARAM_INT)));
        $res = $this->pdo->getResults();
        return $res[0];
    }
}
