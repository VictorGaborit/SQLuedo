<?php

namespace UnitTest\Factory;

use Exception;
use Model\Factory\IFactory;
use Model\Factory\MySQLUserFactory;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class MySQLUserFactoryTest extends TestCase
{
    private IFactory $factory;
    private string $message;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->factory = new MySQLUserFactory();
        $this->message = "Il n'y a pas de donnés pour cet utilisateur";
    }

    /**
     * @covers \Model\Factory\MySQLUserFactory::createObject
     */
    public function testCreateObject()
    {
        try {
            $username = "username";
            $password = "password";
            $id = 100;
            $isAdmin = true;
            $email = "email@example.com";
            $data = [0 => ["isAdmin" => $isAdmin,
                           "username" => $username,
                           "password" => $password,
                           "email" => $email,
                           "id" => $id],];
            $res = $this->factory->createObject($data);
            foreach ($res as $user) {
                assertEquals($isAdmin, $user->isAdmin());
                assertEquals($username, $user->getUsername());
                assertEquals($password, $user->getPassword());
                assertEquals($email, $user->getEmail());
                assertEquals($id, $user->getId());
            }
        } catch (Exception $e) {
            $message = $this->message;
            assertEquals($message, $e->getMessage());
        }
    }

    /**
     * @covers \Model\Factory\MySQLUserFactory::createObject
     */
    public function testCreateObjectEmptyArray()
    {
        try {
            $data = array();
            $res = $this->factory->createObject($data);
        } catch (Exception $e) {
            $message = $this->message;
            assertEquals($message, $e->getMessage());
        }
    }

    /**
     * @covers \Model\Factory\MySQLUserFactory::createObject
     */
    public function testCreateObjectWithoutId()
    {
        try {
            $username = "username";
            $password = "password";
            $isAdmin = true;
            $email = "email@example.com";
            $data = [0 => ["isAdmin" => $isAdmin,
                           "username" => $username,
                           "password" => $password,
                           "email" => $email],];
            $res = $this->factory->createObject($data);
            foreach ($res as $user) {
                assertEquals($isAdmin, $user->isAdmin());
                assertEquals($username, $user->getUsername());
                assertEquals($password, $user->getPassword());
                assertEquals($email, $user->getEmail());
                assertEquals(-1, $user->getId());
            }
        } catch (Exception $e) {
            $message = $this->message;
            assertEquals($message, $e->getMessage());
        }
    }
}
