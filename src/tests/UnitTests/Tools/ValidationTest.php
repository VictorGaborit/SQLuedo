<?php

namespace UnitTest\Tools;

use Model\Tools\Validation;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNotEquals;
use function PHPUnit\Framework\assertNotFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

class ValidationTest extends TestCase
{

    /**
     * @covers \Model\Tools\Validation::validRequest
     */
    public function testValidRequest()
    {
        $query = 'SELECT * FROM table;';
        $res = Validation::validRequest($query);
        assertTrue($res);
        $query = "";
        $res = Validation::validRequest($query);
        assertFalse($res);
        $query = null;
        $res = Validation::validRequest($query);
        assertFalse($res);
    }

    /**
     * @covers \Model\Tools\Validation::validRequest
     */
    public function testValid_requestEmpty()
    {
        $query = "";
        $res = Validation::validRequest($query);
        assertFalse($res);
    }

    /**
     * @covers \Model\Tools\Validation::validRequest
     */
    public function testValid_requestNull()
    {
        $query = null;
        $res = Validation::validRequest($query);
        assertFalse($res);
    }

    /**
     * @covers \Model\Tools\Validation::validStr
     */
    public function testValid_str()
    {
        $str = "Test";
        $res = Validation::validStr($str);
        assertNotFalse($res);
        $str = "";
        $res = Validation::validStr($str);
        assertFalse($res);
        $str = null;
        $res = Validation::validStr($str);
        assertFalse($res);
    }

    /**
     * @covers \Model\Tools\Validation::validStr
     */
    public function testValid_strEmpty()
    {
        $str = "";
        $res = Validation::validStr($str);
        assertFalse($res);
    }

    /**
     * @covers \Model\Tools\Validation::validStr
     */
    public function testValid_strNull()
    {
        $str = null;
        $res = Validation::validStr($str);
        assertFalse($res);
    }

    /**
     * @covers \Model\Tools\Validation::validEmail
     */
    public function testValid_email()
    {
        $str = "john.doe@example.com";
        $res = Validation::validEmail($str);
        assertEquals($str, $res);
    }

    /**
     * @covers \Model\Tools\Validation::validEmail
     */
    public function testValid_emailWrongFormat()
    {
        $str = "john.doe@example.com";
        $email = "john(.doe)@exa//mple.com";
        $res = Validation::validEmail($email);
        $this->assertFalse($res);
        $res = Validation::validEmail($str);
        $this->assertTrue($res);
    }

    /**
     * @covers \Model\Tools\Validation::validEmail
     */
    public function testValid_emailEmpty()
    {
        $str = "";
        $res = Validation::validEmail($str);
        assertFalse($res);
    }

    /**
     * @covers \Model\Tools\Validation::validEmail
     */
    public function testValid_emailNull()
    {
        $str = null;
        $res = Validation::validEmail($str);
        assertFalse($res);
    }

    /**
     * @covers \Model\Tools\Validation::validPassword
     */
    public function testValid_passwordWithoutCapital()
    {
        $PSWD = "password";
        $res = Validation::validPassword($PSWD);
        assertFalse($res);
    }

    /**
     * @covers \Model\Tools\Validation::validPassword
     */
    public function testValid_passwordWithoutEnoughCharacters()
    {
        $PSWD = "pass";
        $res = Validation::validPassword($PSWD);
        assertFalse($res);
    }

    /**
     * @covers \Model\Tools\Validation::validPassword
     */
    public function testValid_passwordWithCapitalAtStart()
    {
        $PSWD = "Password";
        $res = Validation::validPassword($PSWD);
        assertTrue($res);
    }

    /**
     * @covers \Model\Tools\Validation::validPassword
     */
    public function testValid_passwordWithCapitalInMiddle()
    {
        $PSWD = "passWord";
        $res = Validation::validPassword($PSWD);
        assertTrue($res);
    }

    /**
     * @covers \Model\Tools\Validation::validActionRole
     */
    public function testValid_actionRole()
    {
        $action = "login";
        $res = Validation::validActionRole($action);
        assertEquals($action, $res);
        $action = "";
        $res = Validation::validActionRole($action);
        assertNull($res);
        $action = null;
        $res = Validation::validActionRole($action);
        assertNull($res);
    }

    /**
     * @covers \Model\Tools\Validation::validActionRole
     */
    public function testValid_actionRoleEmpty()
    {
        $action = "";
        $res = Validation::validActionRole($action);
        assertNull($res);
    }

    /**
     * @covers \Model\Tools\Validation::validActionRole
     */
    public function testValid_actionRoleNull()
    {
        $action = null;
        $res = Validation::validActionRole($action);
        assertNull($res);
    }
}
