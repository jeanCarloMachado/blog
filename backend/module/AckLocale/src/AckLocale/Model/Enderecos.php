<?php
namespace AckLocale\Model;
use AckDb\ZF1\TableAbstract as Table;
class Enderecos extends Table
{
    protected $_name = "estg_endereco";
    protected $_row = "\AckLocale\Model\Endereco";

    const moduleName = "Endereco";
    const moduleId = 120;

    protected $colsNicks = array(
        "fakeid"=>"Id",
        "visivel"=>"Visível",
        'numero'=>'Número',
    );

    protected $meta = array(
        "humanizedIdentifier" => "logradouro",
    );

    protected $relations = array(
        '1:1' => array(
                            array('model'=>'AckLocale\Model\Cidades','reference'=>'cidade_id','elementTitle'=>'Cidade','relatedRowUrlTemplate'=>'/cidades/editar/{id}/id'),
                        ),
    );
}
