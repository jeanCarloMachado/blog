<?php
namespace AckLocale\Model;
use AckDb\ZF1\TableAbstract;
class Cities extends TableAbstract
{
    protected $_name = "acklocale_cidade";
    protected $_row = "\AckLocale\Model\City";

    protected $colsNicks = array(
        "fakeid"=>"Id",
        "visivel"=>"Visível",
    );

    protected $meta = array(
        "humanizedIdentifier" => "nome",
    );

    protected $relations = array(
        '1:1' => array(
             array('model'=>'AckLocale\Model\Estados','reference'=>'estado_id','elementTitle'=>'Estado','relatedRowUrlTemplate'=>'/estados/editar/{id}/id'),
        ),
    );

    public static function getFromDefaultState()
    {
        $modelCitys = new \AckLocale\Model\Citys;
        $result = $modelCitys->toObject()->onlyAvailable()->get(array("estados_id"=>States::DEFAULT_STATE));

        return $result;
    }

    public static function getFromStateId($stateId)
    {
        $modelCitys = new \AckLocale\Model\Citys;
        $result = $modelCitys->toObject()->onlyAvailable()->get(array("estados_id"=>$stateId));

        return $result;
    }
}
