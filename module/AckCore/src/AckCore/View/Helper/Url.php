<?php
namespace \AckCore\View\Helper;
class Url
{
    public static function run($link = "/", $related = null, $finalLabel = null)
    {
        global $endereco_site;

        return $endereco_site . $link;
    }

}