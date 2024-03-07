<?php

namespace UnitTest\ClassMetier;

use Model\ClassMetier\Admin;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
    private $username;
    private $id;
    private $isAdmin;
    private $password;
    private $email;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->isAdmin = true;
        $this->username = "exemple";
        $this->password = "baddasPassword";
        $this->email = "exemple@gmail.com";
        $this->id = -1;
    }

    /**
     * @covers Inquiry::getId
     */
    public function testGetId()
    {
        $admin = new Admin($this->isAdmin, $this->username, password_hash($this->password, PASSWORD_DEFAULT), $this->email, $this->id);
        $this->assertEquals($this->id, $admin->getId());
    }

    /**
     * @covers Inquiry::isAdmin
     */
    public function testIsAdmin()
    {
        $admin = new Admin($this->isAdmin, $this->username, password_hash($this->password, PASSWORD_DEFAULT), $this->email, $this->id);
        $this->assertTrue((bool)$admin->isAdmin());
    }

    /**
     * @covers Admin::__construct
     */
    public function test__construct()
    {
        $admin = new Admin($this->isAdmin, $this->username, password_hash($this->password, PASSWORD_DEFAULT), $this->email, $this->id);
        $this->assertTrue((bool)$admin->isAdmin());
        $this->assertEquals($this->username, $admin->getUsername());
        $this->assertTrue(password_verify($this->password, $admin->getPassword()));
        $this->assertEquals($this->email, $admin->getEmail());
        $this->assertEquals($this->id, $admin->getId());
    }

    /**
     * @covers Admin::__construct
     */
    public function test__constructWithoutId()
    {
        $admin = new Admin($this->isAdmin, $this->username, password_hash($this->password, PASSWORD_DEFAULT), $this->email);
        $this->assertTrue((bool)$admin->isAdmin());
        $this->assertEquals($this->username, $admin->getUsername());
        $this->assertTrue(password_verify($this->password, $admin->getPassword()));
        $this->assertEquals($this->email, $admin->getEmail());
        $this->assertEquals($this->id, $admin->getId());
    }
}
