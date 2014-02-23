<?php
/**
 * logs do sistema
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
namespace AckCore\Controller;
use AckUsers\Model\Users,
AckMvc\Controller\TableRowAutomatorAbstract;
class LogsController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"AckCore\Model\Logs");
    protected $title = "Log";
    protected $config = array(
                "global"=>array(
                        "showId"=> true,
                        "disableADDREMOVE" => true,
                        "parentFullClassess"=> "logs",
                        "elementsSettings" => array(
                                            "instrucaosql" => array("type"=>"TextArea"),
                                            "colunaid" => array("columnSpacing"=>80),
                                            "data" => array("columnSpacing"=>120)

                ),
                "index" => array(
                    "blacklist" => array("instrucaosql","textolog","id"),
                    "whitelist" => array(
                        "colunaid",
                        "data",
                        "instrucaosql"
                    ),
                    "disableListEntryLink" => true,
                    //"disableModuleHeader" => true,
                    //"disableModuleFooter" => true,
                    //"disableLoadMore" => true

                ),
                "editar" => array(
                    "permission" => "+r",
                    "blacklist" => array("id"),
                ),
            );

    public function loadMoreOnColumnIterator(&$key, &$element, &$iterator, array &$bdColumns, array &$result, array &$functionInfo)
    {
        if ($key == "id") {
            $result["grupo"][$iterator]["idliteral"] = $element->getVal();
            $result["grupo"][$iterator]["colunaid"] = $element->getVal();

        } elseif ($key == "instrucaosql") {
            $result["grupo"][$iterator]["texto_log"] = $element->getVal();
        }
    }
    /**
     * listagem de itens
     */
    protected function carregarMaisAjax()
    {
        // ----------- Alteri as linhas abaixo -----------
        //$userId = $this->ajax["filtro"]["usuarios"];
        //$periodo =  $this->ajax["filtro"]["periodo"];
        $userId = $this->ajax["filtro"]["usuarios"];
        $periodo =  $this->ajax["filtro"]["periodo"];
        //\AckCore\Utils::dg($this->ajax);
        $where = $config["where"];

        if(!empty($userId))
            $where["usuario"] = $userId;

        if(!empty($periodo))
            $where["DATE(data) >= "] = date("Y-m-d",strtotime("-$periodo day"));

        $config = $this->getSpecificConfig();

        $this->beforeRun($config);
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

        $resultObjects = $this->loadMoreOnQuery($where,$params,$config);
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
            }
        }

        if (count($result["grupo"]) < $limite) {
            $result['exibir_botao'] = 0;
        } else {
            $result['exibir_botao'] = 1;
        }

        $this->beforeReturn();
        echo json_encode($result);

        return $this->response;
    }
}
