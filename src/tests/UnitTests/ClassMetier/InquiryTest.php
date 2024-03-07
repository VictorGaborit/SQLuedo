<?php declare(strict_types=1);

namespace UnitTest\ClassMetier;

use Model\ClassMetier\Inquiry;
use PHPUnit\Framework\TestCase;

class InquiryTest extends TestCase
{
    /**
     * @covers Inquiry::__construct
     */
    public function testConstruct()
    {
        $id = 1;
        $title = "Test Enquête";
        $description = "Ceci est une enquête de test.";
        $isUser = true;

        $inquiry = new Inquiry($id, $title, $description, $isUser);

        $this->assertNotNull($inquiry);
        $this->assertEquals($id, $inquiry->getId());
        $this->assertEquals($title, $inquiry->getTitle());
        $this->assertEquals($description, $inquiry->getDescription());
        $this->assertEquals($isUser, $inquiry->getIsUser());
    }

    /**
     * @covers Inquiry::setId
     */
    public function testSetId()
    {
        $id = 2;
        $title = "Set enquête";
        $description = "Je vais Set l'id";
        $isUser = false;

        $inquiry = new Inquiry($id, $title, $description, $isUser);
        $inquiry2 = new Inquiry($id, $title, $description, $isUser);
        $inquiry2->setId(4);
        $this->assertNotEquals($inquiry2->getId(), $inquiry->getId());
    }

    /**
     * @covers Inquiry::setTitle
     */
    public function testSetTitle()
    {
        $id = 4;
        $title = "Salut je suis le title";
        $description = "Je vais Set le title";
        $isUser = false;

        $inquiry = new Inquiry($id, $title, $description, $isUser);
        $inquiry2 = new Inquiry($id, $title, $description, $isUser);
        $inquiry2->setTitle("Le nouveau Titre");
        $this->assertNotEquals($inquiry2->getTitle(), $inquiry->getTitle());

    }

    /**
     * @covers Inquiry::setDescription
     */
    public function testSetDescription()
    {
        $id = 2;
        $title = "Set enquête description";
        $description = "Je vais Set la desc";
        $isUser = false;

        $inquiry = new Inquiry($id, $title, $description, $isUser);
        $inquiry2 = new Inquiry($id, $title, $description, $isUser);
        $inquiry2->setDescription("La nouvelle Desc");
        $inquiry2->setIsUser(true);
        $this->assertNotEquals($inquiry2->getDescription(), $inquiry->getDescription());
    }

    /**
     * @covers Inquiry::setIsUser
     */
    public function testSetAttributes()
    {
        $id = 2;
        $title = "Set enquête";
        $description = "Je vais Set";
        $isUser = false;

        $inquiry = new Inquiry($id, $title, $description, $isUser);
        $inquiry2 = new Inquiry($id, $title, $description, $isUser);
        $inquiry2->setIsUser(true);
        $this->assertNotEquals($inquiry2->getIsUser(), $inquiry->getIsUser());
    }

}