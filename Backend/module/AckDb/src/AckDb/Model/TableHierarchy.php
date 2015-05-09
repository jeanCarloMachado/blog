<?php
/**
 * modelo base para tabelas com funcionalidades hierárquicas
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
namespace AckDb\Model;
use AckDb\ZF1\TableAbstract;
abstract class TableHierarchy extends TableAbstract
{
    protected $masterColumn = "master_id";
    protected $slaveColumn = "slave_id";

    /**
     * retorna somente objetos que são somente pais
     * @return [type] [description]
     */
    public function getOnlyParents($hierarchyObjectName = "\AckProducts\Model\CategorysHierarchys")
    {
        $result =  $this->toObject()->onlyAvailable()->get(array(),array("ordem"=>"nome ASC"));

        $modelHierarchys = new $hierarchyObjectName;
        $hierarchys = $modelHierarchys->toObject()->onlyAvailable()->get();

        foreach ($result as $key => $element) {

            foreach ($hierarchys as $hierarchy) {
                if ($element->getId()->getBruteVal()==$hierarchy->getSlaveId()->getBruteVal()) {
                    unset($result[$key]);
                    break;
                }
            }
        }

        return $result;
    }
    //###################################################################################
    //################################# getters and setters ###########################################
    //###################################################################################
    public function getMasterColumn()
    {
        return $this->masterColumn;
    }

    public function setMasterColumn($masterColumn)
    {
        $this->masterColumn = $masterColumn;

        return $this;
    }

    public function getSlaveColumn()
    {
        return $this->slaveColumn;
    }

    public function setSlaveColumn($slaveColumn)
    {
        $this->slaveColumn = $slaveColumn;

        return $this;
    }
    //###################################################################################
    //################################# END getters and setters ########################################
    //###################################################################################

}
