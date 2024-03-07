<?php

namespace Model\DAL\Gateway;

interface INotepadGateway
{
    /**
     * @param int $notepadId
     * @param string $notes
     * @return mixed
     */
    public function updateNotepad(int $notepadId, string $notes);

    /**
     * @param int $inquiryId
     * @param int $userId
     * @param string $notes
     * @return mixed
     */
    public function insertNotepad(int $inquiryId, int $userId, string $notes);

    /**
     * @param int $idUser
     * @param int $inquiryId
     * @return array|null
     */
    public function getNotepadById(int $idUser, int $inquiryId): ?array;

}
