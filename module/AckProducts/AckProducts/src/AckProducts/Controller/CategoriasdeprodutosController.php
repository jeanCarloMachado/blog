<?php
/**
 * categorias de produots
 *
 * AckDefault - Cub
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 * PHP version 5
 *
 * @category  WebApps
 * @package   AckDefault
 * @author    Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @copyright 2013 Copyright (C) CUB
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @version   GIT: <6.4>
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */
namespace AckProducts\Controller;

use \AckMvc\Controller\TableRowAutomatorAbstract;

use \AckCore\DataAbstraction\Service\InterpreterSearch;

/**
 * categorias de produtos
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class CategoriasdeprodutosController extends TableRowAutomatorAbstract
{

    protected $models = array("default" => "\AckProducts\Model\Categorys");
    protected $title = "Categoria de produto";
    protected $config = array(
        "global" => array(
            "order" => "nome ASC",
            "blacklist" => array("id", "ordem", "status", "visivel"),
            "elementsSettings" => array(
                #"nome" => array("columnSpacing" => 800)
            ),
        ),
        "index" => array(
            "blacklist" => array("ordem", "status"),
        )
    );

    /**
    * ao executar a query
    *
    * @param array &$where  cláusualas
    * @param array &$params parametros da funcionalidade
    * @param array &$config configuração
    *
    * @return void
    */
    public function loadMoreOnQuery(&$where = null, array &$params = null, array &$config)
    {
        $model =  $this->getInstanceOfModel();
        InterpreterSearch::getInstance()->setRelatedModel($model)->alterQueryClausules($this->ajax, $where, $params);

        $result = $model->getOnlyParentsWithWhere($where, $params, "\AckProducts\Model\CategorysHierarchys");

        return $result;
    }

    protected function buildLoadMoreReturn($objects, array &$result, &$config)
    {
        $resultObjects =& $objects;
        $model = $this->getInstanceOfModel();
        $controllerOnRoute = $this->getControllerOnRoute();

         foreach ($resultObjects as $rowId => $row) {

                $vars = $row->getVars();
                foreach ($vars as $elementId => $element) {

                    if ($elementId == $model->getVisibleColName() && isset($function["disableVisible"])) {
                        break;
                    }

                    if(isset($config["returnFalseInCols"]))
                        if (in_array($elementId,$config["returnFalseInCols"])) {
                        $result["grupo"][$rowId][$elementId] = "false";
                        continue;
                    }
                    if($elementId == "id")
                        $result["grupo"][$rowId][$elementId] = strip_tags($element->getBruteVal());
                    else
                        $result["grupo"][$rowId][$elementId] = strip_tags($element->getVal());

                    $this->loadMoreOnColumnIterator($elementId,$element,$rowId,$vars, $result, $config);
                }

                $result["grupo"][$rowId]["url_linha"] = "/ack/$controllerOnRoute/editar/".$row->getId()->getBruteVal();

                if ($row->hasChildren()) {
                    $result['grupo'][$rowId]['grupo'] = array();
                    $this->buildLoadMoreReturn($row->getChildrenForAck(), $result['grupo'][$rowId], $config);
                }
            }
    }

    /**
     * função de carregar mais dados
     * @return [type] [description]
     */
    protected function carregarMaisAjax()
    {
        $config = $this->getSpecificConfig();
        $this->beforeRunLocal($config);
        //pega o nome do modelo dependendo se é categoria ou não
        $model = $this->getInstanceOfModel();

        $system = \AckCore\Model\Systems::getMainSystem();
        $limite= $system->getItensPagina()->getVal();

        $params = array("limit"=>array("offset"=>$this->ajax["qtd_itens"],"count"=>$limite));

        if(!empty($config["order"]))
            $params["order"] = $config["order"];
        if (empty($params["order"])) {
            if($model->hasColumn("ordem"))
                $params["order"] = "ordem DESC";
            else
                $params["order"] = "id DESC";
        }

        $resultObjects = $this->loadMoreOnQuery($config["where"],$params,$config);

        $result['grupo'] = array();
        $this->buildLoadMoreReturn($resultObjects,$result,$config);

        if (count($result["grupo"]) < $limite) {
            $result['exibir_botao'] = 0;
        } else {
            $result['exibir_botao'] = 1;
        }

        $this->beforeReturnLocal();
        echo json_encode($result);

        return $this->response;
    }

    /**
     * pega os dados das categorias pra mandar para a renderização
     *
     * @param array $config configuração
     *
     * @return void
     */
    protected function getCategoryData(&$config)
    {
        if ($this->params("action") == "editar") {
            //pega os filhos em potencial
            $config["childs"] = $config["row"]->getOnlyPotentialChilds("\AckProducts\Model\CategorysHierarchys");
        }
    }

    /**
     * executado depois de salvar os dados principais
     *
     * @param resultado do salvamento principal $result
     */
    protected function afterMainSave(&$result)
    {
        $id = $this->ajax[$this->getDefaultPackageName()]["id"];
        if ($this->ajax["acao"] == "editar") {
            //caso for editar remove primeiramente as entradas de controladores antigas
            $modelRelation = new \AckProducts\Model\CategorysHierarchys;
            $modelRelation->delete(array("master_id" => $id));

            if (!isset($this->ajax["childs"]["childs"]))
                throw new Exception("Não encontrou os elementos que deveriam ser passados no array de relações ");

            $elements = $this->ajax["childs"]["childs"];

            foreach ($elements as $element) {
                $modelRelation->create(array("slave_id" => $element, "master_id" => $id));
            }
        }
    }
}
