<?php
/**
 * representa uma entragda de categoria
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
namespace AckProducts\Model;
use AckDb\Model\RowHierarchy;
class Category extends RowHierarchy
{
	protected $_table = "\AckProducts\Model\Categorys";
	/**
	 * pega as relações de categorias relacionadas ao id de categorias passado
	 * @param  [type]  $categoryId            [description]
	 * @param  [type]  $bucket                [description]
	 * @param  integer $categoryPassedIsSlave [description]
	 * @return [type]                         [description]
	 */
	public function getCategoryRecursiveRelations($categoryId, &$bucket ,$categoryPassedIsSlave = 1)
	{
		//esta função foi mudada de lugar e reide aqui simplesmente por compatibilidade
		$instance = $this->getTableInstance();
		$instance->getCategoryRecursiveRelations($categoryId,$bucket ,$categoryPassedIsSlave);
	}
	/**
	 * retorna os produtos relacionados com
	 * a cateogoria em questão
	 * @return [type] [description]
	 */
	public function getMyProducts()
	{
		$products = $this->seekMyNNProducts("\AckProducts\Model\ProductsCategorys","categorias_id","produtos_id",null,"\AckProducts\Model\\");
		return $products;
	}

	/**
     * pega os filhos do objeto essa função foi sobrrescrita para dar
     * sort dos ekementos alfabeticamente
     *
     * @param string $hierarchyObjectName nome do objeto
     *
     * @return array Objects
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

        	$tmp = $modelChilds->toObject()->onlyAvailable()->getOne(array("id"=>$relation[$this->getSlaveCell()]));
            $result[$tmp->getNome()->getBruteVal()] = $tmp;
        }
        ksort($result);
        return $result;
    }

    /**
     * pega os filhos do objeto essa função foi sobrrescrita para dar
     * sort dos ekementos alfabeticamente para o ack (onlyNotDeleted)
     *
     * @param string $hierarchyObjectName nome do objeto
     *
     * @return array Objects
     */
    public function getChildrenForAck($hierarchyObjectName = "\AckProducts\Model\CategorysHierarchys")
    {
        $modelNN = new $hierarchyObjectName;

        if(!$this->getId()->getBruteVal()) return false;

        $resultRelations = $modelNN->get(array($this->getMasterCell()=>$this->getId()->getBruteVal()));

        if(empty($resultRelations)) return false;

        $result = array();
        $classnName = $this->getTableModelName();
        $modelChilds = new $classnName;

        foreach ($resultRelations as $relation) {

            $tmp = $modelChilds->toObject()->onlyNotDeleted()->getOne(array("id"=>$relation[$this->getSlaveCell()]));
            $result[$tmp->getNome()->getBruteVal()] = $tmp;
        }
        ksort($result);

        return $result;
    }

    /**
     * pega os filhos do objeto essa função foi sobrrescrita para dar
     * sort dos ekementos alfabeticamente
     *
     * @param string $hierarchyObjectName nome do objeto
     *
     * @return array Objects
     */
    public function hasChildren($hierarchyObjectName = "\AckProducts\Model\CategorysHierarchys")
    {
        $modelNN = new $hierarchyObjectName;

        if(!$this->getId()->getBruteVal()) return false;

        $resultRelations = $modelNN->get(array($this->getMasterCell()=>$this->getId()->getBruteVal()));

        if(empty($resultRelations)) return false;

        return true;
    }
}
