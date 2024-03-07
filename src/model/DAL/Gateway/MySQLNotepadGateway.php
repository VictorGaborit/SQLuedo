<?php

namespace Model\DAL\Gateway;

use Model\DAL\Connection;
use PDO;

class MySQLNotepadGateway implements INotepadGateway
{
    protected Connection $pdo;

    public function __construct()
    {
        global $dsn, $user, $password;
        $this->pdo = new Connection($dsn, $user, $password);
    }

    /**
     * @param int $inquiryId
     * @param int $userId
     * @param string $notes
     * @return void
     */
    public function insertNotepad(int $inquiryId, int $userId, string $notes)
    {
        $query = 'INSERT INTO Notepad(inquiry_id, user_id, notes) VALUES(:inquiryId, :userId, :notes)';

        $this->pdo->executeQuery($query, [
            ':inquiryId' => [$inquiryId, PDO::PARAM_INT],
            ':userId' => [$userId, PDO::PARAM_INT],
            ':notes' => [$notes, PDO::PARAM_STR],]);
    }

    /**
     * @param int $notepadId
     * @param string $notes
     * @return void
     */
    public function updateNotepad(int $notepadId, string $notes)
    {
        $query = 'UPDATE Notepad SET notes=:notes WHERE id=:notepadId';

        $this->pdo->executeQuery($query, [
            ':notepadId' => [$notepadId, PDO::PARAM_INT],
            ':notes' => [$notes, PDO::PARAM_STR],]);
    }

    /**
     * @param int $idUser
     * @param int $inquiryId
     * @return array|null
     */
    public function getNotepadById(int $idUser, int $inquiryId): ?array
    {
        $query = 'SELECT * FROM Notepad WHERE inquiry_id=:inquiryId AND user_id=:idUser';

        $this->pdo->executeQuery($query, [
            ':inquiryId' => [$inquiryId, PDO::PARAM_INT],
            ':idUser' => [$idUser, PDO::PARAM_INT],]);
        $result = $this->pdo->getResults();
        if (empty($result)) {
            return null;
        }
        return $result[0];
    }
}

