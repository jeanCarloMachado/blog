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
use AckDb\ZF1\TableAbstract as Table;
abstract class TableHierarchyRelated extends Table
{
    /**
     * modelo de tabela de uma entidade de hierarquia
     * @var [type]
     */
    protected $hierarchyModel;

    //###################################################################################
    //################################# getters and setters ###########################################
    //###################################################################################

    public function getHierarchyModel()
    {
        if(empty($this->hierarchyModel)) throw new \Exception("O nome do modelo relacionado de hierarquia não foi disponibilizado!");

        return $this->hierarchyModel;
    }

    public function setHierarchyModel($hierarchyModel)
    {
        $this->hierarchyModel = $hierarchyModel;

        return $this;
    }

    public function getHierarchyModelInstance()
    {
        $name = $this->getHierarchyModel();

        return new $name;
    }
    //###################################################################################
    //################################# END getters and setters ########################################
    //###################################################################################
}
