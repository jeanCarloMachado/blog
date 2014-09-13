<?php
/**
 * automatizador para controladores (nova versão para dar replace ao TableRowAutomatorAbstract)
 *
 *
 * PHP version 5
 *
 * LICENSE:  This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 3
 * @copyright  Copyright (C) CUB
 * @link       http://www.icub.com.br
 */
namespace AckMvc\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract, \AckCore\Data\Container;
abstract class TableRow extends TableRowAutomatorAbstract
{
    /**
     * this->currentScope->uração montada on the fly de acordo com o escopo
     * @var [type]
     */
    protected $currentScope = array();

    //###################################################################################
    //################################# eventos locais ###########################################
    //###################################################################################
    final protected function evtBeforeReturnLocal()
    {
        if (!empty($this->currentScope->data)) \AckCore\Facade::getInstance()->setControllerConfig($this->currentScope->data);

        $this->evtBeforeReturn();
    }
    //###################################################################################
    //################################# END eventos locais ########################################
    //###################################################################################
    //###################################################################################
    //################################# eventos sobreescrevíveis pelos controladores ###########################################
    //###################################################################################
    /**
     * executada antes de retornar a página
     */
    protected function evtBeforeReturn() {}

    /**
     * executada antes de rodar a página
     */
    protected function evtBeforeRun() {}

    /**
     * pega os dados das categorias pra mandar para a renderização
     * @param unknown $this->currentScope
     */
    protected function evtAfterGetScopedData() {}

    /**
     * executado depois de salvar os dados principais
     * @param resultado do salvamento principal $result
     */
    protected function evtAfterMainSave($saveResult) {}

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
    public function evtLoadMoreOnColumnIterator(&$key, &$element, &$iterator, array &$bdColumns, array &$result)
    {
        if ($key == "id") {
            if($this->currentScope->showId == true)
            $result["grupo"][$iterator]["fakeid"] = $element->getVal();
        }
    }
    /**
     * chamado por carregar mais no momento da execução da consulta
     * @param  [type] $where  [description]
     * @param  [type] $params [description]
     * @param  array  $config [description]
     * @return [type] [description]
     */
    public function evtLoadMoreOnQuery(array &$params = null)
    {
        $model =  $this->getInstanceOfModel();
        \AckCore\DataAbstraction\Service\InterpreterSearch::getInstance()->setRelatedModel($model)->alterQueryClausules($this->ajax,$where,$params);

        return $model->toObject()->onlyNotDeleted()->get($where,$params);
    }

    //###################################################################################
    //################################# END eventos sobreescrevíveis pelos controladores ########################################
    //###################################################################################
    //###################################################################################
    //################################# actions ###########################################
    //###################################################################################
    //###################################################################################
    //################################# actions###########################################
    //###################################################################################
    /**
     * executado quando está se visualizarndo ou editando uma linha de tabela
     * @return [type] [description]
     */
    public function editarAction()
    {
        $this->currentScope->data = $this->buildScopedConfig();
        $this->evtBeforeRun();
        $id = $this->params("id");

        $model = $this->getInstanceOfModel();
        //pega a linha atual
        $this->currentScope->row = $model->onlyNotDeleted()->toObject()->getOne(array("id"=>$id));

        if(!($this->currentScope->row->getId()->getBruteVal())) trigger_error("A entidade que você tentou acessar < $id > não existe",E_USER_ERROR);

        $this->evtAfterGetScopedData();
        $this->currentScope->hasId = true;

        //notifica o error
        $this->notify(\AckCore\Event::createInstance()->setType(\AckCore\Event::TYPE_ACTION_DISPATCH)->setConfig($this->currentScope->data));

        //seta a linha atual no facade para ficar sincronizada ;D
        \AckCore\Facade::getInstance()->setCurrentRow($this->currentScope->row);

        $this->evtBeforeReturnLocal();
        $this->viewModel->setVariables(array("customScope"=>$customScope));

        $this->setCurrentLayout();

        return $this->viewModel;
    }

