<?php
/**
 * adiciona funcionalidades à modelos cujas tabelas se relacionam com outra de modo a
 * estabelecer uma hierarquiaa, este arquivo adiciona recurosos à modolos que recebem
 * a prestação do serviço de hierarquia
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 3
 * @copyright  Copyright (C) CUB
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */
namespace AckDb\Model;
use AckDb\ZF1\RowAbstract as Row;
abstract class RowHierarchyRelated extends Row
{
    protected static $cache;

    /**
     * da apend de uma entidade em outra
     * @param RowHierarchy $child [description]
     */
    public function addChild(RowHierarchyRelated $child)
    {

        //cria uma entrada de relacionamento
        $hierarchyTableModel = $this->getHierarchyModelInstance();
        $set = array(
                        $hierarchyTableModel->getMasterColumn()=>$this->getId()->getBruteVal(),
                        $hierarchyTableModel->getSlaveColumn()=>$child->getId()->getBruteVal(),
                    );

        $hierarchyTableModel->delete($set);
        $result = $hierarchyTableModel->create($set);

        if(!$result) throw new \Exception("Não foi possível relacionar o pai com o filho", 1);

        return $this;
    }

    /**
     * remove os pais ligados diretametne com esta linha
     * @return [type] [description]
     */
    public function removeParents()
    {
        //cria uma entrada de relacionamento
        $hierarchyTableModel = $this->getHierarchyModelInstance();
        $where = array(
                        $hierarchyTableModel->getSlaveColumn()=>$this->getId()->getBruteVal(),
                    );

        $result = $hierarchyTableModel->delete($where);
        if(!$result) throw new \Exception("Não foi possível remover o pai do filho", 1);

        return $this;
    }

    /**
     * retorna as entidades pais de uma entidade
     * @return [type] [description]
     */
    public function getParents()
    {
        if(!$this->getId()->getBruteVal()) throw new \Exception("Não foi possível encontrar o id da entidade que solicita os pais.", 1);

        $result = array();

        $hierarchyTableModel = $this->getHierarchyModelInstance();
        $where = array($hierarchyTableModel->getSlaveColumn()=>$this->getId()->getBruteVal());
        $hierarchyEntitys = $hierarchyTableModel->toObject()->get($where);

        //prepara  o método para pegar a coluna master
        $masterColumn = $hierarchyTableModel->getMasterColumn();
        $masterColumn = "get".$masterColumn;
        $masterColumn = str_replace("_", "", $masterColumn);

        $mastersIds = array();

        foreach ($hierarchyEntitys as $hierarchyEntity) {

            $masterId = $hierarchyEntity->$masterColumn()->getBruteVal();
            if(in_array($masterId, $mastersIds)) continue;
            else $mastersIds[] = $masterId;

            if ($masterId) {
                $entity = $this->getTableInstance()->toObject()->getOne(array("id"=>$hierarchyEntity->$masterColumn()->getBruteVal()));
                $result = array_merge($result,array($entity));
               if($entity->getParents()) $result = array_merge($result,$entity->getParents());
            }
        }

        return $result;
    }

    /**
     * retorna as entidades pais de uma entidade
     * @return [type] [description]
     */
    public function getChildren()
    {
        if(!$this->getId()->getBruteVal()) throw new \Exception("Não foi possível encontrar o id da entidade que solicita os pais.", 1);
        $result = array();

        $hierarchyTableModel = $this->getHierarchyModelInstance();
        $where = array($hierarchyTableModel->getMasterColumn()=>$this->getId()->getBruteVal());
        $hierarchyEntitys = $hierarchyTableModel->toObject()->get($where);

        //prepara  o método para pegar a coluna master
        $slaveColumn = $hierarchyTableModel->getSlaveColumn();
        $slaveColumn = "get".$slaveColumn;
        $slaveColumn = str_replace("_", "", $slaveColumn);

        $mastersIds = array();

        foreach ($hierarchyEntitys as $hierarchyEntity) {

            $slaveId = $hierarchyEntity->$slaveColumn()->getBruteVal();
            if(in_array($slaveId, $mastersIds)) continue;
            else $mastersIds[] = $slaveId;

            if ($slaveId) {
                $entity = $this->getTableInstance()->toObject()->getOne(array("id"=>$hierarchyEntity->$slaveColumn()->getBruteVal()));
                $result = array_merge($result,array($entity));
               if($entity->getParents()) $result = array_merge($result,$entity->getParents());
            }
        }

        return $result;
    }

    //###################################################################################
    //################################# getters and setters ###########################################
    //###################################################################################

    public function getHierarchyModelInstance()
    {
        $result = $this->getTableInstance()->getHierarchyModelInstance();
        $result =  new $result;

        return $result;
    }
    //###################################################################################
    //################################# END getters and setters ########################################
    //###################################################################################
}
