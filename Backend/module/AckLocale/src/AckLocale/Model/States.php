<?php
namespace AckLocale\Model;
use AckDb\ZF1\TableAbstract;
class States extends TableAbstract
{
    protected $_name = "acklocale_estado";
    protected $_row = "\AckLocale\Model\State";

    const DEFAULT_STATE = 2;

    protected $colsNicks = array(
        "fakeid"=>"Id",
        "visivel"=>"Visível",
    );

    protected $meta = array(
        "humanizedIdentifier" => "nome",
    );

    protected $relations = array(
        '1:n' => array(
                            array('model'=>'AckLocale\Model\Cidades','reference'=>'estado_id','elementTitle'=>'Cidades','relatedRowUrlTemplate'=>'/cidades/editar/{id}/id'),
                        ),
    );

    /**
     * retorna uma cidade pelo seu nome
     * @param  [type] $name [description]
     * @return [type] [description]
     */
    public function getCitiesByName($name)
    {
        if(empty($name))
            throw new \Exception("o nome do estado não foi informado");

        $state = $this->toObject()->onlyAvailable()->getOne(array("descricao"=>$name));

        $modelCitys = new \AckLocale\Model\Citys;
        $resultCitys = $modelCitys->toObject()->onlyAvailable()->get(array("estados_id"=>$state->getId()->getBruteVal()));

        return $resultCitys;
    }

    public static function getDefault()
    {
        return self::getFromId(self::DEFAULT_STATE);
    }

    /**
     * retorna o estado relacionado com o id da cidade passada
     * @param  [type] $cityId [description]
     * @return [type] [description]
     */
    public function getFromCityId($cityId)
    {
        if(empty($cityId))

            return new State;

        $modelCitys = new \AckLocale\Model\Citys;
        $city = $modelCitys->toObject()->onlyAvailable()->getOne(array("id"=>$cityId));

        if(empty($city))

            return new State;

        $state = self::getFromId($city->getEstadosId()->getBruteVal());

        if(empty($state))

            return new State;

        return $state;
    }

    /**
     * à partir de um array com os ids das cidades retorna os objetos estados
     * @param  [type] $citysIds [description]
     * @return [type] [description]
     */
    public function getFromCitysIds($citysIds)
    {
        assert(0,"é melhor criar um sql específcio para esta chamada pois pode causar problemas de performance quando o sistema crescer");
        $result = array();

        if(empty($citysIds))

            return $result;

        foreach ($citysIds as $cityId) {

            $tmp = $this->getFromCityId($cityId);
            if($tmp->getId()->getBruteVal())
                $result[$tmp->getId()->getBruteVal()] = $tmp;
        }

        return $result;
    }
}