    /**
     * salva os dados passados no array para
     * o modelo principal especificado na classe
     */
    public function salvarAction()
    {
        $this->currentScope->data = $this->buildScopedConfig();
        $this->evtBeforeRun();

        //prepara o retorno
        $json = array();
        $json['status'] = 1;
        $json['mensagem'] = \AckCore\Language\Language::translate("Dados salvos com sucesso.");

    /**
     * prepara as vaiáveis de entrada
     */
        //pega o nome do modelo dependendo se é categoria ou não
        $model =  $this->getInstanceOfModel();
        $package = $this->getMainPackageName();
        $result = null;
        $id = $this->ajax[$package]["id"];

        try {
            //salva os dados propriamente
            if (!empty($id)) {
                $where = array("id"=>$id);
                $result = $model->update($this->ajax[$package], $where);
            } else {
                $result = $model->create($this->ajax[$package]);
            }
        } catch (Exception $e) {
            $json['status'] = 0;
            $json["mensagem"] = $e;
        }

        $this->afterMainSave($result);

        $json['id'] = ($result) ?  $result : $id;
        $json["conteudoIdioma"] = array();

        /**
         * PREPARA O STATUS DE HAVER SALVO CADA IDIOMA
         */
        if (isset($id) && !empty($id)) {

            $resultRow = $model->toObject()->get(array("id"=>$id));
            $resultRow = reset($resultRow);

            $modelLangs = new \AckCore\Model\Languages();
            foreach ($modelLangs->onlyNotDeleted()->toObject()->get() as $lang) {

                    if($resultRow->hasLangContent($lang->getAbreviatura()->getVal()))
                        $json["conteudoIdioma"][$lang->getAbreviatura()->getVal()]=1;
                    else
                        $json["conteudoIdioma"][$lang->getAbreviatura()->getVal()]=0;
            }
        }

        $event = \AckCore\Event::createInstance()->setType(\AckCore\Event::TYPE_AFTER_MAIN_SAVE)->setController($this)->setPackage($package);
        if(isset($this->currentScope->metatagId) && !empty($this->currentScope->metatagId))  $event->setMetaId($this->currentScope->metatagId);
        $this->notify($event);

        $this->evtBeforeReturnLocal();

        \AckCore\Utils\Ajax::notifyEnd($json);
    }
    //###################################################################################
    //################################# ajaxs ###########################################
    //###################################################################################
    /**
     * função de carregar mais dados
     * @return [type] [description]
     */
    protected function carregarMaisAjax()
    {
        $this->currentScope->data = $this->buildScopedConfig();
        $this->evtBeforeRun();
        //pega o nome do modelo dependendo se é categoria ou não
        $model = $this->getInstanceOfModel();

        //###################################################################################
        //################################# prepara a query ###########################################
        //###################################################################################
        $system = \AckCore\Model\Systems::getMainSystem();
        $limite= $system->getItensPagina()->getVal();

        $params = array("limit"=>array("offset"=>$this->ajax["qtd_itens"],"count"=>$limite));

        if(!empty($this->currentScope->order))
            $params["order"] = $this->currentScope->order;
        if (empty($params["order"])) {
            if($model->hasColumn("ordem")) $params["order"] = "ordem DESC";
            else $params["order"] = "id DESC";
        }
        //###################################################################################
        //################################# END prepara a query ########################################
        //###################################################################################

        $resultObjects = $this->evtLoadMoreOnQuery($params);
        $controllerOnRoute = $this->getControllerOnRoute();

        /**
         * remove os elementos html das strings
         */
        $result["grupo"] = array();
        if (!empty($resultObjects)) {
            foreach ($resultObjects as $rowId => $row) {
                $vars = $row->getVars();
                foreach ($vars as $elementId => $element) {

                    if($elementId == $model->getVisibleColName() && isset($function["disableVisible"]))
                        break;

                    if(isset($this->currentScope->returnFalseInCols))
                        if (in_array($elementId,$this->currentScope->returnFalseInCols)) {
                        $result["grupo"][$rowId][$elementId] = "false";
                        continue;
                    }
                    if($elementId == "id") $result["grupo"][$rowId][$elementId] = strip_tags($element->getBruteVal());
                    else $result["grupo"][$rowId][$elementId] = strip_tags($element->getVal());

                    $this->evtLoadMoreOnColumnIterator($elementId,$element,$rowId,$vars, $result);
                }
                $result["grupo"][$rowId]["url_linha"] = "/ack/$controllerOnRoute/editar/".$row->getId()->getBruteVal();
            }
        }

        if (count($result["grupo"]) < $limite) {
            $result['exibir_botao'] = 0;
        } else {
            $result['exibir_botao'] = 1;
        }

        $this->evtBeforeReturnLocal();

        \AckCore\Utils\Ajax::notifyEnd($result);
    }
    //###################################################################################
    //################################# END ajaxs ########################################
    //###################################################################################
    //###################################################################################
    //################################# END actions########################################
    //###################################################################################
    //###################################################################################
    //################################# END actions ########################################
    //###################################################################################
    //###################################################################################
    //################################# funções locais ###########################################
    //###################################################################################
    public function __construct()
    {
        parent::__construct();
        $this->currentScope = Container::getInstance();
    }

    /**
     * [getSpecificthis->currentScope-> description]
     * @return [type] [description]
     */
    public function buildScopedConfig()
    {
        return $this->getSpecificConfig();
    }
    //###################################################################################
    //################################# END funções locais ########################################
    //###################################################################################
    //###################################################################################
    //################################# getters and setters ###########################################
    //###################################################################################
    public function setCurrentLayout()
    {
        $this->viewModel->setTemplate(\AckMvc\View\Utils::getRealViewFile($this->getDefaultViewFolder()."/".self::SINGULAR_VIEW_NAME,$this->currentScope->data));
    }
    //###################################################################################
    //################################# END getters and setters ########################################
    //###################################################################################
}
