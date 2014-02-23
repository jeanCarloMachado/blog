<?php
namespace AckCore\Model;
use AckCore\Object;
class ZF2Application extends Object
{
    /**
     * arquivos do public que não devem ser deletados em uma nova instalaçao
     * @var array
     */
    public static $publicFilesWhitelist = array("vendor","index.php","galeria","ack-core","README.md");
    public static function getFullApplicationConfigPath()
    {
        return \AckCore\Facade::getPublicPath(). "/../config/application.config.php";
    }
    public static function getConfigFilesPath()
    {
        return \AckCore\Facade::getPublicPath(). "/../config/autoload";
    }
}
