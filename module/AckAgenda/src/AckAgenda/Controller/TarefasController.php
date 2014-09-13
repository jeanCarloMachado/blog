<?php
namespace AckAgenda\Controller;
use System\Mvc\Controller\TableRowAutomatorAbstract;
use \AckAgenda\Model\Tasks,
    \AckUsers\Model\Users,
    \System\HtmlElements\Select,
    \AckAgenda\Model\Frequencys;
class TarefasController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"\AckAgenda\Model\Tasks");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Tarefa";

    protected $config = array (

        "global" => array(
            "blacklist"=>array("id","ordem","status","visivel","frequenciaid","responsavelatualid"),
            //"disableVisible" => true,
            "elementsSettings" => array(
                                "descricao" => array("type"=>"TextEditor"),
                                "nome" => array("columnSpacing" => 500,"orderSelector"=>true),
                                "responsavelatualid" => array("columnSpacing" => 150),
                                "frequenciaid" => array("columnSpacing" => 150),
                                "dataexpiracao" => array("columnSpacing" => 100),
                            ),
            "colB" => array(),

        ),
        "index" => array(
            "whitelist"=>array("id","nome","responsavelatualid","dataexpiracao","visivel"),
            "filters_file" => "filters.phtml",
            "order"=> "data_expiracao ASC",
            //"filters_file" => "filters.phtml";
            "disableFilters" => false,
        )
    );

    public function getCategoryData(&$config)
    {
        if ($this->params("action") == "editar") {
            //###################################################################################
            //################################# relacionamento de frequencias###########################################
            //###################################################################################
            $modelFrequencys = new Frequencys;
            $Frequencys = $modelFrequencys->toObject()->onlyAvailable()->get();
            $selectFrequencys = Select::getInstance()->setName("frequencia_id")->setTitle("Frequência")->setPermission('rw')->setValue(0);

            if($config["row"]->getFrequenciaId()->getBruteVal())
                    $where = (array("id"=>$config["row"]->getFrequenciaId()->getBruteVal()));

            //pega a linha relacionada (caso ela existir)
            $selectedRow = $modelFrequencys->getOne($where);

            foreach ($Frequencys as $row) {
                $selected = ($selectedRow->getId()->getBruteVal() == $row->getId()->getBruteVal()) ? true : false;
                $selectFrequencys->setOption($row->getId()->getBruteVal(),$row->getNome()->getVal(),$selected);
            }
            $config["toRender"][] =& $selectFrequencys;
            //###################################################################################
            //################################# END relacionamento de frequencias########################################
            //###################################################################################
            //###################################################################################
            //################################# relacionamento de responsável pela tarefa###########################################
            //###################################################################################
            $modelUsers = new Users;
            $Users = $modelUsers->toObject()->onlyAvailable()->getAllDifferentFrom(\AckUsers\Model\User::ROOT_USER_ID);
            $selectUsers = \System\HtmlElements\Select::getInstance()->setName("responsavel_atual_id")->setTitle("Responsável atual")->setPermission('rw')->setValue(0);
            if($config["row"]->getresponsavelatualid()->getBruteVal()) $where = (array("id"=>$config["row"]->getresponsavelatualid()->getBruteVal()));

            //pega a linha relacionada (caso ela existir)
            $selectedRow = $modelUsers->getOne($where);
            foreach ($Users as $row) {
                $selected = ($selectedRow->getId()->getBruteVal() == $row->getId()->getBruteVal()) ? true : false;
                $selectUsers->setOption($row->getId()->getBruteVal(),$row->getNomeTratamento()->getVal(), $selected);
            }
            $config["toRender"][] =& $selectUsers;
            //###################################################################################
            //################################# END relacionamento de responsável pela tarefa########################################
            //###################################################################################
            //###################################################################################
            //################################# histórico de tarefas###########################################
            //###################################################################################
            $modelTasksHistory = new \AckAgenda\Model\TasksHistorys;
            $config["TasksHistory"] = $modelTasksHistory->toObject()->onlyAvailable()->get(array("tarefa_id"=>$config["row"]->getId()->getBruteVal()),array("order"=>"id DESC"));
            //###################################################################################
            //################################# END histórico de tarefas########################################
            //###################################################################################

        }
    }
    /**
     * deve ser sobreescrita pelo usuário
     */
    protected function beforeRun(&$config=null)
    {
        if ($this->params("action") == "index") {

            $modelFrequencys = new \AckAgenda\Model\Frequencys;
            $config["Frequencys"] = $modelFrequencys->onlyAvailable()->toObject()->get();
                $modelUsers = new \AckUsers\Model\Users;
            $config["Users"] = $modelUsers->toObject()->onlyAvailable()->getAllDifferentFrom(\AckUsers\Model\User::ROOT_USER_ID);
        }
    }

    public function loadMoreOnColumnIterator(&$key, &$element, &$iterator, array &$bdColumns, array &$result, array &$functionInfo)
    {

        $func = function ($id,$modelName, $defaultValue = "Não informado") {

            if(!$id)  return $defaultValue;

            $name = $modelName::getFromId($id)->getNome()->getVal();
            $name  = ($name) ? $name : $defaultValue;

            return $name;
        };

       if ($key == "responsavelatualid") {
            $result["grupo"][$iterator]["responsavelatualid"] = $func($element->getBruteVal(),"\AckUsers\Model\Users");
        } elseif ($key == "visivel") {
            $result["grupo"][$iterator]["visivelstr"] = ($element->getBruteVal()) ? "Sim" : "Não";
        }
    }

    public function loadMoreOnQuery(&$where = null, array &$params = null, array &$config)
    {
        $model =  $this->getInstanceOfModel();
        \System\DataAbstraction\Service\InterpreterSearch::getInstance()->setRelatedModel($model)->alterQueryClausules($this->ajax,$where,$params);

        return $model->toObject()->onlyNotDeleted()->get($where,$params);
    }

    public function beforeMainSave()
    {
        $taskId = $this->ajax["tarefas"]["id"];

        if (!empty($taskId)) {

            $visible = $this->ajax["tarefas"]["visivel"];

            $task = \AckAgenda\Model\Tasks::getFromId($taskId);
            if ($task->getVisivel()->getBruteVal() != $visible) {
                $task->switchState();
            }
        }
    }

    /**
     * troca o estado de visível
     * esta funcionalidade foi sobreescrita
     * e ela simboliza a a conclusão ou não de uma tarefa
     * @throws Exception
     */
    public function visivelAction()
    {
        $taskId = $this->ajax["id"];
        $task = Tasks::getFromId($taskId);
        $task->switchState();

        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array("status"=>1,"mensagem"=>"Tarefa concluída com sucesso!")));
    }
}
