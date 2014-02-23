<?php
/**
 * modelo de dados gerais
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
use \AckMvc\Controller\TableRowAutomatorAbstract;
use \AckCore\Model\Languages,
    \AckLocale\Model\Addresses,
    \AckCore\Model\Metatags;

class DadosgeraisController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=> "\AckCore\Model\Systems");
    protected $title =  "Dados Gerais";
    protected $config = array(
        "global"=>array(
            "visibleCol"=>"visible",
            "metatags"=>true,
            "disableBack"=>true,
            "metatagsExpansion"=>true,
            "idiomas"=>true,
            "metatagId" => Metatags::DEFAULT_SYSTEM_META_ID,
            "elementsSettings" => array(
                "publicado" =>array("type"=>"BooleanSelect"),
                "email" => array("permission"=>"+r"),
                "construcao" => array("type"=>"BooleanSelect"),
                "nome_site" => array("type" => "Input"),
            ),
        ),
        "editar" => array(
            "blacklist" => array(
                "paypalusername",
                "paypalpassword",
                "paypalstatus",
                "paypalsignature",
                "id",
                "publicado",
                "construcao",
                "email"
            ),
        ),
    );

    public function visivelAction()
    {
        $model = new Languages();
        $visible = $model->getVisibleCol();

        $set = array();

        if((int) $this->ajax["status"] == $visible["enabled"])
            $set[$visible["name"]] = 1;
        else
            $set[$visible["name"]] = 0;

        $where = array("id"=>$this->ajax["id"]);
        $result = null;
        try {
            $result = $model->update($set,$where);
        } catch (\Exception $e) {
            throw new \Exception("a coluna visível não foi corretamente setada");
        }
        $result = array("status"=>1,"mensagem"=>"Visível alterado");
        \AckCore\Utils\Ajax::notifyEnd($result);
    }

    public function getCategoryData(&$config)
    {
        $row =& $config["row"];
        //só adiciona este campo se for em um editar
        if ($row->getId()->getBruteVal()) {
            if (\AckAcl\PermissionTester::isAllowed("view","\AckLocale\Model\Addresses")) {
                $config["address"] = Addresses::getDefault();
            }
        }
    }
}
