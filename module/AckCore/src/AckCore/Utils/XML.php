<?php
namespace AckCore\Object;
class XML
{
    public static function toArray($xml)
    {
        return json_decode(json_encode((array) simplexml_load_file($xml)),1);
    }
}
