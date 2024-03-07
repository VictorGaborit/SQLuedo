<?php

namespace UnitTest\Tools;

use Model\Tools\Decoder;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class DecodeurTest extends TestCase
{

    /**
     * @covers \Model\Tools\Decoder::base64Decoder
     */
    public function testBase64Decoder()
    {
        $message = "Message";
        $encoded = base64_encode($message);
        $res = Decoder::base64Decoder($encoded);
        assertEquals($message, $res);
    }

    /**
     * @covers \Model\Tools\Decoder::urlDecoder
     */
    public function testUrlDecoder()
    {
        $message = "Message";
        $encoded = urlencode($message);
        $res = Decoder::urlDecoder($encoded);
        assertEquals($message, $res);
    }
}
