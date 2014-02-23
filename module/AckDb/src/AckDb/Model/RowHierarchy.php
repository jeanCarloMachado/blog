<?php
/**
 * funções hierárquicas para modelos de linhas
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
namespace AckDb\Model;
use AckDb\ZF1\RowAbstract;
abstract class RowHierarchy extends RowAbstract
{
    /**
     * testa se o objeto tem algum filho
     * @return boolean [description]
     */
    public function hasChild($hierarchyObjectName = "\AckProducts\Model\CategorysHierarchys")
    {
        $modelNN = new $hierarchyObjectName;
        $result = $modelNN->get(array($this->getMasterCell()=>$this->getId()->getBruteVal()),array("count"=>array("offset"=>0,"total"=>1)));

        if(!empty($result)) return true;

        return false;
    }

    public function getChildren($hierarchyObjectName = "\AckProducts\Model\CategorysHierarchys")
    {
        return $this->getChilds($hierarchyObjectName);
    }

    /**
     * MUDAR ESSA PORRA!
     * pega os filhos do objeto
     * @return [type] [description]
     */
    public function getChilds($hierarchyObjectName = "\AckProducts\Model\CategorysHierarchys")
    {
        $modelNN = new $hierarchyObjectName;

        if(!$this->getId()->getBruteVal()) return false;

        $resultRelations = $modelNN->get(array($this->getMasterCell()=>$this->getId()->getBruteVal()));

        if(empty($resultRelations)) return false;

        $result = array();
        $classnName = $this->getTableModelName();
        $modelChilds = new $classnName;

        foreach ($resultRelations as $relation) {
            $result[] = $modelChilds->toObject()->onlyAvailable()->getOne(array("id"=>$relation[$this->getSlaveCell()]));
        }

        return $result;
    }

    /**
     * retorna apenas os possíveis filhos de uma categoria
     */
    public function getOnlyPotentialChilds($hierarchyObjectName = "\AckProducts\Model\CategorysHierarchys")
    {
        if(!$this->getId()->getBruteVal()) return false;

        $result = null;
        //pega as categorias a qual a categoria atual ja é filha
        $modelHierarchy = new $hierarchyObjectName;
        $whereHierarchy =  array($this->getSlaveCell()=>$this->getId()->getBruteVal());
        $resultHierarchy = $modelHierarchy->toObject()->get($whereHierarchy);

        //pega as categorias diferentes desta
        $modelName = $this->getModelName();
        $model = new \AckProducts\Model\Categorys;
        $where = array("id !=" => $this->getId()->getBruteVal());
        $result = $model->onlyNotDeleted()->toObject()->get($where);

        //remove os elemetos que na hierarquia são pais deste
        assert(0,"possível problema de performance");
        assert(0,"não está sendo tratado os elementos que são pais dos pais deste e assim sucessivamente");

        foreach ($result as $elementId => $element) {
            foreach ($resultHierarchy as $elementHierarchy) {
                if ($element->getId()->getBruteVal() == $elementHierarchy->getmasterid()->getBruteVal()) {
                    unset($result[$elementId]);
                    break;
                }
            }
        }

        return (empty($result)) ? null : $result;
    }

    public function getMasterCell()
    {
        return $this->getTableInstance()->getMasterColumn();
    }

    public function getSlaveCell()
    {
        return $this->getTableInstance()->getSlaveColumn();
    }

}
