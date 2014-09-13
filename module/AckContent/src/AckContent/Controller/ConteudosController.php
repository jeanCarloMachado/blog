<?php
namespace AckContent\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class ConteudosController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"AckContent\Model\Contents");
    protected $title = "Conteúdo";
    protected $config = array (
                    "global" => array(
                                "showId" => true,
                                //"automaticRenderView"=>false,

                                "elementsSettings"=>array(
                                    "fakeid"=>array("columnSpacing"=>80),
                                    "descricao"=>array("columnSpacing"=>400),
                                    "front"=>array("columnSpacing"=>120),
                                ),
                                "blacklist"=>array("acoes","valordefault","negocio"),
                            ),
                    "index" => array(
                        "whitelist" => array(
                                "id",
                                "fakeid",
                                "titulo",
                                "descricao",
                                "front",
                                "visivel",
                                ),
                        ),
                );

     /**
     * funçao para ser sobreescrita pelo usuário
     */
    protected function beforeReturn(&$config=null)
    {
        parent::beforeReturn($config);

        if ($this->params("action") == "index" && !\AckCore\Facade::getCurrentUser()->hasGroupPermission(\AckUsers\Model\Group::GROUP_ADMIN)) {
            $key = array_search("front", $config["whitelist"]);
            if ($key) {
                unset($config["whitelist"][$key]);
                unset($config["row"]->vars["front"]);
            }
        }
    }

    /**
     * funçao para ser sobreescrita pelo usuário
     */
    protected function getCategoryData(&$config)
    {
        if ($this->params("action") == "editar" || $this->params("action") == "incluir" ) {
            //###################################################################################
            //################################# retorna todos os controladores estanciáveis###########################################
            //###################################################################################
            $module = new \AckCore\Model\ZF2Modules();
            $controllers = $module->getInstantiableControllersEnabled();
            $config["controllers"] =& $controllers ;
            //###################################################################################
            //################################# END retorna todos os controladores estanciáveis########################################
            //###################################################################################
            //###################################################################################
            //################################# select de front ou back ###########################################
            //###################################################################################
            $config["toRenderCOL2"][] = \AckCore\HtmlElements\BooleanSelector::Factory($config["row"]->vars["front"]);

            if (\AckCore\Facade::getCurrentUser()->hasGroupPermission(\AckUsers\Model\Group::GROUP_ADMIN)  && !empty($config["row"]->vars["negocio"])) {
                //o administrador do sistema pode selecionar se o conteúdo é do ack padrão ou é do negócio
                $config["toRenderCOL2"][] = \AckCore\HtmlElements\BooleanSelector::Factory($config["row"]->vars["negocio"]);
            }

            //remove a coluna do array de renderização
            unset($config["row"]->vars["front"]);
            //###################################################################################
            //################################# END select de front ou back ########################################
            //###################################################################################

        }
    }

    /**
     * executado depois de salvar os dados principais
     * @param resultado do salvamento principal $result
     */
    protected function beforeMainSave()
    {
        //serializa o array de actions
        if (!empty($this->ajax["actions"]["actions"])) {
            $this->ajax[$this->getDefaultPackageName()]["acoes"] = serialize($this->ajax["actions"]["actions"]);
        }
    }

    /**
     * executado depois de salvar os dados principais
     * @param resultado do salvamento principal $result
     */
    protected function afterMainSave(&$result)
    {
        $id = null;
        if(!empty($result))
            $id = is_array($result) ? reset($result) : $result;
        else
            $id = $this->ajax[$this->getDefaultPackageName()]["id"];

        $modelControllers = new \AckContent\Model\ContentControllers;
        //caso for editar remove primeiramente as entradas de controladores antigas
        if ($this->ajax["acao"] == "editar") {
            $modelControllers->delete(array("conteudo_id"=>$id));
        }

        foreach ($this->ajax["controllers"]["controllers"] as $controller) {
            $modelControllers->create(array("controller"=>$controller,"conteudo_id"=>$id));
        }
    }

    public function loadMoreOnQuery(&$where = null, array &$params = null, array &$config)
    {
        $model =  $this->getInstanceOfModel();

        \AckCore\DataAbstraction\Service\InterpreterSearch::getInstance()->setRelatedModel($model)->alterQueryClausules($this->ajax,$where,$params);

        if (!\AckCore\Facade::getCurrentUser()->hasGroupPermission(\AckUsers\Model\Group::GROUP_ADMIN)) $where["front"] = 1;
        return $model->toObject()->onlyNotDeleted()->get($where,$params);
    }

    /**
     * executado na iteração de uma coluna de uma linha no carregar mais
     * @param  [type] $key       [description]
     * @param  [type] $element   [description]
     * @param  [type] $iterator  [description]
     * @param  array  $bdColumns [description]
     * @param  array  $result    [description]
     * @param  array  $config    [description]
     * @return [type] [description]
     */
    public function loadMoreOnColumnIterator(&$key, &$element, &$iterator, array &$bdColumns, array &$result, array &$config)
    {
        if ($key == "id") {
            if(isset($config["showId"]) && $config["showId"] == true)
            $result["grupo"][$iterator]["fakeid"] = $element->getVal();

        } elseif ($key=="front") {
            $result["grupo"][$iterator]["front"] = ($element->getBruteVal()) ? "Sim" : "Não";
        }
    }
}
