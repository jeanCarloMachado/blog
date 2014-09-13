<?php
namespace AckAgenda\Model;
use AckDb\ZF1\TableAbstract;
class Tasks extends TableAbstract
{
    protected $_name = "ack_tarefas";
    protected $_row = "\AckAgenda\Model\Task";

    const moduleName = "Task";
    const moduleId = 51;
    const DEFAULT_USER_ID = 42;

     protected $colsNicks = array(
            "frequencia_id" => "Frequência",
            "responsavel_atual_id" => "Responsável atual",
            "visivel" => "Completa",
            "visivelstr" => "Completa",
            "nome" => "Nome",
            "data_expiracao" => "Data de expiração",
            "data_ultimarealizacao" => "Última vez realizado",
        );

    public function create(array $set,array $params = NULL)
    {
        // if(empty($set["data_ultimarealizacao"]))
        // 	$set["data_ultimarealizacao"] = \System\Object\Date::now();
        if(empty($set["data_expiracao"]))
            $set["data_expiracao"] = \System\Object\Date::now();

        if(empty($set["responsavel_atual_id"]))
            $set["responsavel_atual_id"] =  \AckAgenda\Model\Tasks::DEFAULT_USER_ID;

        $result =  parent::create($set);

        return $result;
    }
}
