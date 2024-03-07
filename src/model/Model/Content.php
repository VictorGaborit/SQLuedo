<?php

namespace Model\Model;

interface Content
{
    /**
     * @param string $note
     * @param int $inquiryId
     * @param int $userId
     * @return bool
     */
    public function save(string $note, int $inquiryId, int $userId): bool;
}
