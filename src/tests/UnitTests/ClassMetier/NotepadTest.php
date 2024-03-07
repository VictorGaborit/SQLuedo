<?php

namespace UnitTest\ClassMetier;

use Exception;
use Model\ClassMetier\Notepad;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * @coversDefaultClass Notepad
 */
class NotepadTest extends TestCase
{
    private string $notes;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->notes = "Ceci est une super note";
    }

    /**
     * @covers Notepad::__construct
     */
    public function testConstruct()
    {

        $id = 1;
        $inquiryId = 1;
        $userId = 12;
        $notes = $this->notes;

        $notepad = new Notepad($userId, $inquiryId, $notes, $id);

        $this->assertEquals($id, $notepad->getId());
        $this->assertEquals($userId, $notepad->getUserId());
        $this->assertEquals($inquiryId, $notepad->getInquiryId());
        $this->assertEquals($notes, $notepad->getNotes());
    }

    /**
     * @covers Notepad::__construct
     */
    public function testConstructWithOutId()
    {
        $inquiryId = 1;
        $id = -1;
        $userId = 12;
        $notes = $this->notes;

        $notepad = new Notepad($userId, $inquiryId, $notes);

        $this->assertEquals($id, $notepad->getId());
        $this->assertEquals($userId, $notepad->getUserId());
        $this->assertEquals($inquiryId, $notepad->getInquiryId());
        $this->assertEquals($notes, $notepad->getNotes());
    }

    /**
     * @covers Notepad::__construct
     */
    public function testConstructLimitMaxId()
    {
        $id = PHP_INT_MAX;
        $inquiryId = PHP_INT_MAX;
        $userId = PHP_INT_MAX;
        $notes = $this->notes;

        $notepad = new Notepad($userId, $inquiryId, $notes, $id);

        $this->assertEquals($id, $notepad->getId());
        $this->assertEquals($userId, $notepad->getUserId());
        $this->assertEquals($inquiryId, $notepad->getInquiryId());
        $this->assertEquals($notes, $notepad->getNotes());

    }

    /**
     * @covers Notepad::__construct
     */
    public function testConstructWithEmptyNote()
    {

        $inquiryId = 1;
        $id = 42;
        $userId = 12;
        $notes = "";

        $notepad = new Notepad($userId, $inquiryId, $notes, $id);

        $this->assertEquals($id, $notepad->getId());
        $this->assertEquals($userId, $notepad->getUserId());
        $this->assertEquals($inquiryId, $notepad->getInquiryId());
        $this->assertEquals($notes, $notepad->getNotes());

    }

    /**
     * @covers Notepad::__construct
     */
    public function testConstructError()
    {

        $inquiryId = "invalid_id";
        $id = "invalid_id";
        $userId = "invalid_id";
        $notes = 12;

        $this->expectException(TypeError::class);
        $notepad = new Notepad($userId, $inquiryId, $notes, $id);

        $this->assertNull($notepad->getId());
        $this->assertNull($notepad->getUserId());
        $this->assertNull($notepad->getInquiryId());
        $this->assertNull($notepad->getNotes());
    }

    /**
     * @covers Notepad::__construct
     */
    public function testConstructLimitMinId()
    {

        $id = PHP_INT_MIN;
        $inquiryId = PHP_INT_MIN;
        $userId = PHP_INT_MIN;
        $notes = $this->notes;

        $notepad = new Notepad($userId, $inquiryId, $notes, $id);

        $this->assertEquals($id, $notepad->getId());
        $this->assertEquals($userId, $notepad->getUserId());
        $this->assertEquals($inquiryId, $notepad->getInquiryId());
        $this->assertEquals($notes, $notepad->getNotes());

    }

    /**
     * @covers Notepad::__construct
     * @throws Exception
     */
    public function testConstructRandomValue()
    {

        $id = random_int(1, PHP_INT_MAX);
        $userId = random_int(1, PHP_INT_MAX);
        $inquiryId = random_int(1, PHP_INT_MAX);
        $notes = bin2hex(random_bytes(16));

        $notepad = new Notepad($userId, $inquiryId, $notes, $id);

        $this->assertEquals($id, $notepad->getId());
        $this->assertEquals($userId, $notepad->getUserId());
        $this->assertEquals($inquiryId, $notepad->getInquiryId());
        $this->assertEquals($notes, $notepad->getNotes());
    }

    /**
     * @covers Notepad::getId
     */
    public function testGetId()
    {
        $id = 42;
        $notepad = new Notepad(1, 1, "note", $id);
        $this->assertEquals($id, $notepad->getId());

    }

    /**
     * @covers Notepad::getId
     */
    public function testGetIdNegative()
    {
        $id = -42;
        $notepad = new Notepad(1, 1, "note", $id);
        $this->assertEquals($id, $notepad->getId());

    }

    /**
     * @covers Notepad::getId
     */
    public function testGetIdLimitMax()
    {
        $id = PHP_INT_MAX;
        $notepad = new Notepad(1, 1, "note", $id);
        $this->assertEquals($id, $notepad->getId());

    }

    /**
     * @covers Notepad::getId
     */
    public function testGetIdLimitMin()
    {
        $id = PHP_INT_MIN;
        $notepad = new Notepad(1, 1, "note", $id);
        $this->assertEquals($id, $notepad->getId());

    }

    /**
     * @covers Notepad::getId
     * @throws Exception
     */
    public function testGetIdRandomValue()
    {
        $id = random_int(1, PHP_INT_MAX);
        $notepad = new Notepad(1, 1, "note", $id);
        $this->assertEquals($id, $notepad->getId());

    }


    /**
     * @covers Notepad::getId
     * @throws Exception
     */
    public function testGetInvalidId()
    {
        $id = "invalid_id";
        $this->expectException(TypeError::class);
        $notepad = new Notepad(1, 1, "note", $id);
        $this->assertNull($notepad->getId());

    }

    /**
     * @covers Notepad::getUserId
     */
    public function testGetUserId()
    {
        $userId = 42;
        $notepad = new Notepad($userId, 1, "note", 1);
        $this->assertEquals($userId, $notepad->getUserId());

    }


    /**
     * @covers Notepad::getUserId
     */
    public function testGetUserIdNegative()
    {
        $userId = -42;
        $notepad = new Notepad($userId, 1, "note", 1);
        $this->assertEquals($userId, $notepad->getUserId());

    }


    /**
     * @covers Notepad::getUserId
     */
    public function testGetInvalidUserId()
    {
        $userId = "invalid_id";
        $this->expectException(TypeError::class);
        $notepad = new Notepad($userId, 1, "note", 1);
        $this->assertNull($notepad->getUserId());

    }


    /**
     * @covers Notepad::getUserId
     */
    public function testGetUserIdLimitMax()
    {
        $userId = PHP_INT_MAX;
        $notepad = new Notepad($userId, 1, "note", 1);
        $this->assertEquals($userId, $notepad->getUserId());

    }


    /**
     * @covers Notepad::getUserId
     */
    public function testGetUserIdLimitMin()
    {
        $userId = PHP_INT_MIN;
        $notepad = new Notepad($userId, 1, "note", 1);
        $this->assertEquals($userId, $notepad->getUserId());

    }


    /**
     * @covers Notepad::getUserId
     * @throws Exception
     */
    public function testGetUserIdRandomValue()
    {
        $userId = random_int(1, PHP_INT_MAX);
        $notepad = new Notepad($userId, 1, "note", 1);
        $this->assertEquals($userId, $notepad->getUserId());

    }


    /**
     * @covers Notepad::getInquiryId
     */
    public function testGetInquiryId()
    {
        $inquiry = 42;
        $notepad = new Notepad(1, $inquiry, "note", 1);
        $this->assertEquals($inquiry, $notepad->getInquiryId());

    }


    /**
     * @covers Notepad::getInquiryId
     */
    public function testGetInquiryIdNegative()
    {
        $inquiry = -42;
        $notepad = new Notepad(1, $inquiry, "note", 1);
        $this->assertEquals($inquiry, $notepad->getInquiryId());

    }


    /**
     * @covers Notepad::getInquiryId
     */
    public function testGetInvalidInquiryId()
    {
        $inquiry = "invalid_id";
        $this->expectException(TypeError::class);
        $notepad = new Notepad(1, $inquiry, "note", 1);
        $this->assertNull($notepad->getInquiryId());

    }


    /**
     * @covers Notepad::getInquiryId
     */
    public function testGetInquiryIdLimitMax()
    {
        $inquiry = PHP_INT_MAX;
        $notepad = new Notepad(1, $inquiry, "note", 1);
        $this->assertEquals($inquiry, $notepad->getInquiryId());

    }


    /**
     * @covers Notepad::getInquiryId
     */
    public function testGetInquiryIdLimitMin()
    {
        $inquiry = PHP_INT_MIN;
        $notepad = new Notepad(1, $inquiry, "note", 1);
        $this->assertEquals($inquiry, $notepad->getInquiryId());

    }


    /**
     * @covers Notepad::getInquiryId
     * @throws Exception
     */
    public function testGetInquiryIdRandomValue()
    {
        $inquiry = random_int(1, PHP_INT_MAX);
        $notepad = new Notepad(1, $inquiry, "note", 1);
        $this->assertEquals($inquiry, $notepad->getInquiryId());

    }

    /**
     * @covers Notepad::getNotes
     */
    public function testGetNote()
    {
        $note = "C'est une note";
        $notepad = new Notepad(1, 1, $note, 1);
        $this->assertEquals($note, $notepad->getNotes());

    }


    /**
     * @covers Notepad::getNotes
     * @throws Exception
     */
    public function testGetNoteWithRandomValue()
    {
        $note = bin2hex(random_bytes(16));
        $notepad = new Notepad(1, 1, $note, 1);
        $this->assertEquals($note, $notepad->getNotes());
    }


}
