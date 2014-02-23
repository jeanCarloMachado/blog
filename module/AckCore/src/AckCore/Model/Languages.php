<?php
namespace AckCore\Model;
use AckDb\ZF1\TableAbstract;
class Languages extends TableAbstract
{
    protected static $cache;
    /**
     * nome da tabela no banco de dados
     * @var unknown
     */
    protected $_name = "ack_idiomas";

    /**
     * nome da classe simbolizando uma linha (deve estender System_Row_Abstract)
     * @var unknown
     */
    protected $_row = "\AckCore\Model\Language";

    public static function hasLanguageEnabled($abbreviation)
    {
        if(isset(self::$cache[__FUNCTION__])) return self::$cache[__FUNCTION__];

        $result = false;

        $modelLanguages = new \AckCore\Model\Languages;
        $result = $modelLanguages->onlyAvailable()->get(array("abreviatura"=>$abbreviation));
        if(!empty($result))  $result = true;

        self::$cache[__FUNCTION__] = $result;

        return $result;
    }

    public static function getLanguagesEnabled()
    {
         if(isset(self::$cache[__FUNCTION__])) return self::$cache[__FUNCTION__];

        $result = false;

        $modelLanguages = new \AckCore\Model\Languages;
        $result = $modelLanguages->toObject()->onlyAvailable()->get();

        self::$cache[__FUNCTION__] = $result;

        return $result;
    }
}
