<?php
namespace AckCore\Model;
use AckDb\ZF1\TableAbstract;
class Generics extends TableAbstract
{
    protected $_name = "app_states";
    protected $_row = "\AckCore\Model\Generic";

    public function composeModelNameSuggestionFromTableName($tableName)
    {
        $result = null;
        
        $arr = explode('_', $tableName);
        $iterator = -1;

        foreach ($arr as $part) {
            $iterator++;

            if (count($arr) > 1 && $iterator == 0) {
                $continue;
            }

            $result .= ucfirst($part);
        }


        return $result;
    } 
}
