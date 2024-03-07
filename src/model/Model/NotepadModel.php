<?php

namespace Model\Model;

use Exception;
use Model\ClassMetier\Notepad;
use Model\DAL\Gateway\INotepadGateway;
use Model\DAL\Gateway\MySQLNotepadGateway;
use Model\Factory\IFactory;
use Model\Factory\MySQLNotepadFactory;

class NotepadModel implements Content
{
    public Notepad $currentNotepad;
    private INotepadGateway $notepadGateway;
    private IFactory $notepadFactory;

    public function __construct()
    {
        $this->notepadGateway = new MySQLNotepadGateway();
        $this->notepadFactory = new MySQLNotepadFactory();
    }

    /**
     * @param string $note
     * @param int $inquiryId
     * @param int $userId
     * @return bool
     * @throws Exception
     */
    public function save(string $note, int $inquiryId, int $userId): bool
    {
        $existingNotepadData = $this->notepadGateway->getNotepadById($userId, $inquiryId);

        if (!empty($existingNotepadData)) {
            $userId = isset($existingNotepadData['user_id']) ? (int)$existingNotepadData['user_id'] : null;
            $inquiryId = isset($existingNotepadData['inquiry_id']) ? (int)$existingNotepadData['inquiry_id'] : null;
            $this->currentNotepad = $this->notepadFactory->createObject([[
                    'userId' => $userId,
                    'inquiryId' => $inquiryId,
                    'notes' => $note]]
            )[0];
            $this->notepadGateway->updateNotepad($existingNotepadData['id'], $note);
            return true;
        } else {
            $this->currentNotepad = $this->notepadFactory->createObject([[
                    'userId' => $userId,
                    'inquiryId' => $inquiryId,
                    'notes' => $note]]
            )[0];
            $this->notepadGateway->insertNotepad(
                $this->currentNotepad->getInquiryId(),
                $this->currentNotepad->getUserId(),
                $this->currentNotepad->getNotes()
            );
            return true;
        }

    }

    /**
     * @param int $inquiryId
     * @param int $userId
     * @return string
     */
    public function loadNotes(int $inquiryId, int $userId): string
    {
        $existingNotepadData = $this->notepadGateway->getNotepadById($userId, $inquiryId);

        if ($existingNotepadData !== null) {
            return $existingNotepadData['notes'];
        }
        return '';
    }
}
