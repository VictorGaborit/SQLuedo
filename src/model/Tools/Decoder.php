<?php

namespace Model\Tools;

class Decoder
{
    /**
     * @param $string
     * @return string
     */
    public static function urlDecoder($string): string
    {
        return urldecode($string);
    }

    /**
     * @param $string
     * @return false|string
     */
    public static function base64Decoder($string)
    {
        return base64_decode($string);
    }
}
