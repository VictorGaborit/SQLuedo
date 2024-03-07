<?php

namespace UnitTest\Factory;

use Model\Factory\MySQLInquiryFactory;
use PHPUnit\Exception;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class MySQLInquiryFactoryTest extends TestCase
{
    private $inquiryFactory;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->inquiryFactory = new MySQLInquiryFactory();
    }

    /**
     * @return void
     * @throws \Exception
     * @covers \Model\Factory\MySQLInquiryFactory::createObject
     */
    public function testCreateObject()
    {
        $id = 1;
        $title = "Inquiry N°1";
        $description = "Inquiry Description";
        $isUser = true;
        $inquiries = [0 => [
            "id" => $id,
            "title" => $title,
            "description" => $description,
            "is_user" => $isUser
        ], 1 => [
            "id" => $id,
            "title" => $title,
            "description" => $description,
            "is_user" => $isUser
        ]];
        $res = $this->inquiryFactory->createObject($inquiries);
        foreach ($res as $inquiry) {
            assertEquals($id, $inquiry->getId());
            assertEquals($title, $inquiry->getTitle());
            assertEquals($description, $inquiry->getDescription());
            assertEquals($isUser, $inquiry->getIsUser());
        }
    }

    /**
     * @return void
     * @covers \Model\Factory\MySQLInquiryFactory::createObject
     */
    public function testCreateObjectEmptyArray(){
        try {
            $inquiries = array();
            $res = $this->inquiryFactory->createObject($inquiries);
        } catch (\Exception $e) {
            assertEquals("Il n'y a pas de données pour cette enquête", $e->getMessage());
        }
    }
}
