<?php

namespace Model\ClassMetier;

class Notepad
{
    private int $id;
    private int $userId;
    private int $inquiryId;
    private string $notes;

    /**
     * @param int $userId
     * @param int $inquiryId
     * @param string $notes
     * @param int $id
     */
    public function __construct(int $userId, int $inquiryId, string $notes, int $id = -1)
    {
        $this->userId = $userId;
        $this->inquiryId = $inquiryId;
        $this->notes = $notes;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getInquiryId(): int
    {
        return $this->inquiryId;
    }

    /**
     * @return string
     */
    public function getNotes(): string
    {
        return $this->notes;
    }

    /**
     * @param $notes
     * @return void
     */
    public function setNotes($notes): void
    {
        $this->notes = $notes;
    }
}
