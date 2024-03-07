<?php

namespace UnitTest\Factory;

use Model\Factory\MySQLNotepadFactory;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class MySQLNotepadFactoryTest extends TestCase
{
    private $notePadFactory;
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->notePadFactory = new MySQLNotepadFactory();
    }

    /**
     * @return void
     * @covers \Model\Factory\MySQLNotepadFactory::createObject
     */
    public function testCreateObject()
    {
        $id = 1;
        $userId = 1;
        $inquiryId = 1;
        $notes = "Notes";
        $notePads = [0 => [
            "id" => $id,
            "userId" => $userId,
            "inquiryId" => $inquiryId,
            "notes" => $notes
        ], 1 => [
            "id" => $id,
            "userId" => $userId,
            "inquiryId" => $inquiryId,
            "notes" => $notes
        ]];
        $res = $this->notePadFactory->createObject($notePads);
        foreach ($res as $notePad) {
            assertEquals($id, $notePad->getId());
            assertEquals($userId, $notePad->getUserId());
            assertEquals($inquiryId, $notePad->getInquiryId());
            assertEquals($notes, $notePad->getNotes());
        }
    }

    /**
     * @return void
     * @covers \Model\Factory\MySQLNotepadFactory::createObject
     */
    public function testCreateObjectWithoutId()
    {
        $userId = 1;
        $inquiryId = 1;
        $notes = "Notes";
        $notePads = [0 => [
            "userId" => $userId,
            "inquiryId" => $inquiryId,
            "notes" => $notes
        ], 1 => [
            "userId" => $userId,
            "inquiryId" => $inquiryId,
            "notes" => $notes
        ]];
        $res = $this->notePadFactory->createObject($notePads);
        foreach ($res as $notePad) {
            assertEquals(-1, $notePad->getId());
            assertEquals($userId, $notePad->getUserId());
            assertEquals($inquiryId, $notePad->getInquiryId());
            assertEquals($notes, $notePad->getNotes());
        }
    }

    /**
     * @return void
     * @covers \Model\Factory\MySQLNotepadFactory::createObject
     */
    public function testCreateObjectEmptyArray()
    {
        try {
            $notePads = array();
            $res = $this->notePadFactory->createObject($notePads);
        } catch (\Exception $e) {
            assertEquals("Il n'y pas de données concernant le Notepad", $e->getMessage());
        }
    }
}
