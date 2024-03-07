<?php

namespace UnitTest\ClassMetier;

use Model\ClassMetier\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @covers User::__construct()
     */

    private string $username;
    private bool $isAdmin;
    private string $PSWD;
    private string $email;
    private int $id;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->id = 10;
        $this->isAdmin = false;
        $this->username = "John Doe";
        $this->PSWD = "motdepasse";
        $this->email = "Johnn.Doe@email.com";

    }

    /**
     * @covers \Model\ClassMetier\User::__construct
     */
    public function testConstruct(): void
    {
        $user = new User($this->isAdmin, $this->username, password_hash($this->PSWD, PASSWORD_DEFAULT), $this->email, $this->id);
        $this->assertNotNull($user);
        $this->assertEquals($this->id, $user->getId());
        $this->assertEquals($this->username, $user->getUsername());
        $this->assertTrue(password_verify($this->PSWD, $user->getPassword()));
        $this->assertEquals($this->email, $user->getEmail());
        $this->assertEquals($this->isAdmin, $user->isAdmin());

        $user1 = new User($this->isAdmin, $this->username, password_hash($this->PSWD, PASSWORD_DEFAULT), $this->email,);
        $this->assertEquals(-1, $user1->getId());
        $this->assertEquals($this->username, $user1->getUsername());
        $this->assertTrue(password_verify($this->PSWD, $user1->getPassword()));
        $this->assertEquals($this->email, $user1->getEmail());
        $this->assertEquals($this->isAdmin, $user1->isAdmin());
    }

    /**
     * @covers User::__construct()
     */
    public function testConstructWithoutId(): void
    {
        $user1 = new User($this->isAdmin, $this->username, password_hash($this->PSWD, PASSWORD_DEFAULT), $this->email);
        $this->assertEquals(-1, $user1->getId());
        $this->assertEquals($this->username, $user1->getUsername());
        $this->assertTrue(password_verify($this->PSWD, $user1->getPassword()));
        $this->assertEquals($this->email, $user1->getEmail());
        $this->assertEquals($this->isAdmin, $user1->isAdmin());
    }

    /**
     * @covers User::getId()
     */
    public function testGetId(): void
    {
        $user = new User($this->isAdmin, $this->username, password_hash($this->PSWD, PASSWORD_DEFAULT), $this->email, $this->id);
        $this->assertEquals($this->id, $user->getId());
    }

    /**
     * @covers User::isAdmin()
     */
    public function testGetIsAdmin(): void
    {
        $user = new User($this->isAdmin, $this->username, password_hash($this->PSWD, PASSWORD_DEFAULT), $this->email, $this->id);
        $this->assertEquals($this->isAdmin, $user->isAdmin());
    }
}